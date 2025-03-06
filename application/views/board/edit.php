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
                <input type="password" name="password" id="password" required>
            </div>
            
            <div class="form-group">
                <label for="content">내용</label>
                <textarea name="content" id="content" required><?php echo set_value('content', $post->content); ?></textarea>
            </div>
            
            <div class="form-group">
                <button type="submit">수정</button>
                <a href="<?php echo site_url('board/view/'.$post->id); ?>">취소</a>
            </div>
        <?php echo form_close(); ?>
    </div>
</body>
</html> 