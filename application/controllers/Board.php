<?
// BASEPATH가 정해지지 않으면 실행 중지, 파일을 직접 URL로 실행하는 것 제한(CodeIgniter 내부에서만 실행되도록 제한)
defined('BASEPATH') OR exit('No direct script access allowed');

//CI_Controller를 상속받아 컨트롤러 역할, 모델을 통해 데이터 처리하고 뷰에 전달함 
class Board extends CI_Controller {
    
    // 생성 및 모델 불러 옴, 폼 및 URL 사용 가능(CodeIgniter 프레임워크)
    public function __construct() {
        parent::__construct();
        $this->load->model('board_model');
        $this->load->helper(['url', 'form']);
        $this->load->library(['form_validation', 'session']);

        // 프로파일러란? 애플리케이션의 성능을 분석하고 디버깅하는 도구
        // 특정 요청에서 쿼리 실행 시간, 로드된 파일, 세션 데이터, POST/GET 데이터 같은 정보를 확인할 수 있다.
        $this->output->enable_profiler(TRUE);
    }

    // 페이지네이션, 한 페이지 당 20개씩
    public function index($page = 1) {
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $data['posts'] = $this->board_model->get_posts($limit, $offset);
        $data['total_pages'] = ceil($this->board_model->count_posts() / $limit);
        $this->load->view('board/list', $data);
    }

    // 게시글 작성 페이지
    public function write($parent_id = 0) {
        $data['parent_id'] = $parent_id;
        $this->load->view('board/write', $data);
    }

    // 게시글 저장(제목, 내용, 작성자, 비밀번호)
    public function store() {
        $this->form_validation->set_rules('title', '제목', 'required');
        $this->form_validation->set_rules('content', '내용', 'required');
        $this->form_validation->set_rules('writer', '작성자', 'required');
        $this->form_validation->set_rules('password', '비밀번호', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->load->view('board/write');
            return;
        }

        // 게시글 작성시 들어가는 값
        $data = [
            'parent_id' => $this->input->post('parent_id', true) ?? 0,
            'title' => $this->input->post('title', true),
            'content' => $this->input->post('content', true),
            'writer' => $this->input->post('writer', true),
            'password' => password_hash($this->input->post('password', true), PASSWORD_DEFAULT)
        ];
        
        // 게시글 작성 로직 :
        // 기존 게시글 중 가장 큰 order_no를 찾아서 +1 한 값으로 설정
        // 답글 작성 로직 :
        // 부모 게시글의 깊이(depth) 값을 기준으로 +1로 설정, 부모보다 뒤에 있는 게시글들의 order_no 값을 +1씩 증가시킴
        // 부모의 order_no 값보다 하나 큰 +1 값으로 설정
        if ($data['parent_id'] > 0) {
            $parent = $this->board_model->get_post($data['parent_id']);
            if ($parent) {
                $data['depth'] = $parent->depth + 1;
                $this->board_model->update_order_numbers($parent->order_no);
                $data['order_no'] = $parent->order_no + 1;
            }
        } else {
            $data['order_no'] = $this->board_model->get_max_order_no() + 1;
        }
        
        $this->board_model->create_post($data);
        redirect('board');
    }

    // 조회수 증가
    public function view($id) {
        $data['post'] = $this->board_model->get_post($id);
        $this->board_model->increase_hits($id);
        $this->load->view('board/view', $data);
    }

    // 수정 화면
    public function edit($id) {
        $data['post'] = $this->board_model->get_post($id);
        $this->load->view('board/edit', $data);
    }

    // 수정 상세 처리
    public function update($id) {
        $this->form_validation->set_rules('title', '제목', 'required');
        $this->form_validation->set_rules('content', '내용', 'required');
        $this->form_validation->set_rules('password', '비밀번호', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->edit($id);
            return;
        }

        // 비밀번호 검증
        $post = $this->board_model->get_post($id);
        if (!password_verify($this->input->post('password'), $post->password)) {
            $data['error'] = '비밀번호가 일치하지 않습니다.';
            $data['post'] = $post;
            $this->load->view('board/edit', $data);
            return;
        }

        // 게시글 수정(업데이트트)
        $data = [
            'title' => $this->input->post('title', true),
            'content' => $this->input->post('content', true),
            'updated_at' => date('Y-m-d H:i:s')
        ];

        $this->board_model->update_post($id, $data);
        redirect('board/view/' . $id);
    }

    // 게시글 삭제
    public function delete($id) {
        $password = $this->input->post('password');
        $post = $this->board_model->get_post($id);

        // 게시글이 존재하는지 확인
        if (!$post) {
            $data = [
                'message' => '존재하지 않는 게시글입니다.',
                'redirect' => 'board'
            ];
            $this->load->view('board/message', $data);
            return;
        }

        // 비밀번호가 전송되지 않은 경우
        if (!$password) {
            $data['id'] = $id;
            $this->load->view('board/delete', $data);
            return;
        }

        // 비밀번호 검증
        if (!password_verify($password, $post->password)) {
            $data = [
                'message' => '비밀번호가 일치하지 않습니다.',
                'redirect' => 'board/view/' . $id
            ];
            $this->load->view('board/message', $data);
            return;
        }

        $result = false;
        if ($post->parent_id == 0) {
            $result = $this->board_model->delete_with_replies($id);
        } else {
            $result = $this->board_model->delete_post($id);
        }
        
        if ($result) {
            $this->session->set_flashdata('message', '게시글이 삭제되었습니다.');
            redirect('board');
        } else {
            $data = [
                'message' => '게시글 삭제에 실패했습니다.',
                'redirect' => 'board/view/' . $id
            ];
            $this->load->view('board/message', $data);
        }
    }

    // 게시글 검색
    public function search($page = 1) {
        $keyword = $this->input->get('keyword');
        $limit = 10;
        $offset = ($page - 1) * $limit;
        
        $data['posts'] = $this->board_model->search_posts($keyword, $limit, $offset);
        $total_posts = $this->board_model->count_search_posts($keyword);
        $data['total_pages'] = ceil($total_posts / $limit);
        
        $this->load->view('board/list', $data);
    }
} 