<?php
// Kết nối

require_once "../../Controllers/connectdb.php";

// detail_service.php?service_id=1
if (isset($_GET['service_id'])) {
    $service_id = $_GET['service_id'];
} else {
    // Xử lý khi không có service_id
    die("Thiếu ID dịch vụ");
}

$sql = "SELECT * FROM services s 
        JOIN service_details d ON s.service_id = d.service_id join service_images si on si.detail_id=d.detail_id
        WHERE s.service_id = ?";
$conn = connectDatabase();
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $service_id);
$stmt->execute();
$service = $stmt->get_result()->fetch_assoc();
// Lấy tất cả hình ảnh liên quan
$sql_images = "SELECT si.image_url FROM service_images si
               JOIN service_details d ON si.detail_id = d.detail_id
               WHERE d.service_id = ?";
$stmt_images = $conn->prepare($sql_images);
$stmt_images->bind_param("i", $service_id);
$stmt_images->execute();
$image_result = $stmt_images->get_result();
$images = $image_result->fetch_all(MYSQLI_ASSOC);

?>
<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Chi tiết sản phẩm - Cắt tỉa lông tạo kiểu</title>
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
    <link rel="stylesheet" href="../../../public/assets/css/commonn.css">
    <link rel="stylesheet" href="../../../public/assets/css/reset.css">
    <link rel="stylesheet" href="../../../public/assets/css/footer.css">
    <link rel="stylesheet" href="../../../public/assets/css/detail_service.css">
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

  <main class="product-detail">

    <!-- Banner sản phẩm -->
    <div class="banner" >
      <img src="../../../public/assets/images/banner.png" alt="Banner Sản Phẩm" class="banner-img">
      <!-- <img src="pngwing.com.png" alt="Overlay Image" class="overlay-img"> -->
    </div>
    <br>
    <!-- Đường dẫn breadcrumb -->
    <nav class="breadcrumb">
      <a href="/Du-An-Web/Product/service.html">Dịch vụ</a> &gt; <a href="/Du-An-Web/Product/CatTiaLong.html">Cắt Tỉa Lông Cho Pet</a> &gt; <span>Cắt Tỉa Lông Tạo Kiểu</span>
    </nav>

    <!-- Chi tiết sản phẩm -->
    <section class="product-main container">
      <div class="product-images">
        <!-- <img src="product1.png" alt="Cắt tỉa lông tạo kiểu" class="main-image"> -->
        <<!-- Carousel -->
<div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-inner">
  <?php foreach ($images as $index => $img):  ?>
      <div class="carousel-item <?= $index === 0 ? 'active' : '' ?>">
        <img src="<?= $img['image_url'] ?>" class="d-block w-100 img-fluid object-fit-contain" style="height: 400px;" alt="Image <?= $index + 1 ?>">
      </div>
    <?php endforeach; ?>
  </div>
  <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Previous</span>
  </button>
  <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
    <span class="carousel-control-next-icon" aria-hidden="true"></span>
    <span class="visually-hidden">Next</span>
  </button>
</div>

        <div class="thumbnail-images">
  <?php foreach ($images as $index => $img): ?>
    <img src="<?= $img['image_url'] ?>" 
         data-bs-target="#carouselExampleControls" 
         data-bs-slide-to="<?= $index ?>" 
         alt="Thumbnail <?= $index + 1 ?>" 
         style="width: 100px; cursor: pointer; margin: 0 5px;">
  <?php endforeach; ?>
</div>

      </div>
      <!-- <div class="rating">⭐ (<?= $service['rating'] ?>) <?= $service['sold'] ?> Sold</div> -->
      <div>
      <div class="product-info">
        <h1><?= strtoupper($service['name']) ?></h1>
        <div class="rating">
    <?php
    $rating = round($service['rating']); // Làm tròn số sao nếu là float (ví dụ 4.3 → 4)
    $maxStars = 5;

    // Hiển thị sao đầy ⭐
    for ($i = 0; $i < $rating; $i++) {
        echo '⭐';
    }

    // Hiển thị sao trống ☆
    for ($i = $rating; $i < $maxStars; $i++) {
        echo '☆';
    }
    ?>
    (<?= $service['rating'] ?>) <?= $service['sold'] ?> Sold
</div>

        <div class="price">
        <span class="current-price">$<?= $service['price'] ?></span>
        <span class="old-price">$<?= $service['original_price'] ?></span>
        </div>
        <div class="variant-group">
          <label>Dog Breed:</label>
          <div class="variant-options">
            <button class="variant-button active">Green</button>
            <button class="variant-button">Sky Blue</button>
            <button class="variant-button">Orange</button>
            <button class="variant-button">Pink Light</button>
            <button class="variant-button">Black</button>
          </div>
        </div>
        
        <div class="variant-group">
          <label>Cat Breed:</label>
          <div class="variant-options">
            <button class="variant-button active">Green</button>
            <button class="variant-button">Sky Blue</button>
            <button class="variant-button">Orange</button>
            <button class="variant-button">Pink Light</button>
            <button class="variant-button">Black</button>
          </div>
        </div>
        
       

        <div class="actions">
          <button class="btn-primary">Đặt lịch ngay</button>
        </div>

      </div>
    </section>

    <!-- Tab thông tin sản phẩm và đánh giá -->
    <section class="product-tabs container">
      <!-- <div class="tabs">
        <button class="tab active">Thông tin sản phẩm</button>
        <button class="tab">Đánh giá</button>
      </div>
      <div class="tab-content active">
        <h2>Thông tin chi tiết</h2>
        <p>Chi tiết về sản phẩm/dịch vụ, mô tả các lợi ích, công thức sử dụng...</p>
      </div>
      <div class="tab-content">
        <h2>Đánh giá</h2>
        <p>Phần hiển thị các đánh giá của khách hàng.</p>
      </div> -->
      <!-- Bootstrap 5 -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<div class="container my-4">
  <!-- Tabs -->
  <ul class="nav nav-tabs mb-4">
    <li class="nav-item">
    </li>
    <li class="nav-item">
    </li>
  </ul>

  <div class="row">
    <!-- Sidebar -->
    <div class="col-md-3">
      <div class="list-group mb-4">
        <a href="#" class="list-group-item list-group-item-action active">Information</a>

      </div>

      <div class="card">
        <?php
    echo $service['info']
    ?>
      </div>
    </div>

    <!-- Main content -->
    <div class="col-md-9">
    <?php
    echo $service['description']
    ?>
    </div>
  </div>
</div>

    </section>

    <!-- Sản phẩm liên quan -->
  

  </main>

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script>
  document.querySelectorAll('.variant-group').forEach(group => {
    const buttons = group.querySelectorAll('.variant-button');

    buttons.forEach(button => {
      button.addEventListener('click', () => {
        buttons.forEach(btn => btn.classList.remove('active'));
        button.classList.add('active');
      });
    });
  });
</script>

</body>

</html>