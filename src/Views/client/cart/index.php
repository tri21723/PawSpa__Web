  <?php
    start_section('links');
    ?>
  <link rel="stylesheet" href="<?= base_url('assets/css/cart.css') ?>">
  <?php
    end_section();
    ?>

  <!-- Start: Main -->
  <main class="container mt-4">
      <!-- Progress Steps -->
      <div class="container-xl">
          <ul class="d-flex justify-content-center gap-5 text-xs font-semibold text-[#2e0a5a] py-3">
              <li class="d-flex align-items-center gap-2 step step-1 active">
                  <div class="step-circle">1</div>
                  <span>Chi Tiết Dịch Vụ</span>
              </li>
              <li class="d-flex align-items-center gap-2">
                  <div class="step-circle">2</div>
                  <span class="text-purple-700 fw-medium">Thông Tin</span>
              </li>
              <li class="d-flex align-items-center gap-2">
                  <div class="step-circle">3</div>
                  <span>Nhân Viên</span>
              </li>
              <li class="d-flex align-items-center gap-2">
                  <div class="step-circle inactive">4</div>
                  <span class="text-[#d3d3d3]">Hoàn Tất</span>
              </li>
          </ul>
      </div>

      <div class="row step-content step-1-content active">
          <div class="col-lg-8">
              <table class="table bg-white rounded">
                  <thead class="table-light">
                      <tr>
                          <th><input type="checkbox" id="mainCheckbox"></th>
                          <th>Dịch Vụ</th>
                          <th>Giá Tiền</th>
                          <th>Số Lượng</th>
                          <th>Thành Tiền</th>
                          <th></th>
                      </tr>
                  </thead>
                  <tbody id="service-list">
                      <tr>
                          <td><input type="checkbox" class="service-check" data-name="Cắt tỉa lông chó/mèo" data-price="200000"></td>
                          <td><img src="https://placehold.co/50x50" class="me-2">CẮT TỈA LÔNG CHÓ/MÈO</td>
                          <td class="text-purple">200.000đ <span class="price-old">250.000đ</span></td>
                          <td>
                              <div class="input-group quantity-group" style="width: 120px;">
                                  <button class="btn btn-outline-secondary btn-minus">-</button>
                                  <input type="text" class="form-control text-center quantity-input" value="1">
                                  <button class="btn btn-outline-secondary btn-plus">+</button>
                              </div>
                          </td>
                          <td class="text-purple total-price">200.000đ</td>
                          <td><i class="fa fa-trash text-danger"></i></td>
                      </tr>
                      <tr>
                          <td><input type="checkbox" class="service-check" data-name="Tắm chó mèo" data-price="250000"></td>
                          <td><img src="https://placehold.co/50x50" class="me-2">TẮM CHÓ MÈO</td>
                          <td class="text-purple">250.000đ <span class="price-old">300.000đ</span></td>
                          <td>
                              <div class="input-group quantity-group" style="width: 120px;">
                                  <button class="btn btn-outline-secondary btn-minus">-</button>
                                  <input type="text" class="form-control text-center quantity-input" value="1">
                                  <button class="btn btn-outline-secondary btn-plus">+</button>
                              </div>
                          </td>
                          <td class="text-purple total-price">250.000đ</td>
                          <td><i class="fa fa-trash text-danger"></i></td>
                      </tr>
                  </tbody>
              </table>
          </div>
          <div class="col-lg-4">
              <div class="order-box">
                  <h5>Hóa Đơn <span class="text-muted fs-6">(<span id="selected-count">0</span>) Đã chọn</span></h5>
                  <div id="invoice-items" class="border-bottom my-2 pb-2">
                      <!-- Dịch vụ đã chọn sẽ được thêm vào đây bằng JS -->
                  </div>
                  <label for="coupon" class="form-label">Mã Giảm</label>
                  <div class="input-group mb-3">
                      <input type="text" class="form-control" placeholder="code" id="coupon">
                      <button class="btn btn-purple" id="apply-coupon">Xác Nhận</button>
                  </div>
                  <div class="d-flex justify-content-between">
                      <span>Sau khi sử dụng mã</span><span id="coupon-discount">0đ</span>
                  </div>
                  <div class="d-flex justify-content-between mb-2">
                      <span>Giảm</span><span id="discount-amount">0đ</span>
                  </div>
                  <div class="d-flex justify-content-between fw-bold">
                      <span>Tổng Cộng</span><span id="total-price" class="text-purple">0đ</span>
                  </div>
                  <button class="btn btn-purple w-100 mt-3" id="btnXacNhan">Xác Nhận</button>
              </div>
          </div>
      </div>
  </main>
  <!-- End: Main -->

  <!-- Start: Script -->
  <?php start_section('scripts'); ?>
  <script src="<?= base_url('assets/js/cart.js') ?>"></script>
  <?php end_section(); ?>
  <!-- End: Script -->