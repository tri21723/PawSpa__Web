<?php
// Không cần đóng thẻ PHP ở đây
?>
<link rel="stylesheet" href="<?= base_url('assets/css/booking.css') ?>">

<main class="main-wrapper">
    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="user-info">
            <img src="<?= base_url('assets/images/avatar.png') ?>" alt="Avatar" class="user-avatar">
            <div class="user-meta">
                <div class="user-name"><?= htmlspecialchars($user['name']) ?></div>
                <div class="user-role">Dashboard <span class="role-type">User</span></div>
            </div>
            <div class="refresh-icon">
                <img src="<?= base_url('assets/images/icons/ArrowsCounterClockwise.png') ?>" alt="Refresh">
            </div>
        </div>
        <nav class="user-nav">
            <ul>
                <li><a href="#">Tài khoản của tôi</a></li>
                <li class="active"><a href="#">Đặt lịch</a></li>
                <li><a href="#">Thông báo</a></li>
            </ul>
        </nav>
    </aside>

    <!-- Booking Content -->
    <section class="booking-content">
        <!-- Filter & Tabs -->
        <div class="booking-filter">
            <div class="search-wrapper">
                <img src="../../../../public/assets/images/icons/MagnifyingGlass.png" alt="Magnifying Glass" class="search-icon">
                <input type="text" class="search-input" placeholder="Tìm mã, tên sản phẩm...">
            </div>
            <ul class="booking-tabs">
                <li class="<?= !isset($_GET['status']) || $_GET['status'] === 'all' ? 'active' : '' ?>">
                    <a href="?status=all">Tất cả</a>
                </li>
                <li class="<?= isset($_GET['status']) && $_GET['status'] === 'pending' ? 'active' : '' ?>">
                    <a href="?status=pending">Chờ thanh toán</a>
                </li>
                <li class="<?= isset($_GET['status']) && $_GET['status'] === 'processing' ? 'active' : '' ?>">
                    <a href="?status=processing">Đang xử lý</a>
                </li>
                <li class="<?= isset($_GET['status']) && $_GET['status'] === 'done' ? 'active' : '' ?>">
                    <a href="?status=done">Đã đặt</a>
                </li>
                <li class="<?= isset($_GET['status']) && $_GET['status'] === 'cancelled' ? 'active' : '' ?>">
                    <a href="?status=cancelled">Đã hủy</a>
                </li>
            </ul>
        </div>

        <!-- Booking Table -->
        <div class="booking-table">
            <div class="booking-row booking-header">
                <div>Mã đặt</div>
                <div>Tên dịch vụ</div>
                <div>Ngày đặt</div>
                <div>Trạng thái</div>
                <div>Thành tiền</div>
            </div>
            <?php if (empty($bookings)): ?>
                <div class="booking-row">
                    <div colspan="5" style="grid-column: 1 / span 5; text-align:center;">Không có dữ liệu đặt lịch.</div>
                </div>
            <?php else: ?>
                <?php
                $statusLabels = [
                    'pending' => ['label' => 'Chờ thanh toán', 'class' => 'status-pending'],
                    'processing' => ['label' => 'Đang xử lý', 'class' => 'status-processing'],
                    'done' => ['label' => 'Đã đặt', 'class' => 'status-done'],
                    'cancelled' => ['label' => 'Đã hủy', 'class' => 'status-cancelled']
                ];
                foreach ($bookings as $booking):
                    $status = $booking['status'];
                    $statusInfo = $statusLabels[$status] ?? ['label' => ucfirst($status), 'class' => ''];
                ?>
                <div class="booking-row">
                    <div><?= htmlspecialchars($booking['order_code']) ?></div>
                    <div class="service-name"><span><?= htmlspecialchars($booking['service_name']) ?></span></div>
                    <div><?= htmlspecialchars($booking['booking_date']) ?></div>
                    <div>
                        <span class="status <?= $statusInfo['class'] ?>">
                            <?= htmlspecialchars($statusInfo['label']) ?>
                        </span>
                    </div>
                    <div><?= number_format($booking['total_price'], 0, ',', '.') ?>đ</div>
                </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Pagination -->
        <div class="pagination">
            <a class="prev <?= $page <= 1 ? 'disabled' : '' ?>" href="?status=<?= $status ?>&page=<?= max(1, $page - 1) ?>" title="Trang trước">&laquo;</a>
            
            <?php
            // Hiển thị tối đa 5 trang
            $startPage = max(1, min($page - 2, $totalPages - 4));
            $endPage = min($totalPages, max(5, $page + 2));
            
            // Hiển thị trang đầu tiên nếu không nằm trong phạm vi hiển thị
            if ($startPage > 1) {
                echo '<a href="?status=' . $status . '&page=1">1</a>';
                if ($startPage > 2) {
                    echo '<span>...</span>';
                }
            }
            
            // Hiển thị các trang trong phạm vi
            for ($i = $startPage; $i <= $endPage; $i++) {
                echo '<a href="?status=' . $status . '&page=' . $i . '" class="' . ($i === $page ? 'active' : '') . '">' . $i . '</a>';
            }
            
            // Hiển thị trang cuối cùng nếu không nằm trong phạm vi hiển thị
            if ($endPage < $totalPages) {
                if ($endPage < $totalPages - 1) {
                    echo '<span>...</span>';
                }
                echo '<a href="?status=' . $status . '&page=' . $totalPages . '">' . $totalPages . '</a>';
            }
            ?>
            
            <a class="next <?= $page >= $totalPages ? 'disabled' : '' ?>" href="?status=<?= $status ?>&page=<?= min($totalPages, $page + 1) ?>" title="Trang sau">&raquo;</a>
        </div>
    </section>
</main>