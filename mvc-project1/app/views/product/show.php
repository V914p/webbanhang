<?php include 'app/views/shares/header.php'; ?>

<div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="text-primary fw-bold">Chi tiết sản phẩm</h1>
        <a href="/mvc-project1/Product" class="btn btn-outline-secondary"><i class="fas fa-arrow-left"></i> Quay lại danh sách</a>
    </div>

    <div class="row">
        <div class="col-md-6">
            <?php if (!empty($product->image)): ?>
                <div class="product-img-container shadow-sm">
                    <img src="/mvc-project1/<?php echo htmlspecialchars($product->image); ?>" class="img-fluid rounded" alt="<?php echo htmlspecialchars($product->name); ?>">
                </div>
            <?php else: ?>
                <div class="no-img-container d-flex align-items-center justify-content-center bg-light rounded shadow-sm">
                    <i class="fa fa-image fa-3x text-muted"></i>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-6">
            <div class="product-detail p-4 bg-white shadow-sm rounded">
                <h2 class="mb-3"><?php echo htmlspecialchars($product->name); ?></h2>
                <p class="text-muted"><?php echo nl2br(htmlspecialchars($product->description)); ?></p>
                <p class="price-tag fw-bold text-danger mb-3">
                    <?php echo number_format($product->price, 0, ',', '.'); ?> VND
                </p>
                <p class="category-badge mb-4">
                    <span class="badge bg-primary">
                        <i class="fa fa-tag"></i>
                        <?php echo isset($product->category_name) ? htmlspecialchars($product->category_name) : 'Không có danh mục'; ?>
                    </span>
                </p>
                <div class="d-flex gap-2 flex-wrap">
                    <a href="/mvc-project1/Product/addToCart/<?php echo $product->id; ?>" class="btn btn-primary">
                        <i class="fas fa-cart-plus"></i> Thêm vào giỏ
                    </a>
                    <?php if (SessionHelper::isAdmin()): ?>
                        <a href="/mvc-project1/Product/edit/<?php echo $product->id; ?>" class="btn btn-warning text-white">
                            <i class="fas fa-edit"></i> Sửa
                        </a>
                        <a href="/mvc-project1/Product/delete/<?php echo $product->id; ?>" class="btn btn-danger delete-btn">
                            <i class="fas fa-trash"></i> Xóa
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .product-img-container,
    .no-img-container {
        height: 400px;
        overflow: hidden;
        background: #f8f9fa;
    }

    .product-img-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.3s ease;
    }

    .product-img-container:hover img {
        transform: scale(1.05);
    }

    .product-detail {
        border-radius: 10px;
    }

    .price-tag {
        font-size: 1.5rem;
    }

    .btn {
        padding: 0.5rem 1rem;
    }

    @media (max-width: 767.98px) {

        .product-img-container,
        .no-img-container {
            height: 300px;
        }

        .product-detail {
            margin-top: 1.5rem;
        }

        .btn {
            width: 100%;
            margin-bottom: 0.5rem;
        }
    }
</style>

<?php include 'app/views/shares/footer.php'; ?>