<<<<<<< HEAD
<?php if($this->session->flashdata('message')): ?>
    <div class="alert alert-success">
        <?php echo $this->session->flashdata('message'); ?>
    </div>
<?php endif; ?>

<?php if($this->session->flashdata('error')): ?>
    <div class="alert alert-danger">
        <?php echo $this->session->flashdata('error'); ?>
    </div>
<?php endif; ?>

<div class="row" style="margin-top: 0;">
    <div class="col-12" style="padding-top: 0;">
        <h2 style="margin: 0; padding: 0;">게시판</h2>
        <div class="board-header" style="margin-top: 0; padding-top: 0; margin-bottom: 10px;">
            <div style="display: flex; justify-content: space-between; align-items: center;">
                <div></div> <!-- 빈 div로 왼쪽 공간 확보 -->
                <div class="per-page-select">
                    <select name="per_page" onchange="changePerPage(this.value)">
                        <option value="10" <?= $this->input->get('per_page') == '10' ? 'selected' : '' ?>>10개씩 보기</option>
                        <option value="20" <?= ($this->input->get('per_page') == '20' || !$this->input->get('per_page')) ? 'selected' : '' ?>>20개씩 보기</option>
                        <option value="50" <?= $this->input->get('per_page') == '50' ? 'selected' : '' ?>>50개씩 보기</option>
                        <option value="100" <?= $this->input->get('per_page') == '100' ? 'selected' : '' ?>>100개씩 보기</option>
                    </select>
                </div>
            </div>
        </div>

        <table style="margin-top: 0;">
            <thead>
                <tr>
                    <th>번호</th>
                    <th>제목</th>
                    <th>작성자</th>
                    <th>조회수</th>
                    <th>작성일</th>
                </tr>
            </thead>
            <tbody>
                <?php if(isset($posts) && !empty($posts)): ?>
                    <?php foreach($posts as $post): ?>
                        <tr>
                            <td><?php echo $post->id; ?></td>
                            <td>
                                <?php 
                                // 들여쓰기 적용
                                echo str_repeat('<span class="indent"></span>', $post->depth);
                                // 답글인 경우 아이콘 표시
                                if($post->depth > 0) echo '<span class="reply-icon">↳ </span>';
                                ?>
                                <a href="<?php echo site_url('board/view/'.$post->id); ?>">
                                    <?php echo htmlspecialchars($post->title); ?>
                                </a>
                            </td>
                            <td><?php echo htmlspecialchars($post->writer); ?></td>
                            <td><?php echo $post->hits; ?></td>
                            <td><?php echo date('Y-m-d', strtotime($post->created_at)); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" style="text-align: center;">등록된 게시글이 없습니다.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <div class="pagination" style="margin: 20px 0; text-align: center; display: flex; justify-content: center;">
            <?php if(isset($total_pages)): ?>
                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                    <?php 
                    $params = array();
                    if($this->input->get('keyword')) {
                        $params['keyword'] = $this->input->get('keyword');
                        $params['search_type'] = $this->input->get('search_type');
                    }
                    if($this->input->get('per_page')) {
                        $params['per_page'] = $this->input->get('per_page');
                    }
                    
                    $url = site_url('board/search/'.$i.'?'.http_build_query($params));
                    ?>
                    <a href="<?= $url ?>" 
                       class="<?= ($this->uri->segment(3) == $i || ($this->uri->segment(3) == '' && $i == 1)) ? 'active' : '' ?>"
                       style="margin: 0 3px;">
                        <?= $i ?>
                    </a>
                <?php endfor; ?>
            <?php endif; ?>
        </div>

        <div class="search-form" style="margin: 20px 0; text-align: center; display: flex; justify-content: center; align-items: center;">
            <form action="<?= site_url('board/search') ?>" method="get" onsubmit="return validateSearch()" style="display: flex; align-items: center;">
                <div style="position: relative; margin-right: 5px;">
                    <select name="search_type" class="form-control" style="height: 34px; width: auto; padding-right: 25px; appearance: none; -webkit-appearance: none; -moz-appearance: none; background-color: white; cursor: pointer; border: 1px solid #ddd; border-radius: 4px; padding-left: 8px;">
                        <option value="all" <?= $this->input->get('search_type') == 'all' ? 'selected' : '' ?>>전체</option>
                        <option value="title" <?= $this->input->get('search_type') == 'title' ? 'selected' : '' ?>>제목</option>
                        <option value="writer" <?= $this->input->get('search_type') == 'writer' ? 'selected' : '' ?>>작성자</option>
                        <option value="content" <?= $this->input->get('search_type') == 'content' ? 'selected' : '' ?>>내용</option>
                    </select>
                    <div style="position: absolute; right: 8px; top: 50%; transform: translateY(-50%); pointer-events: none;">
                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" fill="#666" viewBox="0 0 16 16">
                            <path d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
                        </svg>
                    </div>
                </div>
                
                <input type="text" name="keyword" id="search_keyword" 
                       value="<?= $this->input->get('keyword') ?>" 
                       placeholder="검색어를 입력하세요"
                       style="margin-right: 5px; height: 34px; width: 200px; border: 1px solid #ddd; border-radius: 4px; padding: 0 8px;">
                
                <?php if($this->input->get('per_page')): ?>
                    <input type="hidden" name="per_page" value="<?= $this->input->get('per_page') ?>">
                <?php endif; ?>
                <button type="submit" style="height: 34px; background-color: #007bff; color: white; border: none; border-radius: 4px; padding: 0 15px; width: auto; white-space: nowrap;">검색</button>
            </form>
        </div>

        <p><a href="<?php echo site_url('board/write'); ?>" class="btn" style="display: inline-block; background-color: #007bff; color: white; text-decoration: none; padding: 8px 15px; border-radius: 4px; font-weight: 500;">글쓰기</a></p>
    </div>
</div>

<script>
function changePerPage(value) {
    // 현재 URL 가져오기
    let currentUrl = new URL(window.location.href);
    let params = new URLSearchParams(currentUrl.search);
    
    // per_page 파라미터 설정
    params.set('per_page', value);
    
    // 페이지 파라미터 초기화 (1페이지로)
    if (params.has('page')) {
        params.delete('page');
    }
    
    // URL 업데이트 및 페이지 이동
    currentUrl.search = params.toString();
    window.location.href = currentUrl.toString();
}

function validateSearch() {
    var keyword = document.getElementById('search_keyword').value.trim();
    if (keyword.length === 0) {
        alert('검색어를 한 글자 이상 입력해주세요.');
        return false;
    }
    return true;
}
</script> 
=======
<!DOCTYPE html>
<html>
<head>
    <title>게시판</title>
    <style>
        .indent { margin-left: 20px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 8px; border: 1px solid #ddd; }
        .reply-icon { color: #666; }
        .pagination {
            margin: 20px 0;
            text-align: center;
        }
        .pagination a {
            display: inline-block;
            padding: 5px 10px;
            margin: 0 2px;
            border: 1px solid #ddd;
            text-decoration: none;
            color: #333;
        }
        .pagination a.active {
            background-color: #007bff;
            color: white;
            border-color: #007bff;
        }
        .search-form {
            margin: 20px 0;
            text-align: center;
        }
        .search-form input[type="text"] {
            padding: 5px;
            width: 200px;
        }
        .search-form button {
            padding: 5px 10px;
            margin-left: 5px;
        }
        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border: 1px solid transparent;
            border-radius: 4px;
        }
        .alert-success {
            color: #155724;
            background-color: #d4edda;
            border-color: #c3e6cb;
        }
        .alert-danger {
            color: #721c24;
            background-color: #f8d7da;
            border-color: #f5c6cb;
        }
    </style>
</head>
<body>
    <?php if($this->session->flashdata('message')): ?>
        <div class="alert alert-success">
            <?php echo $this->session->flashdata('message'); ?>
        </div>
    <?php endif; ?>

    <?php if($this->session->flashdata('error')): ?>
        <div class="alert alert-danger">
            <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php endif; ?>

    <h2>게시판</h2>
    
    <table>
        <thead>
            <tr>
                <th>번호</th>
                <th>제목</th>
                <th>작성자</th>
                <th>조회수</th>
                <th>작성일</th>
            </tr>
        </thead>
        <tbody>
            <?php if(isset($posts) && !empty($posts)): ?>
                <?php foreach($posts as $post): ?>
                    <tr>
                        <td><?php echo $post->id; ?></td>
                        <td>
                            <?php 
                            // 들여쓰기 적용
                            echo str_repeat('<span class="indent"></span>', $post->depth);
                            // 답글인 경우 아이콘 표시
                            if($post->depth > 0) echo '<span class="reply-icon">↳ </span>';
                            ?>
                            <a href="<?php echo site_url('board/view/'.$post->id); ?>">
                                <?php echo htmlspecialchars($post->title); ?>
                            </a>
                        </td>
                        <td><?php echo htmlspecialchars($post->writer); ?></td>
                        <td><?php echo $post->hits; ?></td>
                        <td><?php echo date('Y-m-d', strtotime($post->created_at)); ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" style="text-align: center;">등록된 게시글이 없습니다.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    
    <div class="pagination">
        <?php if(isset($total_pages)): ?>
            <?php for($i = 1; $i <= $total_pages; $i++): ?>
                <?php 
                $url = $this->input->get('keyword') 
                    ? site_url('board/search/'.$i.'?keyword='.$this->input->get('keyword'))
                    : site_url('board/index/'.$i);
                ?>
                <a href="<?php echo $url; ?>" 
                   class="<?php echo ($this->uri->segment(3) == $i || ($this->uri->segment(3) == '' && $i == 1)) ? 'active' : ''; ?>">
                    <?php echo $i; ?>
                </a>
            <?php endfor; ?>
        <?php endif; ?>
    </div>

    <div class="search-form">
        <form action="<?php echo site_url('board/search'); ?>" method="get">
            <input type="text" name="keyword" placeholder="검색어를 입력하세요">
            <button type="submit">검색</button>
        </form>
    </div>

    <p><a href="<?php echo site_url('board/write'); ?>" class="btn">글쓰기</a></p>
</body>
</html> 
>>>>>>> ab9a1cc4126fbea9907781ca063927e4e068f589
