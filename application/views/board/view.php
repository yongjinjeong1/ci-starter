<!DOCTYPE html>
<html>
<head>
    <title>게시글 보기</title>
    <style>
        .container { 
            width: 80%; 
            margin: 20px auto; 
        }
        .post-header {
            border-bottom: 2px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .post-info {
            color: #666;
            font-size: 0.9em;
            margin: 10px 0;
        }
        .post-content {
            min-height: 200px;
            padding: 20px;
            border: 1px solid #ddd;
            margin: 20px 0;
        }
        .button-group {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #ddd;
        }
        .button-group a {
            display: inline-block;
            padding: 5px 15px;
            background: #f0f0f0;
            border: 1px solid #ddd;
            text-decoration: none;
            color: #333;
            margin-right: 10px;
        }
        .button-group a:hover {
            background: #e0e0e0;
        }
        .prev-next-posts {
            margin: 20px 0;
        }
        .prev-next-posts table {
            border-top: 1px solid #ddd;
            border-bottom: 1px solid #ddd;
        }
        .prev-next-posts th {
            background-color: #f8f9fa;
            text-align: center;
        }
        .prev-next-posts td {
            padding: 10px;
        }
        .prev-next-posts a {
            color: #333;
            text-decoration: none;
        }
        .prev-next-posts a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="post-header">
            <h2><?php echo htmlspecialchars($post->title); ?></h2>
            <div class="post-info">
                <span>작성자: <?php echo htmlspecialchars($post->writer); ?></span> | 
                <span>조회수: <?php echo $post->hits; ?></span> | 
                <span>작성일: <?php echo date('Y-m-d H:i', strtotime($post->created_at)); ?></span>
                <?php if($post->updated_at != $post->created_at): ?>
                    | <span>수정일: <?php echo date('Y-m-d H:i', strtotime($post->updated_at)); ?></span>
                <?php endif; ?>
            </div>
        </div>

        <div class="post-content">
            <?php echo nl2br(htmlspecialchars($post->content)); ?>
        </div>

        <div class="prev-next-posts">
            <table class="table">
                <tr>
                    <th width="100">이전글</th>
                    <td>
                        <?php if ($prev_post): ?>
                            <a href="<?= site_url('board/view/' . $prev_post->id) ?>">
                                <?= htmlspecialchars($prev_post->title) ?>
                            </a>
                        <?php else: ?>
                            이전글이 없습니다.
                        <?php endif; ?>
                    </td>
                </tr>
                <tr>
                    <th>다음글</th>
                    <td>
                        <?php if ($next_post): ?>
                            <a href="<?= site_url('board/view/' . $next_post->id) ?>">
                                <?= htmlspecialchars($next_post->title) ?>
                            </a>
                        <?php else: ?>
                            다음글이 없습니다.
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>

        <div class="button-group">
            <a href="<?php echo site_url('board'); ?>">목록</a>
            <a href="<?php echo site_url('board/write/'.$post->id); ?>">답글</a>
            <a href="<?php echo site_url('board/edit/'.$post->id); ?>">수정</a>
            <a href="<?php echo site_url('board/delete/'.$post->id); ?>" 
               onclick="return confirm('정말 삭제하시겠습니까?');">삭제</a>
        </div>
    </div>
</body>
</html> 