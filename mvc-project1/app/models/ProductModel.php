<?php
class ProductModel
{
    private $conn;
    private $table_name = "product";
    
    public function __construct($db)
    {
        $this->conn = $db;
    }
    
    public function getProducts()
    {
        $stmt = $this->conn->prepare("
            SELECT p.id, p.name, p.description, p.price, p.image, c.name AS category_name 
            FROM product p
            LEFT JOIN category c ON p.category_id = c.id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
    
    public function getProductById($id)
    {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        return $result;
    }
    
    public function addProduct($name, $description, $price, $category_id, $image)
    {
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }
        if (!is_numeric($price) || $price < 0) {
            $errors['price'] = 'Giá sản phẩm không hợp lệ';
        }
        if (empty($category_id)) {
            $errors['category_id'] = 'Danh mục không được để trống';
        }
        if (empty($image)) {
            $errors['image'] = 'Hình ảnh không được để trống';
        }
        
        if (count($errors) > 0) {
            return $errors;
        }
        
        $query = "INSERT INTO " . $this->table_name . " (name, description, price, category_id, image) 
                 VALUES (:name, :description, :price, :category_id, :image)";
        $stmt = $this->conn->prepare($query);
        
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = floatval($price); // Đảm bảo price là số thực
        $category_id = intval($category_id); // Đảm bảo category_id là số nguyên
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':image', $image);
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function updateProduct($id, $name, $description, $price, $category_id, $image)
    {
        $errors = [];
        if (empty($name)) {
            $errors['name'] = 'Tên sản phẩm không được để trống';
        }
        if (empty($description)) {
            $errors['description'] = 'Mô tả không được để trống';
        }
        if (!is_numeric($price) || $price < 0) {
            $errors['price'] = 'Giá sản phẩm không hợp lệ';
        }
        if (empty($category_id)) {
            $errors['category_id'] = 'Danh mục không được để trống';
        }
        
        if (count($errors) > 0) {
            return $errors;
        }
        
        // Nếu không có ảnh mới thì không cập nhật trường image
        if ($image) {
            $query = "UPDATE " . $this->table_name . " 
                     SET name = :name, description = :description, price = :price, 
                         category_id = :category_id, image = :image 
                     WHERE id = :id";
        } else {
            $query = "UPDATE " . $this->table_name . " 
                     SET name = :name, description = :description, price = :price, 
                         category_id = :category_id 
                     WHERE id = :id";
        }
        
        $stmt = $this->conn->prepare($query);
        
        $name = htmlspecialchars(strip_tags($name));
        $description = htmlspecialchars(strip_tags($description));
        $price = floatval($price);
        $category_id = intval($category_id);
        $id = intval($id);
        
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':id', $id);
        if ($image) {
            $stmt->bindParam(':image', $image);
        }
        
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function deleteProduct($id)
    {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    
    public function searchProducts($keyword)
    {
        $keyword = "%" . $keyword . "%";
        $stmt = $this->conn->prepare("
            SELECT p.id, p.name, p.description, p.price, p.image, c.name AS category_name 
            FROM product p
            LEFT JOIN category c ON p.category_id = c.id
            WHERE p.name LIKE :keyword OR p.description LIKE :keyword
        ");
        $stmt->bindParam(':keyword', $keyword, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}