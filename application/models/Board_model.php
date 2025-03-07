<?
// controller 때와 마찬가지로 보안 관련, 직접 이동 방지
defined('BASEPATH') OR exit('No direct script access allowed');

class Board_model extends CI_Model {
    
    // 생성자 메서드
    public function __construct() {
        parent::__construct();
        
    }

    // 게시글 목록 조회
    public function get_posts($limit = null, $offset = null) {
        $this->db->order_by('ref', 'DESC');
        $this->db->order_by('order_no', 'ASC');
        if($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        return $this->db->get('board')->result();
    }

    // 전체 게시글 개수(count_all) 조회
    public function count_posts() {
        return $this->db->count_all('board');
    }

    // 게시글 검색 기능(or_like 사용하여 제목, 내용, 작성자 중 하나라도 키워드와 일치하면 결과 포함)
    public function search_posts($keyword, $search_type = 'all', $limit = null, $offset = null) {
        $this->db->select('*');
        $this->db->from('board');
        
        // 검색 조건
        if ($search_type === 'all') {
            $this->db->group_start()
                     ->like('title', $keyword)
                     ->or_like('content', $keyword)
                     ->or_like('writer', $keyword)
                     ->group_end();
        } else {
            $this->db->like($search_type, $keyword);
        }
        
        // 숨김 처리된 게시글 제외
        $this->db->where('is_deleted', 0);
        
        // 원글 먼저, 그 다음 답글 순서로 정렬
        $this->db->order_by('parent_id', 'ASC');
        $this->db->order_by('order_no', 'DESC');
        
        if($limit !== null) {
            $this->db->limit($limit, $offset);
        }
        
        return $this->db->get()->result();
    }

    // 검색된 게시글 개수 조회(count_all_results)
    public function count_search_posts($keyword, $search_type = 'all') {
        if ($search_type === 'all') {
            $this->db->group_start()
                     ->like('title', $keyword)
                     ->or_like('content', $keyword)
                     ->or_like('writer', $keyword)
                     ->group_end();
        } else {
            $this->db->like($search_type, $keyword);
        }
        
        $this->db->where('is_deleted', 0);
        return $this->db->count_all_results('board');
    }

    // *******************************************
    // ** model 로직은 제거함, controller로 옮김 **
    // 게시글 작성 로직 :
    // 기존 게시글 중 가장 큰 order_no를 찾아서 +1 한 값으로 설정
    // 답글 작성 로직 :
    // 부모 게시글의 깊이(depth) 값을 기준으로 +1로 설정, 부모보다 뒤에 있는 게시글들의 order_no 값을 +1씩 증가시킴
    // 부모의 order_no 값보다 하나 큰 값으로 설정
    // *******************************************
    
    public function create_post($data) {
        return $this->db->insert('board', $data);
    }

    // 특정 게시글(id)을 조회하여 반환
    public function get_post($id) {
        return $this->db->get_where('board', ['id' => $id])->row();
    }

    // 조회수 증가(hits), FALSE 옵션을 사용하여 hits +1을 직접 SQL 연산으로 수행
    public function increase_hits($id) {
        $this->db->where('id', $id);
        $this->db->set('hits', 'hits + 1', FALSE);
        return $this->db->update('board');
    }

    // 게시글 수정(update_post)
    public function update_post($id, $data) {
        $this->db->where('id', $id);
        return $this->db->update('board', $data);
    }

    // 게시글 삭제(delete_post)
    // 추가적으로 부모 글이면 자식 글까지 함께 삭제(parent_id == 0)
    // or_where('parent_id', $id) 답글이면 해당 답글만 삭제
    public function delete_post($id) {
        return $this->db->delete('board', ['id' => $id]);
    }

    public function get_max_order_no() {
        $this->db->select_max('order_no');
        return $this->db->get('board')->row()->order_no ?? 0;
    }

    public function update_order_numbers($min_order) {
        return $this->db->set('order_no', 'order_no + 1', FALSE)
                       ->where('order_no >', $min_order)
                       ->update('board');
    }

    public function delete_with_replies($id) {
        return $this->db->where('id', $id)
                       ->or_where('parent_id', $id)
                       ->delete('board');
    }

    // 이전글 가져오기
    public function get_prev_post($order_no) {
        return $this->db
            ->where('order_no <', $order_no)
            ->where('is_deleted', 0)  // hide를 is_deleted로 변경
            ->where('parent_id', 0)
            ->order_by('order_no', 'DESC')
            ->limit(1)
            ->get('board')
            ->row();
    }

    // 다음글 가져오기
    public function get_next_post($order_no) {
        return $this->db
            ->where('order_no >', $order_no)
            ->where('is_deleted', 0)  // hide를 is_deleted로 변경
            ->where('parent_id', 0)
            ->order_by('order_no', 'ASC')
            ->limit(1)
            ->get('board')
            ->row();
    }

    public function get_max_ref() {
        $this->db->select_max('ref');
        $query = $this->db->get('board');
        return $query->row()->ref ?? 0;
    }

    public function soft_delete_post($id) {
        $this->db->where('id', $id);
        return $this->db->update('board', ['is_deleted' => 1]);
    }
} 

/* 정리
get_posts() -> 게시글 목록 조회 (페이징 지원)
count_posts() → 전체 게시글 개수 조회
search_posts() → 게시글 검색 (키워드 포함)
count_search_posts() → 검색된 게시글 개수 조회
create_post() → 게시글 작성 (일반글, 답글 구분)
get_post() → 특정 게시글 조회
increase_hits() → 조회수 증가
update_post() → 게시글 수정
delete_post() → 게시글 삭제 (부모/답글 구분) */