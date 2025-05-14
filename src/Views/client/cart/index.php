<?php start_section('links'); ?>

<link rel="stylesheet" href="<?= base_url('assets/css/cart.css') ?>">

<?php end_section(); ?>

  <!-- Start: Main -->
  <main class="container mt-4">
      <!-- Progress Steps -->
      <div class="container-xl">
          <ul class="d-flex justify-content-center gap-5 text-xs font-semibold text-[#2e0a5a] py-3">
              <li class="d-flex align-items-center gap-2 step step-1 active">
                  <div class="step-circle">1</div>
                  <span>Giỏ Hàng</span>
              </li>
              <li class="d-flex align-items-center gap-2 step-no-bold">
                  <div class="step-circle">2</div>
                  <span>Thông Tin</span>
              </li>
              <li class="d-flex align-items-center gap-2 step-no-bold">
                  <div class="step-circle">3</div>
                  <span>Nhân Viên</span>
              </li>
              <li class="d-flex align-items-center gap-2 step">
                  <div class="step-circle inactive">4</div>
                  <span>Hoàn Tất</span>
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
                  <div id="invoice-items" class="border-bottom my-2 pb-2"></div>
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
      <!-- Snackbar container -->
      <div class="toastBox"></div>
  </main>
  <!-- End: Main -->

  <!-- Start: Script -->
  <?php start_section('scripts'); ?>

  <script data-cfasync="false" src="/cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script>

  <script>
      document.addEventListener('DOMContentLoaded', function() {
          const checkboxes = document.querySelectorAll('.service-check');
          const mainCheckbox = document.querySelector('#mainCheckbox');
          const invoiceItems = document.getElementById('invoice-items');
          const totalPriceElem = document.getElementById('total-price');
          const selectedCount = document.getElementById('selected-count');
          const couponInput = document.getElementById('coupon');
          const applyCouponBtn = document.getElementById('apply-coupon');
          const couponDiscountElem = document.getElementById('coupon-discount');
          const discountAmountElem = document.getElementById('discount-amount');
          const toastBox = document.querySelector('.toastBox');
          let discount = 0;

          // Kiểm tra toastBox có tồn tại không
          if (!toastBox) {
              console.error('toastBox không tồn tại! Vui lòng kiểm tra thẻ <div class="toastBox"> trong HTML.');
          }

          // Hàm hiển thị snackbar
          function showToast(message, type) {
              if (!toastBox) {
                  console.error('toastBox không tồn tại! Vui lòng kiểm tra thẻ <div class="toastBox"> trong HTML.');
                  return;
              }
              console.log('Showing toast:', message, type); // Debug
              const toast = document.createElement('div');
              toast.classList.add('toast', type);
              toast.innerHTML = `
          <button class="close-btn"><i class="fas fa-times"></i></button>
          <i class="fas fa-times-circle"></i>
          ${message}
        `;
              toastBox.appendChild(toast);

              const closeButton = toast.querySelector('.close-btn');
              closeButton.addEventListener('click', () => {
                  toast.remove();
              });

              setTimeout(() => {
                  toast.remove();
              }, 3000);
          }

          // Hàm lưu trạng thái vào localStorage
          function saveState() {
              const state = {
                  services: Array.from(checkboxes).map(checkbox => ({
                      name: checkbox.getAttribute('data-name'),
                      checked: checkbox.checked,
                      quantity: parseInt(checkbox.closest('tr').querySelector('.quantity-input').value)
                  })),
                  coupon: couponInput.value,
                  discount: discount
              };
              localStorage.setItem('serviceState', JSON.stringify(state));
          }

          // Hàm khôi phục trạng thái từ localStorage
          function restoreState() {
              const state = JSON.parse(localStorage.getItem('serviceState'));
              if (state && state.services) {
                  state.services.forEach(service => {
                      const checkbox = document.querySelector(`.service-check[data-name="${service.name}"]`);
                      if (checkbox) {
                          checkbox.checked = service.checked;
                          const row = checkbox.closest('tr');
                          const qtyInput = row.querySelector('.quantity-input');
                          qtyInput.value = service.quantity;
                          updateRow(row);

                          if (service.checked) {
                              const price = parseInt(checkbox.getAttribute('data-price'));
                              const item = document.createElement('div');
                              item.className = 'invoice-line';
                              item.setAttribute('data-name', service.name);
                              item.setAttribute('data-price', price);
                              item.setAttribute('data-quantity', service.quantity);
                              item.innerHTML = `
                  <span>${service.name}</span>
                  <span class="invoice-qty">${service.quantity}</span>
                  <span class="invoice-sum">${(price * service.quantity).toLocaleString('vi-VN')}đ</span>`;
                              invoiceItems.appendChild(item);
                          }
                      }
                  });
                  couponInput.value = state.coupon || '';
                  discount = state.discount || 0;
                  couponDiscountElem.textContent = discount.toLocaleString('vi-VN') + 'đ';
                  discountAmountElem.textContent = discount.toLocaleString('vi-VN') + 'đ';
                  updateTotal();
                  checkAllSelected();
              }
          }

          // Hàm cập nhật tổng tiền và số lượng dịch vụ đã chọn
          function updateTotal() {
              const items = invoiceItems.querySelectorAll('.invoice-line');
              let total = 0;
              items.forEach(item => {
                  const qty = parseInt(item.getAttribute('data-quantity')) || 1;
                  const price = parseInt(item.getAttribute('data-price'));
                  total += qty * price;
              });
              total -= discount;
              totalPriceElem.textContent = total.toLocaleString('vi-VN') + 'đ';
              selectedCount.textContent = items.length;
          }

          // Hàm kiểm tra tất cả checkbox con có được chọn hay không
          function checkAllSelected() {
              const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);
              mainCheckbox.checked = allChecked;
          }

          // Hàm cập nhật hàng trong bảng
          function updateRow(row) {
              const price = parseInt(row.querySelector('.service-check').getAttribute('data-price'));
              const quantity = parseInt(row.querySelector('.quantity-input').value);
              const totalCell = row.querySelector('.total-price');
              totalCell.textContent = (price * quantity).toLocaleString('vi-VN') + 'đ';
          }

          // Xử lý sự kiện checkbox con
          checkboxes.forEach(box => {
              box.addEventListener('change', () => {
                  const row = box.closest('tr');
                  const name = box.getAttribute('data-name');
                  const price = parseInt(box.getAttribute('data-price'));
                  const qtyInput = row.querySelector('.quantity-input');
                  const quantity = parseInt(qtyInput.value);

                  if (box.checked) {
                      const item = document.createElement('div');
                      item.className = 'invoice-line';
                      item.setAttribute('data-name', name);
                      item.setAttribute('data-price', price);
                      item.setAttribute('data-quantity', quantity);
                      item.innerHTML = `
              <span>${name}</span>
              <span class="invoice-qty">${quantity}</span>
              <span class="invoice-sum">${(price * quantity).toLocaleString('vi-VN')}đ</span>`;
                      invoiceItems.appendChild(item);
                  } else {
                      const existing = invoiceItems.querySelector(`.invoice-line[data-name='${name}']`);
                      if (existing) invoiceItems.removeChild(existing);
                  }

                  updateTotal();
                  checkAllSelected();
                  saveState();
              });
          });

          // Xử lý checkbox chính
          mainCheckbox.addEventListener('change', () => {
              const isChecked = mainCheckbox.checked;

              checkboxes.forEach(checkbox => {
                  checkbox.checked = isChecked;
                  const row = checkbox.closest('tr');
                  const name = checkbox.getAttribute('data-name');
                  const price = parseInt(checkbox.getAttribute('data-price'));
                  const qtyInput = row.querySelector('.quantity-input');
                  const quantity = parseInt(qtyInput.value);

                  if (isChecked) {
                      const item = document.createElement('div');
                      item.className = 'invoice-line';
                      item.setAttribute('data-name', name);
                      item.setAttribute('data-price', price);
                      item.setAttribute('data-quantity', quantity);
                      item.innerHTML = `
              <span>${name}</span>
              <span class="invoice-qty">${quantity}</span>
              <span class="invoice-sum">${(price * quantity).toLocaleString('vi-VN')}đ</span>`;
                      invoiceItems.appendChild(item);
                  } else {
                      const existing = invoiceItems.querySelector(`.invoice-line[data-name='${name}']`);
                      if (existing) invoiceItems.removeChild(existing);
                  }
              });

              updateTotal();
              saveState();
          });

          // Xử lý sự kiện thay đổi số lượng
          document.querySelectorAll('.quantity-group').forEach(group => {
              const minusBtn = group.querySelector('.btn-minus');
              const plusBtn = group.querySelector('.btn-plus');
              const input = group.querySelector('.quantity-input');

              function updateRowQuantity(row) {
                  updateRow(row);
                  const name = row.querySelector('.service-check').getAttribute('data-name');
                  const price = parseInt(row.querySelector('.service-check').getAttribute('data-price'));
                  const quantity = parseInt(input.value);
                  const invoiceLine = invoiceItems.querySelector(`.invoice-line[data-name='${name}']`);
                  if (invoiceLine) {
                      invoiceLine.setAttribute('data-quantity', quantity);
                      invoiceLine.querySelector('.invoice-qty').textContent = quantity;
                      invoiceLine.querySelector('.invoice-sum').textContent = (price * quantity).toLocaleString('vi-VN') + 'đ';
                  }
                  updateTotal();
                  saveState();
              }

              minusBtn.addEventListener('click', () => {
                  let val = parseInt(input.value);
                  if (val > 1) {
                      input.value = val - 1;
                      updateRowQuantity(group.closest('tr'));
                  }
              });

              plusBtn.addEventListener('click', () => {
                  let val = parseInt(input.value);
                  input.value = val + 1;
                  updateRowQuantity(group.closest('tr'));
              });
          });

          // Xử lý mã giảm giá
          applyCouponBtn.addEventListener('click', () => {
              const couponCode = couponInput.value.trim();
              if (couponCode === 'DISCOUNT10') {
                  discount = 10000;
              } else {
                  discount = 0;
              }
              couponDiscountElem.textContent = discount.toLocaleString('vi-VN') + 'đ';
              discountAmountElem.textContent = discount.toLocaleString('vi-VN') + 'đ';
              updateTotal();
              saveState();
          });

          // Xử lý nút Xác Nhận
          const btn = document.getElementById('btnXacNhan');
          if (btn) {
              btn.addEventListener('click', function() {
                  const items = invoiceItems.querySelectorAll('.invoice-line');
                  console.log('Số lượng dịch vụ đã chọn:', items.length); // Debug
                  if (items.length === 0) {
                      showToast('Vui lòng chọn ít nhất 1 dịch vụ', 'error');
                      return;
                  }

                  const orderData = {
                      services: [],
                      total: parseInt(totalPriceElem.textContent.replace(/[^\d]/g, '')),
                      discount: discount
                  };

                  items.forEach(item => {
                      const name = item.getAttribute('data-name');
                      const price = parseInt(item.getAttribute('data-price'));
                      const quantity = parseInt(item.getAttribute('data-quantity'));
                      orderData.services.push({
                          name,
                          price,
                          quantity
                      });
                  });

                  localStorage.setItem('orderData', JSON.stringify(orderData));
                  window.location.href = '<?= base_url('/cart/info') ?>';
              });
          }

          // Khôi phục trạng thái khi tải trang
          restoreState();

          // Test snackbar ngay khi tải trang (có thể bỏ comment để kiểm tra)
          // showToast('Test snackbar ngay khi tải trang', 'error');
      });
  </script>

  <script>
      (function() {
          function c() {
              var b = a.contentDocument || a.contentWindow.document;
              if (b) {
                  var d = b.createElement('script');
                  d.innerHTML = "window.__CF$cv$params={r:'93e24489b87cb001',t:'MTc0Njk3MjcwOS4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='/cdn-cgi/challenge-platform/scripts/jsd/main.js';document.getElementsByTagName('head')[0].appendChild(a);";
                  b.getElementsByTagName('head')[0].appendChild(d)
              }
          }
          if (document.body) {
              var a = document.createElement('iframe');
              a.height = 1;
              a.width = 1;
              a.style.position = 'absolute';
              a.style.top = 0;
              a.style.left = 0;
              a.style.border = 'none';
              a.style.visibility = 'hidden';
              document.body.appendChild(a);
              if ('loading' !== document.readyState) c();
              else if (window.addEventListener) document.addEventListener('DOMContentLoaded', c);
              else {
                  var e = document.onreadystatechange || function() {};
                  document.onreadystatechange = function(b) {
                      e(b);
                      'loading' !== document.readyState && (document.onreadystatechange = e, c())
                  }
              }
          }
      })();
  </script>
  <?php end_section(); ?>
  <!-- End: Script -->