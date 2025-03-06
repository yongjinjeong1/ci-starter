<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>게시글 삭제</title>
</head>
<body>
    <script>
        (function() {
            var password = prompt('비밀번호를 입력하세요.');
            if(password) {
                var form = document.createElement('form');
                form.method = 'POST';
                form.action = '<?php echo site_url('board/delete/' . $id); ?>';
                
                var input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'password';
                input.value = password;
                
                form.appendChild(input);
                document.body.appendChild(form);
                form.submit();
            } else {
                history.back();
            }
        })();
    </script>
</body>
</html> 