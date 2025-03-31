<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý sản phẩm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #4361ee;
            --secondary-color: #3a0ca3;
            --accent-color: #7209b7;
            --light-bg: #f8f9fa;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f8fa;
        }
        
        /* Header Styles */
        .header-container {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 0;
            position: relative;
        }
        
        .top-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        
        .logo-container {
            display: flex;
            align-items: center;
        }
        
        .logo-icon {
            font-size: 2rem;
            color: white;
            margin-right: 10px;
        }
        
        .logo-text {
            color: white;
            font-size: 1.4rem;
            font-weight: 700;
            margin: 0;
            letter-spacing: 0.5px;
        }
        
        .header-actions {
            display: flex;
            align-items: center;
        }
        
        .search-container {
            position: relative;
            margin-right: 15px;
        }
        
        .search-input {
            background-color: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 50px;
            color: white;
            padding: 8px 15px 8px 40px;
            min-width: 250px;
            transition: all 0.3s ease;
        }
        
        .search-input:focus {
            background-color: rgba(255, 255, 255, 0.25);
            box-shadow: 0 0 8px rgba(255, 255, 255, 0.3);
            border-color: rgba(255, 255, 255, 0.4);
            outline: none;
        }
        
        .search-input::placeholder {
            color: rgba(255, 255, 255, 0.7);
        }
        
        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.7);
        }
        
        .header-button {
            background-color: rgba(255, 255, 255, 0.15);
            border: none;
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            margin-left: 10px;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .header-button:hover {
            background-color: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }
        
        .notification-badge {
            position: absolute;
            top: -5px;
            right: -5px;
            background-color: #f72585;
            color: white;
            border-radius: 50%;
            width: 18px;
            height: 18px;
            font-size: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        
        .user-dropdown {
            display: flex;
            align-items: center;
            margin-left: 20px;
            cursor: pointer;
            position: relative;
            padding: 5px 10px;
            border-radius: 50px;
            transition: all 0.3s ease;
        }
        
        .user-dropdown:hover {
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--accent-color);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            margin-right: 10px;
            border: 2px solid rgba(255, 255, 255, 0.5);
        }
        
        .user-info {
            color: white;
        }
        
        .user-name {
            font-weight: 700;
            font-size: 1.1rem;
            margin: 0;
        }
        
        .user-role {
            font-size: 0.75rem;
            opacity: 0.8;
            margin: 0;
        }
        
        .dropdown-icon {
            color: white;
            margin-left: 8px;
            font-size: 0.8rem;
        }
        
        /* Navigation Styles */
        .main-navigation {
            padding: 0 20px;
        }
        
        .nav-menu {
            display: flex;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        
        .nav-item {
            position: relative;
        }
        
        .nav-link {
            color: rgba(255, 255, 255, 0.85);
            padding: 15px 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }
        
        .nav-link:hover {
            color: white;
        }
        
        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 20px;
            right: 20px;
            height: 3px;
            background-color: white;
            transform: scaleX(0);
            transition: transform 0.3s ease;
        }
        
        .nav-link:hover::after,
        .nav-link.active::after {
            transform: scaleX(1);
        }
        
        .nav-link.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        .nav-icon {
            margin-right: 8px;
        }
        
        /* Mobile Toggle */
        .mobile-toggle {
            background: rgba(255, 255, 255, 0.15);
            border: none;
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 4px;
            display: none;
            align-items: center;
            justify-content: center;
        }
        
        /* Responsive */
        @media (max-width: 992px) {
            .search-container {
                display: none;
            }
            
            .main-navigation {
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: var(--secondary-color);
                z-index: 1000;
                max-height: 0;
                overflow: hidden;
                transition: max-height 0.3s ease;
            }
            
            .main-navigation.show {
                max-height: 300px;
            }
            
            .nav-menu {
                flex-direction: column;
            }
            
            .mobile-toggle {
                display: flex;
            }
            
            .user-info {
                display: none;
            }
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="header-container">
        <div class="top-header">
            <div class="d-flex align-items-center">
                <!-- Mobile Toggle -->
                <button class="mobile-toggle me-3" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavigation">
                    <i class="fas fa-bars"></i>
                </button>
                
                <!-- Logo -->
                <div class="logo-container">
                    <div class="logo-icon">
                        <i class="fas fa-box-open"></i>
                    </div>
                    <h1 class="logo-text">Quản lý sản phẩm</h1>
                </div>
            </div>
            
            <div class="header-actions">
                <!-- Search -->
                <div class="search-container">
                    <i class="fas fa-search search-icon"></i>
                    <input type="text" class="search-input" placeholder="Tìm kiếm sản phẩm...">
                </div>
                
                <!-- Action Buttons -->
                <button class="header-button" title="Thông báo">
                    <i class="fas fa-bell"></i>
                    <span class="notification-badge">3</span>
                </button>
                
                <button class="header-button" title="Tin nhắn">
                    <i class="fas fa-envelope"></i>
                    <span class="notification-badge">5</span>
                </button>
                
                <!-- User Dropdown -->
                
                <li class="nav-item">
                    <?php
                        if(SessionHelper::isLoggedIn()){
                            echo
                            "<a class='navlink'>".$_SESSION['username']."</a>";
                        } else{
                            echo "<a class='nav-link'
                            href='/mvc-project1/account/login'>Login</a>";;
                        }
                    ?>
                </li>
                <li class="nav-item">
                    </a>
                    <?php
                        if(SessionHelper::isLoggedIn()){
                            echo "<a class='nav-link'href='/mvc-project1/account/logout'>Logout</a>";
                        }
                    ?>
                </li>

                <!-- <div class='user-dropdown' data-bs-toggle='dropdown'>
                                <div class='user-info'>
                                    <a class='user-name'>.$_SESSION['username'].</a>
                                    <a class='user-role'>.$_SESSION['ROLE']</a>
                                </div>
                                <i class='fas fa-chevron-down dropdown-icon'></i>
                                
                                <ul class='dropdown-menu dropdown-menu-end mt-2'>
                                    <li><a class='dropdown-item' href='#'><i class='fas fa-user-circle me-2'></i>Hồ sơ</a></li>
                                    <li><a class='dropdown-item' href='#'><i class='fas fa-cog me-2'></i>Cài đặt</a></li>
                                    <li><hr class='dropdown-divider'></li>
                                    <li><a class='dropdown-item' href='#'><i class='fas fa-sign-out-alt me-2'></i>Đăng xuất</a></li>
                                </ul>
                            </div>" -->
            </div>
        </div>
        
        <!-- Navigation -->
        <nav class="main-navigation" id="mainNavigation">
            <ul class="nav-menu">
                <li class="nav-item">
                    <a class="nav-link active" href="/mvc-project1/Product/">
                        <i class="fas fa-list nav-icon"></i> Danh sách sản phẩm
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="/mvc-project1/product/cart">
                        <i class="fa fa-shopping-cart" aria-hidden="true"></i> Giỏ Hàng
                    </a>
                </li>
            </ul>
        </nav>
    </header>

    <!-- Sample Content Container (For demonstration) -->
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // For demo purposes - toggle mobile navigation
        document.querySelector('.mobile-toggle').addEventListener('click', function() {
            document.getElementById('mainNavigation').classList.toggle('show');
        });
    </script>
</body>
</html>