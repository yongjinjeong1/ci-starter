<!DOCTYPE html>
<html>
<head>
    <title>글 수정</title>
    <style>
        .container { width: 80%; margin: 20px auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="password"], textarea { 
            width: 100%; 
            padding: 8px; 
            border: 1px solid #ddd; 
        }
        textarea { height: 200px; }
        .error { color: red; margin-bottom: 10px; }
<<<<<<< HEAD
        
        /* 버튼 스타일 수정 */
        .btn {
            display: inline-block;
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-weight: 500;
            text-decoration: none;
            min-width: 80px; /* 최소 너비 설정 */
            text-align: center; /* 텍스트 중앙 정렬 */
        }
        .btn-primary {
            background-color: #007bff;
            color: white;
        }
        .btn-danger {
            background-color: #dc3545;
            color: white;
        }
        .btn-group {
            margin-top: 20px;
            display: flex;
            justify-content: flex-end; /* 오른쪽 정렬로 변경 */
            gap: 10px; /* 버튼 사이 간격 */
        }
=======
>>>>>>> ab9a1cc4126fbea9907781ca063927e4e068f589
    </style>
</head>
<body>
    <div class="container">
        <h2>글 수정</h2>
        
        <?php if(validation_errors()): ?>
            <div class="error">
                <?php echo validation_errors(); ?>
            </div>
        <?php endif; ?>
        
        <?php if(isset($error)): ?>
<<<<<<< HEAD
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>
        
        <form action="<?php echo site_url('board/update/'.$post->id); ?>" method="post">
            <div class="form-group">
                <label for="title">제목</label>
                <input type="text" name="title" id="title" value="<?php echo set_value('title', $post->title); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="password">비밀번호</label>
=======
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php echo form_open('board/update/'.$post->id); ?>
            <div class="form-group">
                <label for="title">제목</label>
                <input type="text" name="title" id="title" 
                       value="<?php echo set_value('title', $post->title); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="password">비밀번호 확인</label>
>>>>>>> ab9a1cc4126fbea9907781ca063927e4e068f589
                <input type="password" name="password" id="password" required>
            </div>
            
            <div class="form-group">
                <label for="content">내용</label>
                <textarea name="content" id="content" required><?php echo set_value('content', $post->content); ?></textarea>
            </div>
            
<<<<<<< HEAD
            <div class="btn-group">
                <button type="submit" class="btn btn-primary">저장</button>
                <a href="<?php echo site_url('board/view/'.$post->id); ?>" class="btn btn-danger">취소</a>
            </div>
        </form>
=======
            <div class="form-group">
                <button type="submit">수정</button>
                <a href="<?php echo site_url('board/view/'.$post->id); ?>">취소</a>
            </div>
        <?php echo form_close(); ?>
>>>>>>> ab9a1cc4126fbea9907781ca063927e4e068f589
    </div>
</body>
</html> 