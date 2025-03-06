<!DOCTYPE html>
<html>
<head>
    <title>글쓰기</title>
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
        <h2><?php echo isset($parent_id) && $parent_id > 0 ? '답글 작성' : '새 글 작성'; ?></h2>
        
        <?php if(validation_errors()): ?>
            <div class="error">
                <?php echo validation_errors(); ?>
            </div>
        <?php endif; ?>
        
        <?php echo form_open('board/store'); ?>
            <input type="hidden" name="parent_id" value="<?php echo isset($parent_id) ? $parent_id : 0; ?>">
            
            <div class="form-group">
                <label for="title">제목</label>
                <input type="text" name="title" id="title" value="<?php echo set_value('title'); ?>" required>
            </div>
            
            <div class="form-group">
                <label for="writer">작성자</label>
                <input type="text" name="writer" id="writer" value="<?php echo set_value('writer'); ?>" required>
            </div>

            <div class="form-group">
                <label for="password">비밀번호</label>
                <input type="password" name="password" id="password" required>
            </div>
            
            <div class="form-group">
                <label for="content">내용</label>
                <textarea name="content" id="content" required><?php echo set_value('content'); ?></textarea>
            </div>
            
            <div class="form-group">
                <button type="submit">저장</button>
                <a href="<?php echo site_url('board'); ?>">취소</a>
            </div>
        <?php echo form_close(); ?>
    </div>
</body>
</html> 