<!DOCTYPE html>
<html lang="vi">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= section('title', 'Admin') ?></title>

  <!-- CSS - Library - Start -->
  <!-- CSS - Font -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Audiowide&display=swap" rel="stylesheet">
  <link
    href="https://fonts.googleapis.com/css2?family=Audiowide&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
    rel="stylesheet">
  <link
    href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&family=Nunito:ital,wght@0,200..1000;1,200..1000&display=swap"
    rel="stylesheet">

  <!-- Icon - Font awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

  <!-- CSS - Library - End -->

  <!-- CSS - Project -->
  <link rel="stylesheet" href="<?= base_url('assets/css/admin-common.css') ?>">

  <?php section('links') ?>
</head>

<body>
  <!-- Header -->
  <?php include_partial('admin/header') ?>

  <!-- Start: Sidebar -->
  <?php include_partial('admin/sidebar') ?>
  <!-- End: Sidebar -->

  <!-- Start: Main content -->
  <main class="admin-main">
    <div class="admin-main__container">
      <?= $content ?>
    </div>
  </main>
  <!-- End: Main content -->

  <!-- Start: Modal (popup) dùng để xác nhận các hành động -->
  <?php section('popup') ?>
  <!-- End: Modal (popup) dùng để xác nhận các hành động -->

  <script src="<?= base_url('assets/js/hidden-alert.js') ?>"></script>
  <!-- Link file JS -->
  <?php section('scripts') ?>
</body>

</html>