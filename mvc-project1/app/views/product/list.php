<?php include 'app/views/shares/header.php'; ?>

<div class="container my-5">
    <!-- Tiêu đề, tìm kiếm và nút quản lý danh mục -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="border-bottom pb-2 text-primary fw-bold">Danh sách sản phẩm</h1>
        <div class="d-flex align-items-center gap-3">
            <form class="d-flex" id="searchForm">
                <input class="form-control me-2" type="search" placeholder="Tìm kiếm sản phẩm..." name="q" id="searchInput" aria-label="Search">
                <button class="btn btn-outline-primary" type="submit"><i class="fas fa-search"></i></button>
            </form>
            <?php if (SessionHelper::isAdmin()): ?>
                <button class="btn btn-info text-white" data-bs-toggle="modal" data-bs-target="#categoryModal">
                    <i class="fas fa-list"></i> Quản lý danh mục
                </button>
            <?php endif; ?>
        </div>
    </div>

    <!-- Danh sách sản phẩm -->
    <div class="row g-4" id="productList">
        <!-- Sản phẩm sẽ được thêm động bằng JavaScript -->
    </div>
</div>

<!-- Modal quản lý danh mục -->
<div class="modal fade" id="categoryModal" tabindex="-1" aria-labelledby="categoryModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="categoryModalLabel">Quản lý danh mục</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Form thêm danh mục -->
                <form id="addCategoryForm" class="mb-4">
                    <div class="input-group">
                        <input type="text" class="form-control" id="categoryName" placeholder="Nhập tên danh mục mới">
                        <button type="submit" class="btn btn-primary">Thêm danh mục</button>
                    </div>
                </form>

                <!-- Danh sách danh mục -->
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Tên danh mục</th>
                            <th>Hành động</th>
                        </tr>
                    </thead>
                    <tbody id="categoryList">
                        <!-- Danh mục sẽ được thêm động bằng JavaScript -->
                    </tbody>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Hàm lấy và hiển thị sản phẩm
    function fetchProducts(keyword = '') {
        let url = '/mvc-project1/ProductApi/search';
        if (keyword) {
            url += `?q=${encodeURIComponent(keyword)}`;
        }

        fetch(url)
            .then(response => response.json())
            .then(products => {
                const productList = document.getElementById('productList');
                productList.innerHTML = '';

                if (products.length === 0) {
                    productList.innerHTML = `
                        <div class="col-12">
                            <div class="alert alert-warning text-center">
                                Không tìm thấy sản phẩm nào${keyword ? ' khớp với từ khóa "' + keyword + '"' : ''}.
                            </div>
                        </div>
                    `;
                    return;
                }

                products.forEach(product => {
                    const productCard = `
                        <div class="col-md-4 col-sm-6">
                            <div class="card h-100 shadow-sm product-card position-relative">
                                ${product.image ? `
                                    <div class="product-img-container position-relative">
                                        <img src="/mvc-project1/${product.image}" class="card-img-top product-img" alt="${escapeHtml(product.name)}">
                                        <div class="overlay d-flex align-items-center justify-content-center">
                                            <a href="/mvc-project1/Product/show/${product.id}" class="btn btn-sm btn-light">Xem nhanh</a>
                                        </div>
                                    </div>
                                ` : `
                                    <div class="no-img-container d-flex align-items-center justify-content-center bg-light">
                                        <i class="fa fa-image fa-3x text-muted"></i>
                                    </div>
                                `}
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">
                                        <a href="/mvc-project1/Product/show/${product.id}" class="text-decoration-none product-link">
                                            ${escapeHtml(product.name)}
                                        </a>
                                    </h5>
                                    <p class="card-text text-muted text-truncate">${escapeHtml(product.description)}</p>
                                    <p class="price-tag fw-bold text-danger mb-2">
                                        ${Number(product.price).toLocaleString('vi-VN')} VND
                                    </p>
                                    <p class="category-badge mb-0">
                                        <span class="badge bg-primary">
                                            <i class="fa fa-tag"></i> ${escapeHtml(product.category_name)}
                                        </span>
                                    </p>
                                </div>
                                <div class="card-footer bg-white border-0">
                                    <div class="d-flex gap-2 flex-wrap">
                                        <?php if (SessionHelper::isAdmin()): ?>
                                            <a href="/mvc-project1/Product/add" class="btn btn-success btn-sm flex-grow-1">
                                                <i class="fa fa-plus-circle"></i> Thêm
                                            </a>
                                            <a href="/mvc-project1/Product/edit/${product.id}" class="btn btn-warning btn-sm flex-grow-1 text-white">
                                                <i class="fas fa-edit"></i> Sửa
                                            </a>
                                            <a href="/mvc-project1/Product/delete/${product.id}" class="btn btn-danger btn-sm flex-grow-1 delete-btn">
                                                <i class="fas fa-trash"></i> Xóa
                                            </a>
                                        <?php endif; ?>
                                        <a href="/mvc-project1/Product/addToCart/${product.id}" class="btn btn-primary btn-sm flex-grow-1">
                                            <i class="fas fa-cart-plus"></i> Giỏ
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    `;
                    productList.insertAdjacentHTML('beforeend', productCard);
                });
            })
            .catch(error => {
                console.error('Lỗi khi lấy sản phẩm:', error);
                document.getElementById('productList').innerHTML = `
                    <div class="col-12">
                        <div class="alert alert-danger text-center">
                            Đã xảy ra lỗi khi tải danh sách sản phẩm.
                        </div>
                    </div>
                `;
            });
    }

    // Hàm lấy và hiển thị danh mục
    function fetchCategories() {
        fetch('/mvc-project1/CategoryApi/index') // Giả sử có API này
            .then(response => response.json())
            .then(categories => {
                const categoryList = document.getElementById('categoryList');
                categoryList.innerHTML = '';
                categories.forEach(category => {
                    categoryList.innerHTML += `
                        <tr>
                            <td>${category.id}</td>
                            <td>
                                <input type="text" class="form-control category-name" value="${escapeHtml(category.name)}" data-id="${category.id}">
                            </td>
                            <td>
                                <button class="btn btn-warning btn-sm update-category" data-id="${category.id}">
                                    <i class="fas fa-save"></i> Lưu
                                </button>
                                <button class="btn btn-danger btn-sm delete-category" data-id="${category.id}">
                                    <i class="fas fa-trash"></i> Xóa
                                </button>
                            </td>
                        </tr>
                    `;
                });

                // Xử lý sửa danh mục
                document.querySelectorAll('.update-category').forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        const name = this.closest('tr').querySelector('.category-name').value;
                        updateCategory(id, name);
                    });
                });

                // Xử lý xóa danh mục
                document.querySelectorAll('.delete-category').forEach(button => {
                    button.addEventListener('click', function() {
                        const id = this.getAttribute('data-id');
                        if (confirm('Bạn có chắc muốn xóa danh mục này?')) {
                            deleteCategory(id);
                        }
                    });
                });
            });
    }

    // Hàm thêm danh mục
    function addCategory(name) {
        fetch('/mvc-project1/CategoryApi/store', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Category created successfully') {
                fetchCategories();
                alert('Thêm danh mục thành công!');
            } else {
                alert('Thêm danh mục thất bại: ' + (data.error || 'Lỗi không xác định'));
            }
        })
        .catch(error => console.error('Lỗi:', error));
    }

    // Hàm sửa danh mục
    function updateCategory(id, name) {
        fetch(`/mvc-project1/CategoryApi/update/${id}`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ name })
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Category updated successfully') {
                fetchCategories();
                alert('Cập nhật danh mục thành công!');
            } else {
                alert('Cập nhật danh mục thất bại: ' + (data.error || 'Lỗi không xác định'));
            }
        })
        .catch(error => console.error('Lỗi:', error));
    }

    // Hàm xóa danh mục
    function deleteCategory(id) {
        fetch(`/mvc-project1/CategoryApi/destroy/${id}`, {
            method: 'POST'
        })
        .then(response => response.json())
        .then(data => {
            if (data.message === 'Category deleted successfully') {
                fetchCategories();
                fetchProducts(); // Cập nhật lại danh sách sản phẩm
                alert('Xóa danh mục thành công!');
            } else {
                alert('Xóa danh mục thất bại: ' + (data.error || 'Lỗi không xác định'));
            }
        })
        .catch(error => console.error('Lỗi:', error));
    }

    // Hàm thoát HTML để bảo mật
    function escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, m => map[m]);
    }

    // Gọi lần đầu khi trang tải
    fetchProducts();

    // Xử lý sự kiện tìm kiếm
    document.getElementById('searchForm').addEventListener('submit', function (e) {
        e.preventDefault();
        const keyword = document.getElementById('searchInput').value.trim();
        fetchProducts(keyword);
    });

    // Xử lý thêm danh mục
    document.getElementById('addCategoryForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const name = document.getElementById('categoryName').value.trim();
        if (name) {
            addCategory(name);
            document.getElementById('categoryName').value = '';
        }
    });

    // Tải danh mục khi mở modal
    document.getElementById('categoryModal').addEventListener('shown.bs.modal', function () {
        fetchCategories();
    });
});
</script>

<style>
    .product-card { transition: transform 0.3s ease, box-shadow 0.3s ease; border: none; border-radius: 10px; overflow: hidden; background: #fff; }
    .product-card:hover { transform: translateY(-10px); box-shadow: 0 15px 30px rgba(0, 0, 0, 0.15) !important; }
    .product-img-container { height: 200px; position: relative; overflow: hidden; }
    .product-img { height: 100%; width: 100%; object-fit: cover; transition: transform 0.3s ease; }
    .product-card:hover .product-img { transform: scale(1.05); }
    .overlay { position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.3); opacity: 0; transition: opacity 0.3s ease; }
    .product-card:hover .overlay { opacity: 1; }
    .product-link { color: #2c3e50; font-weight: 600; transition: color 0.2s ease; }
    .product-link:hover { color: #007bff; }
    .price-tag { font-size: 1.2rem; color: #e74c3c; }
    .no-img-container { height: 200px; }
    .btn-sm { padding: 0.4rem 0.8rem; font-size: 0.9rem; }
    @media (max-width: 767.98px) { .col-sm-6 { margin-bottom: 1.5rem; } .btn-sm { width: 100%; } }
</style>

<?php include 'app/views/shares/footer.php'; ?>