<?
// BASEPATH가 정해지지 않으면 실행 중지, 파일을 직접 URL로 실행하는 것 제한(CodeIgniter 내부에서만 실행되도록 제한)
defined('BASEPATH') OR exit('No direct script access allowed');

//CI_Controller를 상속받아 컨트롤러 역할, 모델을 통해 데이터 처리하고 뷰에 전달함 
<<<<<<< HEAD
class Board extends MY_Controller {
=======
class Board extends CI_Controller {
>>>>>>> ab9a1cc4126fbea9907781ca063927e4e068f589
    
    // 생성 및 모델 불러 옴, 폼 및 URL 사용 가능(CodeIgniter 프레임워크)
    public function __construct() {
        parent::__construct();
        $this->load->model('board_model');
        $this->load->helper(['url', 'form']);
        $this->load->library(['form_validation', 'session']);
<<<<<<< HEAD
        

        // 프로파일러란? 애플리케이션의 성능을 분석하고 디버깅하는 도구
        // 특정 요청에서 쿼리 실행 시간, 로드된 파일, 세션 데이터, POST/GET 데이터 같은 정보를 확인할 수 있다.
=======

        // 프로파일러란? 애플리케이션의 성능을 분석하고 디버깅하는 도구
        // 특정 요청에서 쿼리 실행 시간, 로드된 파일, 세션 데이터, POST/GET 데이터 같은 정보를 확인할 수 있다.
        $this->output->enable_profiler(TRUE);
>>>>>>> ab9a1cc4126fbea9907781ca063927e4e068f589
    }

    // 페이지네이션, 한 페이지 당 20개씩
    public function index($page = 1) {
<<<<<<< HEAD
        // 페이지당 게시글 수 (기본값 20)
        $limit = $this->input->get('per_page') ? (int)$this->input->get('per_page') : 20;
        $offset = ($page - 1) * $limit;
        
        $data['posts'] = $this->board_model->get_posts($limit, $offset);
        $data['total_pages'] = ceil($this->board_model->count_posts() / $limit);
        
        // 페이지네이션 URL에 per_page 파라미터 추가
        $data['pagination_url'] = 'board/index/';
        if($this->input->get('per_page')) {
            $data['pagination_url'] .= '?per_page=' . $this->input->get('per_page');
        }
        
        $this->_render_page('board/list', $data);
=======
        $limit = 20;
        $offset = ($page - 1) * $limit;
        $data['posts'] = $this->board_model->get_posts($limit, $offset);
        $data['total_pages'] = ceil($this->board_model->count_posts() / $limit);
        $this->load->view('board/list', $data);
>>>>>>> ab9a1cc4126fbea9907781ca063927e4e068f589
    }

    // 게시글 작성 페이지
    public function write($parent_id = 0) {
        $data['parent_id'] = $parent_id;
<<<<<<< HEAD
        $this->_render_page('board/write', $data);
=======
        $this->load->view('board/write', $data);
>>>>>>> ab9a1cc4126fbea9907781ca063927e4e068f589
    }

    // 게시글 저장(제목, 내용, 작성자, 비밀번호)
    public function store() {
        $this->form_validation->set_rules('title', '제목', 'required');
        $this->form_validation->set_rules('content', '내용', 'required');
        $this->form_validation->set_rules('writer', '작성자', 'required');
        $this->form_validation->set_rules('password', '비밀번호', 'required');

        if ($this->form_validation->run() === FALSE) {
<<<<<<< HEAD
            $this->_render_page('board/write');
=======
            $this->load->view('board/write');
>>>>>>> ab9a1cc4126fbea9907781ca063927e4e068f589
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
<<<<<<< HEAD

        
=======
>>>>>>> ab9a1cc4126fbea9907781ca063927e4e068f589
        
        // 게시글 작성 로직 :
        // 기존 게시글 중 가장 큰 order_no를 찾아서 +1 한 값으로 설정
        // 답글 작성 로직 :
        // 부모 게시글의 깊이(depth) 값을 기준으로 +1로 설정, 부모보다 뒤에 있는 게시글들의 order_no 값을 +1씩 증가시킴
        // 부모의 order_no 값보다 하나 큰 +1 값으로 설정
<<<<<<< HEAD
        // **최상위 게시글(부모가 없는 글)인 경우**
        if ($data['parent_id'] == 0) {
            $data['ref'] = $this->board_model->get_max_ref() + 1; // 가장 큰 ref 값 + 1
            $data['order_no'] = $this->board_model->get_max_order_no() + 1;
        } 
        // **답글(부모 글이 존재하는 경우)**
        else {
            $parent = $this->board_model->get_post($data['parent_id']);
            if ($parent) {
                $data['depth'] = $parent->depth + 1;
                $data['ref'] = $parent->ref; // 부모의 ref 값을 상속
                $this->board_model->update_order_numbers($parent->order_no);
                $data['order_no'] = $parent->order_no + 1;
            }
=======
        if ($data['parent_id'] > 0) {
            $parent = $this->board_model->get_post($data['parent_id']);
            if ($parent) {
                $data['depth'] = $parent->depth + 1;
                $this->board_model->update_order_numbers($parent->order_no);
                $data['order_no'] = $parent->order_no + 1;
            }
        } else {
            $data['order_no'] = $this->board_model->get_max_order_no() + 1;
>>>>>>> ab9a1cc4126fbea9907781ca063927e4e068f589
        }
        
        $this->board_model->create_post($data);
        redirect('board');
    }

    // 조회수 증가
    public function view($id) {
<<<<<<< HEAD
        // 현재 게시글 정보 가져오기
        $data['post'] = $this->board_model->get_post($id);
        
        if (!$data['post']) {
            $this->session->set_flashdata('error', '존재하지 않는 게시글입니다.');
            redirect('board');
            return;
        }

        // 이전글, 다음글 정보 가져오기
        $data['prev_post'] = $this->board_model->get_prev_post($data['post']->order_no);
        $data['next_post'] = $this->board_model->get_next_post($data['post']->order_no);
        
        // 조회수 증가
        $this->board_model->increase_hits($id);
        
        $this->_render_page('board/view', $data);
=======
        $data['post'] = $this->board_model->get_post($id);
        $this->board_model->increase_hits($id);
        $this->load->view('board/view', $data);
>>>>>>> ab9a1cc4126fbea9907781ca063927e4e068f589
    }

    // 수정 화면
    public function edit($id) {
        $data['post'] = $this->board_model->get_post($id);
<<<<<<< HEAD
        $this->_render_page('board/edit', $data);
=======
        $this->load->view('board/edit', $data);
>>>>>>> ab9a1cc4126fbea9907781ca063927e4e068f589
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
<<<<<<< HEAD
            $this->_render_page('board/edit', $data);
=======
            $this->load->view('board/edit', $data);
>>>>>>> ab9a1cc4126fbea9907781ca063927e4e068f589
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
<<<<<<< HEAD
        $delete_type = $this->input->post('delete_type');
=======
>>>>>>> ab9a1cc4126fbea9907781ca063927e4e068f589
        $password = $this->input->post('password');
        $post = $this->board_model->get_post($id);

        // 게시글이 존재하는지 확인
        if (!$post) {
<<<<<<< HEAD
            $this->session->set_flashdata('error', '존재하지 않는 게시글입니다.');
            redirect('board');
            return;
        }

        // 비밀번호가 전송되지 않은 경우 (최초 삭제 버튼 클릭 시)
        if (!$password) {
            $data['id'] = $id;
            $this->_render_page('board/delete', $data);
=======
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
>>>>>>> ab9a1cc4126fbea9907781ca063927e4e068f589
            return;
        }

        // 비밀번호 검증
        if (!password_verify($password, $post->password)) {
<<<<<<< HEAD
            $this->session->set_flashdata('error', '비밀번호가 일치하지 않습니다.');
            redirect('board/view/' . $id);
            return;
        }

        // 삭제 유형에 따른 처리
        if ($delete_type === 'soft') {
            // 논리적 삭제 (비공개 처리)
            $result = $this->board_model->soft_delete_post($id);
            $message = '게시글이 비공개 처리되었습니다.';
            $error_message = '게시글 비공개 처리에 실패했습니다.';
        } else {
            // 물리적 삭제 (완전 삭제)
            $result = $this->board_model->delete_post($id);
            $message = '게시글이 삭제되었습니다.';
            $error_message = '게시글 삭제에 실패했습니다.';
        }

        if ($result) {
            $this->session->set_flashdata('message', $message);
            redirect('board');
        } else {
            $this->session->set_flashdata('error', $error_message);
            redirect('board');
        }
    }


    public function tpltest() {
        $this->template_->viewDefine('layout_common', 'common/layout_common.tpl');
        $this->template_->viewAssign(array(
            "layout_common" => "테스트입니다."
        ));
    }

    

    // 게시글 검색
    public function search($page = 1) {
        $keyword = trim($this->input->get('keyword'));
        $search_type = $this->input->get('search_type') ?? 'all';
        
        // 검색어가 비어있는 경우 처리
        if (empty($keyword)) {
            $this->session->set_flashdata('error', '검색어를 한 글자 이상 입력해주세요.');
            redirect('board');
            return;
        }
        
        $limit = $this->input->get('per_page') ? (int)$this->input->get('per_page') : 20;
        $offset = ($page - 1) * $limit;
        
        $data['posts'] = $this->board_model->search_posts($keyword, $search_type, $limit, $offset);
        $total_posts = $this->board_model->count_search_posts($keyword, $search_type);
        $data['total_pages'] = ceil($total_posts / $limit);
        $data['keyword'] = $keyword;
        $data['search_type'] = $search_type;
        
        $this->_render_page('board/list', $data);
=======
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
>>>>>>> ab9a1cc4126fbea9907781ca063927e4e068f589
    }
} 