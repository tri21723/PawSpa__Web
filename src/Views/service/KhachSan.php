<?php
// Kết nối

require_once "../../Controllers/connectdb.php";

$sql = "SELECT * FROM services WHERE service_type_id = 2"; // 👉 lọc theo loại dịch vụ
$conn = connectDatabase();
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Dịch Vụ Pet</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="../../../public/assets/css/ProductPageCss.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Audiowide&display=swap" rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Audiowide&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="../../../public/assets/css/header.css">
    <link rel="stylesheet" href="../../../public/assets/css/common.css">
    <link rel="stylesheet" href="../../../public/assets/css/reset.css">
    <link rel="stylesheet" href="../../../public/assets/css/footer.css">
</head>
<body>
  <!-- Start: Header -->
    <header id="header">
      <div class="pawspa__container pawspa__flex-between">
          <!-- Start: Logo -->
          <a href="/index.html" id="pawspa-logo" aria-label="Go to homepage" class="pawspa-header__logo">
              <img src="../../../public/assets/images/icons/Union.svg" alt="Logo" class="pawspa-logo__image">
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
                  <img src="../../../public/assets/images/icons/noti.svg" alt="Notify" class="pawspa-icon__image">
              </a>
              <a href="#" class="pawspa-icon__link" aria-label="Cart">
                  <img src="../../../public/assets/images/icons/cart.svg" alt="Cart" class="pawspa-icon__image">
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
  <div class="container service-section">
    <h2 class="section-title text-center">CẮT TỈA LÔNG CHO PET</h2>
    <div class="row g-4">

      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): 
          ?>
          <div class="col-md-3">
            <div class="product-card p-2">
              <img src="<?= $row['image'] ?>" class="product-image w-100 mb-2" alt="<?= $row['name'] ?>" />
              <h6 class="fw-bold"><?= strtoupper($row['name']) ?></h6>
              <div class="rating">⭐ (<?= $row['rating'] ?>) <?= $row['sold'] ?> Sold</div>
              <div>
                <span class="price">$<?= $row['price'] ?></span>
                <span class="old-price">$<?= $row['original_price'] ?></span>
              </div>
              <button
                class="btn btn-purple w-100 mt-2"
                style="background-color: #6f42c1; color: white" 
                onclick="window.location.href='/Web_Backend/PawSpa__Web/src/Views/service/detail_service.php?service_id=<?= $row['service_id'] ?>'"
              >
                Book Now
              </button>
              <!-- onclick="window.location.href='/Du-An-Web/Product/detail_service.php?id=<?= $row['service_id'] ?>'"  -->

            </div> 
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-center">Chưa có dịch vụ nào.</p>
      <?php endif; ?>

    </div>
  </div>
  <footer id="footer">
      <div class="pawspa__container pawspa__flex-between">
          <div class="pawspa-footer__info">
              <img src="../../../public/assets/images/icons/Union.svg" alt="Logo Pawspa" class="pawspa-footer__logo">
              <p class="pawspa-footer__description">
                  Chào mừng đến với Cuddle & Care Pets! Chúng tôi cung cấp các dịch vụ chăm
                  sóc và tư vấn sức khỏe cho thú cưng của bạn.
              </p>
              <div class="pawspa-footer__contact">
                  <div class="pawspa-footer__contact-item">
                      <img src="../../../public/assets/images/icons/letter.svg" alt="Email" class="pawspa-footer__contact-icon">
                      <a href="mailto:chaumlp@gmail.com" class="pawspa-footer__contact-address">chaumlp@gmail.com</a>
                  </div>
                  <div class="pawspa-footer__contact-item">
                      <img src="../../../public/assets/images/icons/phone.svg" alt="Phone" class="pawspa-footer__contact-icon">
                      <a href="tel:0345663153" class="pawspa-footer__contact-address">0345663153</a>
                  </div>
              </div>
              <div class="pawspa-footer__social">
                  <a href="#" title="Instagram">
                      <img src="../../../public/assets/images/icons/social-media/ins.svg" alt="Instagram"
                          class="pawspa-footer__social-icon">
                  </a>
                  <a href="#" title="Facebook">
                      <img src="../../../public/assets/images/icons/social-media/fb.svg" alt="Facebook"
                          class="pawspa-footer__social-icon">
                  </a>
                  <a href="#" title="LinkedIn">
                      <img src="../../../public/assets/images/icons/social-media/link.svg" alt="LinkedIn"
                          class="pawspa-footer__social-icon">
                  </a>
              </div>
          </div>
  
          <div class="pawspa-footer__image">
              <div>
                  <div>
                      <img src="../../../public/assets/images/footer/Rectangle 170.svg" alt="" aria-hidden="true">
                  </div>
              </div>
          </div>
  
          <div class="pawspa-footer__category">
              <div class="pawspa-footer__category-item">
                  <h3 class="pawspa-footer__category-title">Dịch vụ</h3>
                  <ul class="pawspa-footer__category-list">
                      <li class="pawspa-footer__category-list-item">
                          <a href="#" class="pawspa-footer__category-item-link">Spa</a>
                      </li>
                      <li class="pawspa-footer__category-list-item">
                          <a href="#" class="pawspa-footer__category-item-link">Cắt tỉa lông</a>
                      </li>
                      <li class="pawspa-footer__category-list-item">
                          <a href="#" class="pawspa-footer__category-item-link">Khách sạn lưu trú</a>
                      </li>
                  </ul>
              </div>
              <div class="pawspa-footer__category-item">
                  <h3 class="pawspa-footer__category-title">Nền tảng</h3>
                  <ul class="pawspa-footer__category-list">
                      <li class="pawspa-footer__category-list-item">
                          <a href="#" class="pawspa-footer__category-item-link">Dịch vụ</a>
                      </li>
                      <li class="pawspa-footer__category-list-item">
                          <a href="#" class="pawspa-footer__category-item-link">Blog/Tin tức</a>
                      </li>
                      <li class="pawspa-footer__category-list-item">
                          <a href="#" class="pawspa-footer__category-item-link">Giới thiệu</a>
                      </li>
                      <li class="pawspa-footer__category-list-item">
                          <a href="#" class="pawspa-footer__category-item-link">Liên lạc</a>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
  
      <div class="pawspa-footer__image--left">
          <img src="../../../public/assets/images/footer/footer-01.svg" alt="">
      </div>
      <div class="pawspa-footer__image--right">
          <img src="../../../public/assets/images/footer/footer-02.svg" alt="">
      </div>
  </footer>
</body>
</html>

<?php
$conn->close();
?>
