<?php 
include 'app/views/shares/header.php';
require_once('app/models/CategoryModel.php');

// Khởi tạo CategoryModel để lấy danh mục từ database
$db = (new Database())->getConnection();
$categoryModel = new CategoryModel($db);
$categories = $categoryModel->getCategories(); // Giả sử có phương thức getCategories()
?>

<div class="container my-5">
    <h1 class="border-bottom pb-2 text-primary fw-bold">Sửa sản phẩm</h1>
    <form id="edit-product-form" enctype="multipart/form-data">
        <input type="hidden" id="id" name="id">
        <div class="form-group mb-3">
            <label for="name">Tên sản phẩm:</label>
            <input type="text" id="name" name="name" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="description">Mô tả:</label>
            <textarea id="description" name="description" class="form-control" required></textarea>
        </div>
        <div class="form-group mb-3">
            <label for="price">Giá:</label>
            <input type="number" id="price" name="price" class="form-control" step="0.01" required>
        </div>
        <div class="form-group mb-3">
            <label for="category_id">Danh mục:</label>
            <select id="category_id" name="category_id" class="form-control" required>
                <option value="">-- Chọn danh mục --</option>
                <?php foreach ($categories as $category): ?>
                    <option value="<?php echo $category->id; ?>">
                        <?php echo htmlspecialchars($category->name); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="image">Hình ảnh sản phẩm:</label>
            <input type="file" id="image" name="image" class="form-control" accept="image/*">
            <div id="image-preview" class="mt-2">
                <img id="current-image" src="" alt="Current Image" style="max-width: 200px; display: none;">
            </div>
        </div>
        <button type="submit" class="btn btn-primary">Lưu thay đổi</button>
        <a href="/mvc-project1/Product/list" class="btn btn-secondary ms-2">Quay lại danh sách sản phẩm</a>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    const productId = <?= json_encode($editId) ?>; // Đảm bảo $editId được truyền từ controller

    // Tải thông tin sản phẩm
    fetch(`/mvc-project1/ProductApi/show/${productId}`)
        .then(response => response.json())
        .then(product => {
            console.log('Dữ liệu sản phẩm:', product); // Debug
            document.getElementById('id').value = product.id;
            document.getElementById('name').value = product.name;
            document.getElementById('description').value = product.description;
            document.getElementById('price').value = product.price;
            document.getElementById('category_id').value = product.category_id;
            
            // Hiển thị ảnh hiện tại
            const currentImage = document.getElementById('current-image');
            if (product.image) {
                currentImage.src = product.image;
                currentImage.style.display = 'block';
            }
        })
        .catch(error => console.error('Lỗi tải sản phẩm:', error));

    // Xem trước ảnh mới
    document.getElementById('image').addEventListener('change', function(e) {
        const preview = document.getElementById('image-preview');
        const currentImage = document.getElementById('current-image');
        currentImage.style.display = 'none'; // Ẩn ảnh cũ khi chọn ảnh mới
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                img.style.maxWidth = '200px';
                preview.appendChild(img);
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });

    // Xử lý gửi form
    document.getElementById('edit-product-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);

        console.log('Dữ liệu gửi đi:');
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }

        fetch(`/mvc-project1/ProductApi/update/${formData.get('id')}`, {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log('Mã trạng thái:', response.status);
            if (!response.ok) throw new Error('Phản hồi không thành công');
            return response.json();
        })
        .then(data => {
            console.log('Phản hồi từ API:', data);
            if (data.message === 'Product updated successfully') {
                alert('Cập nhật sản phẩm thành công!');
                location.href = '/mvc-project1/Product';
            } else {
                alert('Cập nhật sản phẩm thất bại: ' + (data.errors ? data.errors.join(', ') : 'Lỗi không xác định'));
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Đã xảy ra lỗi khi cập nhật sản phẩm.');
        });
    });
});
</script>

<style>
    .form-group label { font-weight: 600; margin-bottom: 0.5rem; }
    .form-control { border-radius: 5px; }
    .btn { padding: 0.5rem 1.5rem; }
    #image-preview img { max-height: 200px; object-fit: contain; }
</style>

<?php include 'app/views/shares/footer.php'; ?>