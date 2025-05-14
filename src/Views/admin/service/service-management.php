<?php start_section('title') ?>
Quản lý dịch vụ
<?php end_section() ?>

<!-- Start: Tiêu đề & Breadcrumb -->
<div class="admin-main__header">
    <h2 class="admin-main__title">Danh sách dịch vụ</h2>
    <!-- Start: Breadcrumb -->
    <nav class="breadcrumb">
        <a href="<?= base_url('/admin/dashboard') ?>" class="breadcrumb__link">Trang chủ</a>
        <span class="breadcrumb__separator">/</span>
        <a href="<?= base_url('/admin/service') ?>"
            class="breadcrumb__link breadcrumb__link--active">Quản lý dịch vụ</a>
    </nav>
    <!-- End: Breadcrumb -->
</div>
<!-- End: Tiêu đề & Breadcrumb -->

<!-- Start: Khối chức năng -->
<div class="admin-controls">
    <a href="<?= base_url('/admin/service/add') ?>" class="btn btn--primary">Thêm dịch vụ</a>

    <form class="admin-controls__search-form">
        <input type="text" class="admin-controls__search-input" placeholder="Tìm kiếm dịch vụ">
        <button type="submit" class="btn btn--gray">Tìm kiếm</button>
    </form>
</div>
<!-- End: Khối chức năng -->

<!-- Start: Bảng dữ liệu -->
<section class="admin-table-wrapper">
    <!-- Start: Tiêu đề bảng -->
    <h3 class="admin-table__title">Danh sách dịch vụ</h3>
    <!-- End: Tiêu đề bảng -->

    <!-- Start: Bảng dữ liệu -->
    <table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Tên dịch vụ</th>
                <th>Nhóm dịch vụ</th>
                <th>Giá tiền</th>
                <th>Hành động</th>
            </tr>
        </thead>

        <tbody data-type="service">
            <!-- Row 1 -->
            <tr>
                <td>1</td>
                <td>Chăm sóc mèo</td>
                <td>Mèo</td>
                <td>1.000.000 đ</td>
                <td>
                    <a href="<?= base_url('/admin/service/update/1') ?>">
                        <button class="action-btn edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </a>
                    <button class="action-btn delete" data-action="delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            </tr>

            <!-- Row 2 -->
            <tr>
                <td>2</td>
                <td>Tắm cho thú cưng</td>
                <td>Chó, Mèo</td>
                <td>500.000 đ</td>
                <td>
                    <a href="<?= base_url('/admin/service/update/2') ?>">
                        <button class="action-btn edit" data-action="delete">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </a>
                    <button class="action-btn delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            </tr>

            <!-- Row 3 -->
            <tr>
                <td>3</td>
                <td>Cắt móng cho thú cưng</td>
                <td>Chó, Mèo</td>
                <td>800.000 đ</td>
                <td>
                    <a href="<?= base_url('/admin/service/update/3') ?>">
                        <button class="action-btn edit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </button>
                    </a>
                    <button class="action-btn delete" data-action="delete">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </td>
            </tr>
        </tbody>

    </table>
    <!-- End: Bảng dữ liệu -->

</section>
<!-- End: Bảng dữ liệu -->

<!-- Start: Phân trang -->
<div id="pagination">
    <button class="pagination__btn pagination__btn--disabled">
        <i class="fa-solid fa-angle-left"></i>
    </button>

    <button class="pagination__btn pagination__btn--active" data-page="1">1</button>
    <button class="pagination__btn" data-page="2">2</button>
    <button class="pagination__btn">...</button>
    <button class="pagination__btn" data-page="9">9</button>
    <button class="pagination__btn" data-page="10">10</button>

    <button class="pagination__btn">
        <i class="fa-solid fa-angle-right"></i>
    </button>
</div>
<!-- End: Phân trang -->

<?php start_section('popup') ?>
<!-- Start: Modal (popup) dùng để xác nhận các hành động -->
<div class="custom-modal" id="approvalModal">
    <div class="custom-modal__overlay"></div>
    <div class="custom-modal__content">
        <h2 class="custom-modal__title">Tiêu đề modal</h2>

        <p class="custom-modal__message">
            <span class="modal-action-label">Bạn muốn xóa </span>
            <strong id="modalTargetName">“Tên khách hàng”</strong>
            <span class="modal-action-suffix">?</span>
        </p>

        <div class="custom-modal__actions">
            <button class="btn btn--danger" id="cancelBtn">Hủy</button>
            <button class="btn btn--primary" id="confirmBtn">Duyệt</button>
        </div>
    </div>
</div>
<!-- End: Modal (popup) dùng để xác nhận các hành động -->
<?php end_section() ?>

<?php start_section('scripts') ?>

<script src="<?= base_url('cms/assets/js/components/admin-modal-handler.js') ?>"></script>

<?php end_section() ?>
<!-- End: Tiêu đề trang -->