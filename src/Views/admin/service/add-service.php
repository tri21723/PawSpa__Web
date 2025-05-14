<?php start_section('title') ?>
Quản lý dịch vụ
<?php end_section() ?>

<!-- Start: Tiêu đề & Breadcrumb -->
<div class="admin-main__header">
    <h2 class="admin-main__title">Thêm dịch vụ</h2>
    <!-- Start: Breadcrumb -->
    <nav class="breadcrumb">
        <a href="<?= base_url('/admin/dashboard') ?>" class="breadcrumb__link">Trang chủ</a>
        <span class="breadcrumb__separator">/</span>
        <a href="<?= base_url('/admin/service') ?>" class="breadcrumb__link">Quản lý dịch vụ</a>
        <span class="breadcrumb__separator">/</span>
        <a href="<?= base_url('/admin/service/add') ?>"
            class="breadcrumb__link breadcrumb__link--active">Thêm dịch vụ</a>
    </nav>
    <!-- End: Breadcrumb -->
</div>
<!-- End: Tiêu đề & Breadcrumb -->

<!-- Khối form thêm dịch vụ -->
<section class="admin-form-wrapper">
    <form method="POST" action="" class="admin-form">
        <!-- Tên dịch vụ -->
        <div class="admin-form__group">
            <label for="serviceName" class="admin-form__label">Tên dịch vụ</label>
            <input type="text" name="name" id="serviceName" class="admin-form__input"
                placeholder="Nhập tên dịch vụ..." />
        </div>

        <!-- Nhóm dịch vụ -->
        <div class="admin-form__group">
            <label for="serviceGroup" class="admin-form__label">Nhóm dịch vụ</label>
            <input type="text" id="serviceGroup" class="admin-form__input"
                placeholder="Nhập nhóm dịch vụ..." />
        </div>

        <!-- Giá tiền -->
        <div class="admin-form__group">
            <label for="price" class="admin-form__label">Giá tiền</label>
            <input type="text" id="price" class="admin-form__input" placeholder="Nhập giá tiền..." />
        </div>

        <!-- Nút lưu -->
        <div class="admin-form__submit-wrapper">
            <button type="submit" class="btn btn--primary admin-form__submit">Lưu</button>
        </div>
    </form>
</section>