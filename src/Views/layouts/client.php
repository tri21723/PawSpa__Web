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

  <!-- Bootstrap 5 CDN -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">


  <!-- CSS dùng chung -->
  <link rel="stylesheet" href="<?= base_url('assets/css/reset.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/common.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/header.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/footer.css') ?>">

  <?php section('links') ?>
</head>

<body>

  <!-- Start: Header -->
  <?php include_partial('client/header') ?>
  <!-- End: Header -->

  <!-- Start: Main content -->
  <?= $content ?>
  <!-- End: Main content -->

  <!-- Start: Footer -->
  <?php include_partial('client/footer') ?>
  <!-- End: Footer -->

  <!-- Link file JS -->
  <?php section('scripts') ?>

</body>

</html>