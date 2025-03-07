<!DOCTYPE html>
<html>
<head>
    <meta charset='utf-8'>
    <title>게시글 삭제</title>
</head>
<body>
<<<<<<< HEAD
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title">게시글 삭제</h5>
                    </div>
                    <div class="card-body">
                        <form action="<?= site_url('board/delete/'.$id) ?>" method="post">
                            <div class="form-group mb-3">
                                <label>삭제 방식 선택:</label>
                                <div class="form-check mt-2">
                                    <input type="radio" id="hardDelete" name="delete_type" value="hard" class="form-check-input" checked>
                                    <label class="form-check-label" for="hardDelete">삭제(물리)</label>
                                </div>
                                <div class="form-check mt-2">
                                    <input type="radio" id="softDelete" name="delete_type" value="soft" class="form-check-input">
                                    <label class="form-check-label" for="softDelete">비공개(논리)</label>
                                </div>
                            </div>
                            <div class="form-group mb-3">
                                <label for="password">비밀번호</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="d-flex justify-content-between">
                                <a href="<?= site_url('board/view/'.$id) ?>" class="btn btn-secondary">취소</a>
                                <button type="submit" class="btn btn-danger">삭제</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
=======
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
>>>>>>> ab9a1cc4126fbea9907781ca063927e4e068f589
</body>
</html> 