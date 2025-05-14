    
    <header id="header">
        <div class="pawspa__container pawspa__flex-between">
            <!-- Start: Logo -->
            <a href="/index.html" id="pawspa-logo" aria-label="Go to homepage" class="pawspa-header__logo">
                <img src="<?= base_url('assets/images/icons/Union.svg') ?>" alt="Logo" class="pawspa-logo__image">
                <span class="pawspa-logo__text">Pawspa</span>
            </a>
            <!-- End: Logo -->

            <!-- Start: Navigation -->
            <nav id="pawspa-nav">
                <ul class="pawspa-nav__list">
                    <li class="pawspa-nav__item">
                        <a href="/index.html">Trang chủ</a>
                    </li>
                    <li class="pawspa-nav__item">
                        <a href="#">Dịch vụ</a>
                    </li>
                    <li class="pawspa-nav__item">
                        <a href="#">Blog/Tin tức</a>
                    </li>
                    <li class="pawspa-nav__item">
                        <a href="#">Giới thiệu</a>
                    </li>
                    <li class="pawspa-nav__item">
                        <a href="#">Liên lạc</a>
                    </li>
                </ul>
            </nav>
            <!-- End: Navigation -->

            <!-- Start: Icon + Action -->
            <div class="pawspa-header__actions">
                <a href="#" class="pawspa-icon__link" aria-label="Notifications">
                    <img src="<?= base_url('assets/images/icons/noti.svg') ?>" alt="Notify" class="pawspa-icon__image">
                </a>
                <a href="./GioHang/CTDV.html" class="pawspa-icon__link" aria-label="Cart">
                    <img src="<?= base_url('assets/images/icons/cart.svg') ?>" alt="Cart" class="pawspa-icon__image">
                </a>
                <div class="pawspa-auth__links">
                    <a href="/pages/login.html" class="pawspa-auth__link">Đăng nhập</a>
                    <span class="pawspa-auth__separator">/</span>
                    <a href="/pages/register.html" class="pawspa-auth__link">Đăng ký</a>
                </div>
            </div>
            <!-- End: Icon + Action -->
        </div>
    </header>
