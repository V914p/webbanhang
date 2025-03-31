<?php
require_once('app/config/database.php');
require_once('app/models/AccountModel.php');

class AccountController {
    private $accountModel;
    private $db;

    public function __construct() {
        $this->db = (new Database())->getConnection();
        $this->accountModel = new AccountModel($this->db);
    }

    function register() {
        include_once 'app/views/account/register.php';
    }

    public function login() {
        include_once 'app/views/account/login.php';
    }

    function save() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $fullName = $_POST['fullname'] ?? '';
            $password = $_POST['password'] ?? '';
            $confirmPassword = $_POST['confirmpassword'] ?? '';
            $errors = [];

            if (empty($username)) {
                $errors['username'] = "Vui lòng nhập userName!";
            }
            if (empty($fullName)) {
                $errors['fullname'] = "Vui lòng nhập fullName!";
            }
            if (empty($password)) {
                $errors['password'] = "Vui lòng nhập password!";
            }
            if ($password != $confirmPassword) {
                $errors['confirmPass'] = "Mật khẩu và xác nhận chưa khớp";
            }

            $account = $this->accountModel->getAccountByUsername($username);
            if ($account) {
                $errors['account'] = "Tài khoản này đã có người đăng ký!";
            }

            if (count($errors) > 0) {
                include_once 'app/views/account/register.php';
            } else {
                $password = password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]);
                $result = $this->accountModel->save($username, $fullName, $password);
                if ($result) {
                    header('Location: /mvc-project1/account/login');
                }
            }
        }
    }

    function logout() {
        unset($_SESSION['username']);
        unset($_SESSION['role']);
        header('Location: /mvc-project1/product');
    }

    public function checkLogin() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $username = $_POST['username'] ?? '';
            $password = $_POST['password'] ?? '';
            $errors = [];

            if (empty($username)) {
                $errors['username'] = "Vui lòng nhập username!";
            }
            if (empty($password)) {
                $errors['password'] = "Vui lòng nhập password!";
            }

            if (empty($errors)) {
                $account = $this->accountModel->getAccountByUsername($username);

                if ($account && !empty($account->password)) {
                    $pwd_hashed = $account->password;
                    if (password_verify($password, $pwd_hashed)) {
                        session_start();
                        $_SESSION['user_id'] = $account->id;
                        $_SESSION['user_role'] = $account->role;
                        $_SESSION['username'] = $account->username;
                        header('Location: /mvc-project1/product');
                        exit;
                    } else {
                        $errors['password'] = "Mật khẩu không đúng!";
                    }
                } else {
                    $errors['username'] = "Không tìm thấy tài khoản với username này!";
                }
            }

            include_once 'app/views/account/login.php';
        }
    }
}