<?php include 'app/views/shares/header.php'; ?>

<div class="container my-5">
    <h1 class="border-bottom pb-2 text-primary fw-bold">Thêm sản phẩm mới</h1>
    <form id="add-product-form" enctype="multipart/form-data">
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
            </select>
        </div>
        <div class="form-group mb-3">
            <label for="image">Hình ảnh sản phẩm:</label>
            <input type="file" id="image" name="image" class="form-control" accept="image/*" required>
            <div id="image-preview" class="mt-2"></div>
        </div>
        <button type="submit" class="btn btn-primary">Thêm sản phẩm</button>
        <a href="/mvc-project1/Product" class="btn btn-secondary ms-2">Quay lại danh sách sản phẩm</a>
    </form>
</div>

<script>
document.addEventListener("DOMContentLoaded", function() {
    // Tải danh mục
    fetch('/mvc-project1/CategoryApi/index')
        .then(response => response.json())
        .then(categories => {
            const categorySelect = document.getElementById('category_id');
            categories.forEach(category => {
                const option = document.createElement('option');
                option.value = category.id;
                option.textContent = category.name;
                categorySelect.appendChild(option);
            });
        })
        .catch(error => console.error('Lỗi tải danh mục:', error));

    // Xem trước ảnh
    document.getElementById('image').addEventListener('change', function(e) {
        const preview = document.getElementById('image-preview');
        preview.innerHTML = '';
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
    document.getElementById('add-product-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const formData = new FormData(this);

        console.log('Dữ liệu gửi đi:');
        for (let [key, value] of formData.entries()) {
            console.log(key, value);
        }

        fetch('/mvc-project1/ProductApi/store', {
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
            if (data.message === 'Product created successfully') {
                alert('Thêm sản phẩm thành công!');
                location.href = '/mvc-project1/Product';
            } else {
                alert('Thêm sản phẩm thất bại: ' + (data.errors ? data.errors.join(', ') : 'Lỗi không xác định'));
            }
        })
        .catch(error => {
            console.error('Lỗi:', error);
            alert('Đã xảy ra lỗi khi thêm sản phẩm.');
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