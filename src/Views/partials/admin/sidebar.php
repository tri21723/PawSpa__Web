<aside class="admin-sidebar">
        <nav class="admin-sidebar__nav">
            <ul class="admin-sidebar__menu">
                <li class="admin-sidebar__item admin-sidebar__item--active">
                    <a href="./dashboard.html" class="admin-sidebar__link">
                        <i class="fa-solid fa-chart-line admin-sidebar__icon"></i>
                        <span class="admin-sidebar__label">Dashboard</span>
                    </a>
                </li>
                <li class="admin-sidebar__item">
                    <a href="./pages/customer/customer-management.html" class="admin-sidebar__link">
                        <i class="fa-solid fa-users admin-sidebar__icon"></i>
                        <span class="admin-sidebar__label">Quản lý khách hàng</span>
                    </a>
                </li>
                <li class="admin-sidebar__item">
                    <a href="/petcareweb_admin/pages/staff/staff-management.html" class="admin-sidebar__link">
                        <i class="fa-solid fa-user-nurse admin-sidebar__icon"></i>
                        <span class="admin-sidebar__label">Quản lý nhân viên</span>
                    </a>
                </li>
                <li class="admin-sidebar__item">
                    <a href="<?= base_url('/admin/service') ?>" class="admin-sidebar__link">
                        <i class="fa-solid fa-dog admin-sidebar__icon"></i>
                        <span class="admin-sidebar__label">Quản lý dịch vụ</span>
                    </a>
                </li>
                <li class="admin-sidebar__item">
                    <a href="<?= base_url('/admin/service-type')?>" class="admin-sidebar__link">
                        <i class="fa-solid fa-paw admin-sidebar__icon"></i>
                        <span class="admin-sidebar__label">Quản lý loại dịch vụ</span>
                    </a>
                </li>
                <li class="admin-sidebar__item">
                    <a href="./pages/appointment/appointment-management.html" class="admin-sidebar__link">
                        <i class="fa-solid fa-calendar-check admin-sidebar__icon"></i>
                        <span class="admin-sidebar__label">Quản lý lịch hẹn</span>
                    </a>
                </li>
                <li class="admin-sidebar__item">
                    <a href="#" class="admin-sidebar__link admin-sidebar__link--logout">
                        <i class="fa-solid fa-sign-out-alt admin-sidebar__icon"></i>
                        <span class="admin-sidebar__label">Đăng xuất</span>
                    </a>
                </li>
            </ul>
        </nav>
    </aside>