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