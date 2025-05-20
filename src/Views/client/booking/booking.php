<?php

// ?>

<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-4">
            <div class="card mb-4">
                <div class="card-body text-center">
                    <img src="https://via.placeholder.com/150" class="rounded-circle mb-3" alt="User Avatar">
                    <h5 class="card-title"><?= htmlspecialchars($user['name']) ?></h5>
                    <p class="card-text">Dashboard User</p>
                </div>
            </div>
            <ul class="list-group mb-4">
                <li class="list-group-item"><a href="#">Tài khoản của tôi</a></li>
                <li class="list-group-item active"><a href="#">Đặt lịch</a></li>
                <li class="list-group-item"><a href="#">Thông báo</a></li>
            </ul>
        </div>
        <div class="col-lg-9 col-md-8">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-tabs mb-4">
                        <li class="nav-item">
                            <a class="nav-link <?= !isset($_GET['status']) || $_GET['status'] === 'all' ? 'active' : '' ?>" href="?status=all">Tất cả</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= isset($_GET['status']) && $_GET['status'] === 'pending' ? 'active' : '' ?>" href="?status=pending">Chờ thanh toán</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= isset($_GET['status']) && $_GET['status'] === 'processing' ? 'active' : '' ?>" href="?status=processing">Đang xử lý</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= isset($_GET['status']) && $_GET['status'] === 'done' ? 'active' : '' ?>" href="?status=done">Đã đặt</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= isset($_GET['status']) && $_GET['status'] === 'cancelled' ? 'active' : '' ?>" href="?status=cancelled">Đã hủy</a>
                        </li>
                    </ul>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Mã đặt</th>
                                <th>Tên dịch vụ</th>
                                <th>Ngày đặt</th>
                                <th>Trạng thái</th>
                                <th>Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($bookings)): ?>
                                <tr>
                                    <td colspan="5" class="text-center">Không có dữ liệu đặt lịch.</td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($bookings as $booking): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($booking['order_code']) ?></td>
                                        <td><?= htmlspecialchars($booking['service_name']) ?></td>
                                        <td><?= htmlspecialchars($booking['booking_date']) ?></td>
                                        <td>
                                            <?php
                                            $statusLabels = [
                                                'pending' => 'Chờ thanh toán',
                                                'processing' => 'Đang xử lý',
                                                'done' => 'Đã đặt',
                                                'cancelled' => 'Đã hủy'
                                            ];
                                            echo htmlspecialchars($statusLabels[$booking['status']]);
                                            ?>
                                        </td>
                                        <td><?= number_format($booking['total_price'], 0, ',', '.') ?>đ</td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <!-- Phân trang -->
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center">
                            <li class="page-item <?= $page <= 1 ? 'disabled' : '' ?>">
                                <a class="page-link" href="?status=<?= $status ?>&page=<?= $page - 1 ?>">Trước</a>
                            </li>
                            <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                                <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                    <a class="page-link" href="?status=<?= $status ?>&page=<?= $i ?>"><?= $i ?></a>
                                </li>
                            <?php endfor; ?>
                            <li class="page-item <?= $page >= $totalPages ? 'disabled' : '' ?>">
                                <a class="page-link" href="?status=<?= $status ?>&page=<?= $page + 1 ?>">Sau</a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</div>