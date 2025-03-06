<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>메시지</title>
</head>
<body>
    <script>
        alert('<?php echo $message; ?>');
        window.location.href = '<?php echo site_url($redirect); ?>';
    </script>
</body>
</html>