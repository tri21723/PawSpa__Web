<?php start_section('title') ?>
Dashboard - Quản trị
<?php end_section() ?>
<!-- End: Tiêu đề trang -->


<!-- Start: Tiêu đề chính -->
<div class="admin-main__header">
  <h2 class="admin-main__title">Dashboard</h2>
  <!-- Start: Breadcrumb -->
  <nav class="breadcrumb">
    <a href="./dashboard.html" class="breadcrumb__link breadcrumb__link--active">Trang chủ</a>
  </nav>
  <!-- End: Breadcrumb -->
</div>
<!-- End: Tiêu đề chính -->

<!-- Start: Grid Thống kê + Biểu đồ -->
<div class="admin-overview-grid">

  <!-- Start: Các thống kê -->
  <div class="admin-overview__left">

    <!-- Start: Tổng số khách hàng -->
    <div class="admin-card">
      <!-- Tiêu đề -->
      <p class="admin-card__label">Tổng khách hàng</p>

      <!-- Nhóm icon + số liệu -->
      <div class="admin-card__content">
        <div class="admin-card__icon">
          <i class="fa-solid fa-user"></i>
        </div>
        <p class="admin-card__value">145</p>
      </div>
    </div>
    <!-- End: Tổng số khách hàng -->

    <!-- Start: Tổng lịch hẹn -->
    <div class="admin-card">
      <!-- Tiêu đề -->
      <p class="admin-card__label">Số lịch hẹn</p>

      <!-- Icon + Giá trị -->
      <div class="admin-card__content">
        <div class="admin-card__icon">
          <i class="fa-solid fa-calendar-days"></i>
        </div>
        <p class="admin-card__value">145</p>
      </div>
    </div>
    <!-- End: Tổng lịch hẹn -->

    <!-- Start: Số người đang sử dụng dịch vụ -->
    <div class="admin-card">
      <!-- Tiêu đề -->
      <p class="admin-card__label">Đang sử dụng DV</p>

      <!-- Icon + Giá trị -->
      <div class="admin-card__content">
        <div class="admin-card__icon">
          <i class="fa-solid fa-paw"></i>
        </div>
        <p class="admin-card__value">145</p>
      </div>
    </div>
    <!-- End: Số người đang sử dụng dịch vụ -->

    <!-- Start: Số người đã sử dụng dịch vụ -->
    <div class="admin-card">
      <!-- Tiêu đề -->
      <p class="admin-card__label">Đã sử dụng DV</p>

      <!-- Icon + Giá trị -->
      <div class="admin-card__content">
        <div class="admin-card__icon">
          <i class="fa-solid fa-envelope-open-text"></i>
        </div>
        <p class="admin-card__value">1</p>
      </div>
    </div>
    <!-- End: Số người đã sử dụng dịch vụ -->

  </div>
  <!-- End: Các thẻ thống kê -->

  <!-- Start: Biểu đồ tròn -->
  <div class="admin-overview__right">

    <!-- Start: Biểu đồ doanh thu -->
    <div class="admin-chart">
      <!-- Start: Nhãn + Bộ lọc -->
      <div class="admin-chart__header">
        <p class="admin-chart__label">Doanh thu</p>
        <select class="admin-chart__select">
          <option>Tuần</option>
          <option>Tháng</option>
          <option>Quý</option>
        </select>
      </div>
      <!-- End: Nhãn + Bộ lọc -->

      <!-- Start: Vòng tròn biểu đồ -->
      <div class="admin-chart__circle">
        <canvas id="revenueChart" width="213" height="213"></canvas>
        <div class="admin-chart__value">52%</div>
      </div>
      <!-- End: Vòng tròn biểu đồ -->

    </div>
    <!-- Start: Biểu đồ doanh thu -->

    <!-- Start: Biểu đồ Dịch vụ -->
    <div class="admin-chart">

      <!-- Start: Nhãn + Bộ lọc -->
      <div class="admin-chart__header">
        <p class="admin-chart__label">Dịch vụ</p>
        <select class="admin-chart__select">
          <option>Tuần</option>
          <option>Tháng</option>
          <option>Quý</option>
        </select>
      </div>
      <!-- End: Nhãn + Bộ lọc -->

      <!-- Vòng tròn biểu đồ -->
      <div class="admin-chart__circle">
        <canvas id="serviceChart" width="213" height="213"></canvas>
        <div class="admin-chart__value">79%</div>
      </div>
      <!-- End: Vòng tròn biểu đồ -->

    </div>
    <!-- End: Biểu đồ Dịch vụ -->

  </div>
  <!-- End: Biểu đồ tròn -->

</div>
<!-- End: Grid Thống kê + Biểu đồ -->

<!-- Start: Bảng danh sách lịch hẹn -->
<section class="admin-table-wrapper">
  <h3 class="admin-table__title">Danh sách lịch hẹn</h3>

  <table class="admin-table">
    <thead>
      <tr>
        <th>#</th>
        <th>Tên dịch vụ</th>
        <th>Khách hàng</th>
        <th>Nhân viên</th>
        <th>Giá tiền</th>
        <th>Trạng thái</th>
        <th>Ngày thực hiện</th>
        <th>Ngày tạo lịch</th>
        <th>Hành động</th>
      </tr>
    </thead>

    <tbody data-type="appointment">
      <!-- Row 1 -->
      <tr>
        <td>1</td>
        <td>Chăm sóc mèo</td>
        <td>Nguyễn Văn A<br><span class="admin-table__email">(a@gmail.com)</span></td>
        <td>Trà Bảo Lan<br><span class="admin-table__code">(NV002)</span></td>
        <td>1.000.000 đ</td>
        <td><span class="status status--pending">Đang chờ...</span></td>
        <td>11/03/2025</td>
        <td>11/03/2025 10:00</td>
        <td><button class="btn btn--danger" data-action="approve">Duyệt</button></td>
      </tr>

      <!-- Row 2 -->
      <tr>
        <td>2</td>
        <td>Tắm cho thú cưng</td>
        <td>Trần Tuấn Anh<br><span class="admin-table__email">(anh@gmail.com)</span></td>
        <td>Mai Ngọc Bích<br><span class="admin-table__code">(NV003)</span></td>
        <td>500.000 đ</td>
        <td><span class="status status--inprogress">Đang thực hiện...</span></td>
        <td>11/03/2025</td>
        <td>11/03/2025 12:00</td>
        <td><button class="btn btn--info" data-action="complete">Đã xác nhận</button></td>
      </tr>

      <!-- Row 3 -->
      <tr>
        <td>3</td>
        <td>Cắt móng cho thú cưng</td>
        <td>Thái Thanh Thanh<br><span class="admin-table__email">(thanh@gmail.com)</span></td>
        <td>Nguyễn Ngọc Mai<br><span class="admin-table__code">(NV001)</span></td>
        <td>800.000 đ</td>
        <td><span class="status status--success">Đã hoàn thành</span></td>
        <td>11/03/2025</td>
        <td>10/03/2025 12:00</td>
        <td><button class="btn btn--success">Hoàn thành</button></td>
      </tr>
    </tbody>
  </table>
</section>
<!-- End: Bảng danh sách lịch hẹn -->

<?php start_section('popup') ?>
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
<?php end_section() ?>

<!-- Script -->
<?php start_section('scripts') ?>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?= base_url('cms/assets/js/revenue-chart.js') ?>"></script>
<script src="<?= base_url('cms/assets/js/serviceChart.js') ?>"></script>
<script src="<?= base_url('cms/assets/js/components/admin-modal-handler.js') ?>"></script>
<?php end_section() ?>