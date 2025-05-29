<?php
// $user, $notifications, $page, $totalPages được truyền từ controller
?>
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/notifications.css">
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
                <li ><a href="<?= BASE_URL ?>/booking">Đặt lịch</a></li>
                <li class="active"><a href="<?= BASE_URL ?>/notifications">Thông báo</a></li>
            </ul>
        </nav>
    </aside>


        <!-- Notifications Section -->
        <section class="notification-content">
            <div class="notification-header">
                <h2>Thông Báo</h2>
            </div>
            
            <div class="notification-list">
                <?php if (empty($notifications)): ?>
                    <div class="notification-empty">
                        <img src="<?= BASE_URL ?>/assets/images/icons/empty-box.svg" alt="Empty">
                        <p>Không có thông báo nào</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($notifications as $notification): ?>
                        <div class="notification-item">
                            <div class="notification-icon">
                                <img src="<?= BASE_URL ?>/assets/images/icons/paw-purple.svg" alt="Icon" class="logo-image">
                            </div>
                            <div class="notification-info">
                                <p class="notification-text">
                                    Lịch đặt <strong>#<?= htmlspecialchars($notification['booking_id']) ?></strong> 
                                    <?php 
                                    $message = match($notification['status']) {
                                        'pending' => 'của bạn đang chờ thanh toán, hãy xác nhận',
                                        'processing' => 'của bạn đang được xử lí',
                                        'completed' => 'của bạn đã hoàn thành',
                                        'cancelled' => 'của bạn đã được xử lí, hãy xác nhận',
                                        default => 'đã được cập nhật'
                                    };
                                    echo $message;
                                    ?>
                                </p>
                            </div>
                            <button type="button" class="notification-btn">
        <?= $notification['status'] === 'completed' ? 'Xem chi tiết' : 'Xác nhận' ?>
    </button>
                        </div>
                    <?php endforeach; ?>

                    <div class="pagination">
                        <?php if ($page > 1): ?>
                            <a href="?page=<?= $page-1 ?>" class="page-link prev">&lt;</a>
                        <?php endif; ?>

                        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                            <?php if ($i === 1 || $i === $totalPages || ($i >= $page - 1 && $i <= $page + 1)): ?>
                                <a href="?page=<?= $i ?>" class="page-link <?= $i === $page ? 'active' : '' ?>">
                                    <?= $i ?>
                                </a>
                            <?php elseif ($i === $page - 2 || $i === $page + 2): ?>
                                <span class="dots">...</span>
                            <?php endif; ?>
                        <?php endfor; ?>

                        <?php if ($page < $totalPages): ?>
                            <a href="?page=<?= $page+1 ?>" class="page-link next">&gt;</a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </section>
    </div>
</main>