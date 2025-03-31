<?php
require_once('app/config/database.php');
require_once('app/models/ProductModel.php');
require_once('app/models/CategoryModel.php');
require_once('app/utils/JWTHandler.php');

class ProductApiController
{
    private $productModel;
    private $db;
    private $jwtHandler;

    public function __construct()
    {
        $this->db = (new Database())->getConnection();
        $this->productModel = new ProductModel($this->db);
    }
    private function authenticate()
    {
        $headers = apache_request_headers();
        if (isset($headers['Authorization'])) {
            $authHeader = $headers['Authorization'];
            $arr = explode(" ", $authHeader);
            $jwt = $arr[1] ?? null;
            if ($jwt) {
                $decoded = $this->jwtHandler->decode($jwt);
                return $decoded ? true : false;
            }
        }
        return false;
    }

    public function index()
    {
        header('Content-Type: application/json');
        $products = $this->productModel->getProducts();
        echo json_encode($products);
    }

    public function show($id)
    {
        header('Content-Type: application/json');
        $product = $this->productModel->getProductById($id);
        if ($product) {
            echo json_encode($product);
        } else {
            http_response_code(404);
            echo json_encode(['message' => 'Không thấy sản phẩm']);
        }
    }

    public function store()
    {
        header('Content-Type: application/json');

        try {
            // Lấy dữ liệu đầu vào
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
            if (strpos($contentType, 'application/json') !== false) {
                $data = json_decode(file_get_contents("php://input"), true);
                $name = $data['name'] ?? '';
                $description = $data['description'] ?? '';
                $price = $data['price'] ?? '';
                $category_id = $data['category_id'] ?? '';
                $image = $data['image'] ?? null; // Nếu gửi đường dẫn ảnh qua JSON
            } else {
                // Xử lý form-data từ Postman hoặc form HTML
                $name = $_POST['name'] ?? '';
                $description = $_POST['description'] ?? '';
                $price = $_POST['price'] ?? '';
                $category_id = $_POST['category_id'] ?? '';
                $image = null;
            }

            // Kiểm tra dữ liệu bắt buộc
            if (empty($name) || empty($description) || empty($price) || empty($category_id)) {
                throw new Exception('Vui lòng điền đầy đủ thông tin');
            }

            // Xử lý upload file nếu có
            if (isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
                $file = $_FILES['image'];
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $maxSize = 5 * 1024 * 1024;

                if (!in_array($file['type'], $allowedTypes)) {
                    throw new Exception('Chỉ chấp nhận file JPG, PNG hoặc GIF');
                }
                if ($file['size'] > $maxSize) {
                    throw new Exception('Kích thước file tối đa là 5MB');
                }

                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $extension;
                $uploadDir = 'public/uploads/products/';
                $uploadPath = $uploadDir . $filename;
                $imageUrl = '/public/uploads/products/' . $filename;

                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
                    throw new Exception('Không thể upload file');
                }
                $image = $imageUrl;
            } elseif (empty($image)) {
                throw new Exception('Vui lòng cung cấp hình ảnh');
            }

            $result = $this->productModel->addProduct($name, $description, $price, $category_id, $image);

            if (is_array($result)) {
                if (isset($uploadPath) && file_exists($uploadPath)) {
                    unlink($uploadPath);
                }
                http_response_code(400);
                echo json_encode(['errors' => $result]);
            } else {
                http_response_code(201);
                echo json_encode(['message' => 'Product created successfully']);
            }

        } catch (Exception $e) {
            if (isset($uploadPath) && file_exists($uploadPath)) {
                unlink($uploadPath);
            }
            http_response_code(400);
            echo json_encode(['errors' => [$e->getMessage()]]);
        }
    }

    public function update($id)
    {
        header('Content-Type: application/json');

        try {
            // Xác định loại dữ liệu đầu vào
            $contentType = $_SERVER['CONTENT_TYPE'] ?? '';
            $isJson = strpos($contentType, 'application/json') !== false;

            // Lấy dữ liệu
            if ($isJson) {
                $data = json_decode(file_get_contents("php://input"), true);
                $name = $data['name'] ?? '';
                $description = $data['description'] ?? '';
                $price = $data['price'] ?? '';
                $category_id = $data['category_id'] ?? '';
                $image = $data['image'] ?? null; // Đường dẫn ảnh từ JSON
            } else {
                // Form-data từ trang web hoặc Postman
                $name = $_POST['name'] ?? '';
                $description = $_POST['description'] ?? '';
                $price = $_POST['price'] ?? '';
                $category_id = $_POST['category_id'] ?? '';
                $image = null;
            }

            // Kiểm tra dữ liệu bắt buộc
            if (empty($name) || empty($description) || empty($price) || empty($category_id)) {
                throw new Exception('Vui lòng điền đầy đủ thông tin (name, description, price, category_id)');
            }

            // Xử lý ảnh (upload file hoặc đường dẫn)
            if (!$isJson && isset($_FILES['image']) && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
                // Upload file từ trang web hoặc Postman form-data
                $file = $_FILES['image'];
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $maxSize = 5 * 1024 * 1024;

                if (!in_array($file['type'], $allowedTypes)) {
                    throw new Exception('Chỉ chấp nhận file JPG, PNG hoặc GIF');
                }
                if ($file['size'] > $maxSize) {
                    throw new Exception('Kích thước file tối đa là 5MB');
                }

                $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
                $filename = uniqid() . '.' . $extension;
                $uploadDir = 'public/uploads/products/';
                $uploadPath = $uploadDir . $filename;
                $imageUrl = '/public/uploads/products/' . $filename;

                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }

                if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
                    throw new Exception('Không thể upload file');
                }
                $image = $imageUrl;

                // Xóa ảnh cũ nếu có
                $oldProduct = $this->productModel->getProductById($id);
                if ($oldProduct && $oldProduct['image'] && file_exists($uploadDir . basename($oldProduct['image']))) {
                    unlink($uploadDir . basename($oldProduct['image']));
                }
            } elseif ($isJson && !empty($image)) {
                // Đường dẫn ảnh từ JSON (Postman)
                // Không xóa ảnh cũ, chỉ cập nhật đường dẫn
            }

            $result = $this->productModel->updateProduct($id, $name, $description, $price, $category_id, $image);

            if ($result === true) {
                echo json_encode(['message' => 'Product updated successfully']);
            } else {
                if (isset($uploadPath) && file_exists($uploadPath)) {
                    unlink($uploadPath);
                }
                throw new Exception(is_array($result) ? implode(', ', $result) : 'Cập nhật sản phẩm thất bại');
            }
        } catch (Exception $e) {
            if (isset($uploadPath) && file_exists($uploadPath)) {
                unlink($uploadPath);
            }
            http_response_code(400);
            echo json_encode(['errors' => [$e->getMessage()]]);
        }
    }

    public function destroy($id)
    {
        header('Content-Type: application/json');

        $product = $this->productModel->getProductById($id);

        $result = $this->productModel->deleteProduct($id);

        if ($result) {
            if ($product && $product['image']) {
                $imagePath = 'public/uploads/products/' . basename($product['image']);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            echo json_encode(['message' => 'Product deleted successfully']);
        } else {
            http_response_code(400);
            echo json_encode(['message' => 'Product deletion failed']);
        }
    }

    public function search()
    {
        header('Content-Type: application/json');
        $keyword = $_GET['q'] ?? '';
        $products = $this->productModel->searchProducts($keyword);
        echo json_encode($products);
    }
}