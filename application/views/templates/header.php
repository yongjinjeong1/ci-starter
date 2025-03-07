<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        body {
            margin: 0;
            padding: 0;
            background-color: #f8f9fa;
        }
        
        .navbar-brand {
            font-weight: 700;
            font-size: 1.5rem;
        }
        
        .navbar {
            box-shadow: 0 2px 4px rgba(0,0,0,.1);
            margin-bottom: 0;
            padding: 0.5rem 0;
        }
        
        .main-content {
            padding: 0 !important;
            margin: 0 !important;
        }
        
        .container {
            max-width: 900px;
            padding: 0 15px;
            margin: 0 auto;
        }
        
        .row {
            margin: 0 !important;
        }
        
        .col-12 {
            padding: 0 !important;
        }
        
        h2 {
            margin: 0 !important;
            padding: 10px 0 !important;
        }
        
        .board-header {
            margin: 0 !important;
            padding: 0 !important;
        }
        
        .nav-link {
            font-weight: 500;
            color: #495057;
            transition: color 0.3s ease;
        }
        
        .nav-link:hover {
            color: #007bff;
        }
        
        /* 게시판 스타일 */
        .indent { margin-left: 20px; }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            background-color: white;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        th {
            background-color: #f8f9fa;
            font-weight: 600;
            text-align: center;
            padding: 10px;
            border: 1px solid #dee2e6;
        }
        td {
            padding: 10px;
            border: 1px solid #dee2e6;
            vertical-align: middle;
        }
        table th:nth-child(2) {
            width: 50%;
        }
        table th:nth-child(1),
        table th:nth-child(4),
        table th:nth-child(5) {
            width: 10%;
        }
        table th:nth-child(3) {
            width: 15%;
        }
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
        .search-form select {
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            margin-right: 5px;
            vertical-align: middle;
            height: 34px;
        }
        .search-form input[type="text"] {
            padding: 5px;
            width: 200px;
            border: 1px solid #ddd;
            border-radius: 4px;
            vertical-align: middle;
            height: 34px;
        }
        .search-form button {
            padding: 6px 15px;
            border: none;
            border-radius: 4px;
            background-color: #007bff;
            color: white;
            vertical-align: middle;
            height: 34px;
        }
        .search-form button:hover {
            background-color: #0056b3;
        }
        .per-page-select select {
            padding: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
            background-color: white;
            font-size: 14px;
        }
        .per-page-select select:focus {
            outline: none;
            border-color: #007bff;
        }
        .mb-4 {
            margin: 0 !important;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white">
        <div class="container">
            <a class="navbar-brand" href="<?php echo site_url('board'); ?>">
                <i class="fas fa-comments text-primary me-2"></i>커뮤니티
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('board'); ?>">
                            <i class="fas fa-list me-1"></i>게시판
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="<?php echo site_url('board/write'); ?>">
                            <i class="fas fa-pen me-1"></i>글쓰기
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <div class="main-content">
        <div class="container">
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
        </div>
    </div>
</body>
</html>