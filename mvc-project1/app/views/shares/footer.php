<footer class="footer-modern">
    <div class="footer-top">
        <div class="container">
            <div class="row">
                <!-- Cột thông tin liên hệ -->
                <div class="col-lg-4 col-md-6 mb-4 mb-md-0 footer-info">
                    <h3 class="footer-heading">Quản lý sản phẩm</h3>
                    <p class="footer-text">
                        Hệ thống quản lý sản phẩm giúp bạn theo dõi và cập nhật thông tin sản phẩm dễ dàng.
                    </p>
                    <div class="contact-info mt-4">
                        <div class="contact-item">
                            <i class="fas fa-map-marker-alt"></i>
                            <span>123 Đường ABC, Quận XYZ, TP HCM</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-phone-alt"></i>
                            <span>+84 123 456 789</span>
                        </div>
                        <div class="contact-item">
                            <i class="fas fa-envelope"></i>
                            <span>contact@quanlysanpham.com</span>
                        </div>
                    </div>
                </div>
                
                <!-- Cột liên kết nhanh -->
                <div class="col-lg-4 col-md-6 mb-4 mb-md-0 footer-links">
                    <h3 class="footer-heading">Liên kết nhanh</h3>
                    <ul class="footer-menu">
                        <li><a href="/mvc-project1/Product/"><i class="fas fa-chevron-right"></i> Danh sách sản phẩm</a></li>
                        <li><a href="/mvc-project1/Order/"><i class="fas fa-chevron-right"></i> Đơn hàng</a></li>
                        <li><a href="/mvc-project1/User/profile"><i class="fas fa-chevron-right"></i> Tài khoản</a></li>
                        <a href="/mvc-project1/Product/add" class="btn btn-success btn-sm flex-grow-1">
                                                <i class="fa fa-plus-circle"></i> Thêm
                                            </a>
                    </ul>
                </div>
                
                <!-- Cột đăng ký nhận tin -->
                <div class="col-lg-4 col-md-12 mb-4 mb-md-0 footer-newsletter">
                    <h3 class="footer-heading">Đăng ký nhận tin</h3>
                    <p class="footer-text">Đăng ký để nhận thông tin mới nhất về sản phẩm và khuyến mãi</p>
                    <form class="mt-3">
                        <div class="input-group mb-3">
                            <input type="email" class="form-control" placeholder="Email của bạn" aria-label="Email của bạn">
                            <button class="btn btn-primary" type="button"><i class="fas fa-paper-plane"></i></button>
                        </div>
                    </form>
                    <h3 class="footer-heading mt-4">Kết nối với chúng tôi</h3>
                    <div class="social-links mt-3">
                        <a href="#" class="social-icon facebook"><i class="fab fa-facebook-f"></i></a>
                        <a href="#" class="social-icon twitter"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="social-icon instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-icon linkedin"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#" class="social-icon youtube"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Dòng bản quyền -->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-md-6 copyright">
                    <p>© 2025 Quản lý sản phẩm. All rights reserved.</p>
                </div>
                <div class="col-md-6 footer-menu-bottom">
                    <ul>
                        <li><a href="#">Điều khoản sử dụng</a></li>
                        <li><a href="#">Chính sách bảo mật</a></li>
                        <li><a href="#">Liên hệ</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</footer>

<style>
.footer-modern {
    background-color: #f8f9fa;
    color: #495057;
    font-family: 'Segoe UI', Roboto, 'Helvetica Neue', sans-serif;
}

.footer-top {
    padding: 60px 0 40px;
    background: linear-gradient(135deg, #ebf4fa 0%, #f0f5fb 100%);
}

.footer-heading {
    position: relative;
    font-size: 1.2rem;
    font-weight: 600;
    color: #2c3e50;
    margin-bottom: 25px;
    padding-bottom: 10px;
}

.footer-heading:after {
    content: '';
    position: absolute;
    left: 0;
    bottom: 0;
    height: 2px;
    width: 50px;
    background-color: #3498db;
}

.footer-text {
    color: #6c757d;
    line-height: 1.6;
}

.contact-info .contact-item {
    display: flex;
    align-items: center;
    margin-bottom: 15px;
}

.contact-info i {
    width: 30px;
    height: 30px;
    background-color: rgba(52, 152, 219, 0.1);
    color: #3498db;
    border-radius: 50%;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    margin-right: 10px;
    font-size: 14px;
}

.footer-menu {
    list-style: none;
    padding: 0;
}

.footer-menu li {
    margin-bottom: 12px;
}

.footer-menu li a {
    color: #6c757d;
    text-decoration: none;
    transition: all 0.3s;
    display: flex;
    align-items: center;
}

.footer-menu li a:hover {
    color: #3498db;
    padding-left: 5px;
}

.footer-menu li a i {
    font-size: 12px;
    margin-right: 10px;
    color: #3498db;
}

.footer-newsletter .form-control {
    height: 45px;
    border-top-right-radius: 0;
    border-bottom-right-radius: 0;
    border: 1px solid #ced4da;
}

.footer-newsletter .btn {
    border-top-left-radius: 0;
    border-bottom-left-radius: 0;
    height: 45px;
    background-color: #3498db;
    border-color: #3498db;
}

.social-links {
    display: flex;
    gap: 10px;
}

.social-icon {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 38px;
    height: 38px;
    border-radius: 50%;
    background-color: rgba(52, 152, 219, 0.1);
    color: #3498db;
    text-decoration: none;
    transition: all 0.3s;
}

.social-icon:hover {
    transform: translateY(-3px);
}

.facebook:hover {
    background-color: #3b5998;
    color: white;
}

.twitter:hover {
    background-color: #1da1f2;
    color: white;
}

.instagram:hover {
    background-color: #e1306c;
    color: white;
}

.linkedin:hover {
    background-color: #0077b5;
    color: white;
}

.youtube:hover {
    background-color: #ff0000;
    color: white;
}

.footer-bottom {
    background-color: #2c3e50;
    color: #ecf0f1;
    padding: 20px 0;
}

.footer-bottom p {
    margin: 0;
}

.footer-menu-bottom {
    text-align: right;
}

.footer-menu-bottom ul {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    justify-content: flex-end;
}

.footer-menu-bottom ul li {
    margin-left: 20px;
}

.footer-menu-bottom ul li a {
    color: #ecf0f1;
    text-decoration: none;
    font-size: 14px;
    transition: all 0.3s;
}

.footer-menu-bottom ul li a:hover {
    color: #3498db;
}

@media (max-width: 767.98px) {
    .footer-menu-bottom ul {
        justify-content: center;
        margin-top: 10px;
    }
    
    .footer-menu-bottom ul li {
        margin: 0 10px;
    }
    
    .copyright {
        text-align: center;
    }
}
</style>

<!-- Font Awesome Icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<!-- Thay thế bằng CDN sau nếu script trên không hoạt động -->
<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css"> -->