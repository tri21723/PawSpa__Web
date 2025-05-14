<?php start_section('links'); ?>

<link rel="stylesheet" href="<?= base_url('assets/css/cart.css') ?>">

<?php end_section(); ?>

<!-- Start: Main -->
<main class="flex-grow-1">
    <!-- Progress Steps -->
    <section class="container my-5">
        <div class="d-flex justify-content-center gap-5 text-xs text-[#3f0a75] mb-4">
            <div class="d-flex align-items-center gap-2 step active">
                <div class="step-circle">1</div>
                <span> Giỏ Hàng</span>
            </div>
            <div class="d-flex align-items-center gap-2 step active">
                <div class="step-circle">2</div>
                <span>Thông Tin</span>
            </div>
            <div class="d-flex align-items-center gap-2 step active">
                <div class="step-circle">3</div>
                <span>Nhân Viên</span>
            </div>
            <div class="d-flex align-items-center gap-2 step active">
                <div class="step-circle">4</div>
                <span>Hoàn Tất</span>
            </div>
        </div>

        <!-- Success Icon -->
        <div class="d-flex justify-content-center my-4">
            <div class="success-icon">
                <i class="fas fa-check text-white text-3xl"></i>
            </div>
        </div>

        <!-- Success Text -->
        <h2 class="text-center text-[#1a1a1a] fw-bold fs-4 mb-3">THÀNH CÔNG</h2>
        <p class="text-center text-[#6b6b6b] text-sm mx-auto" style="max-width: 750px;">
            Thanh toán của bạn đã thành công! Cám ơn bạn đã mua hàng. Một email xác nhận đã được gửi và đơn hàng của bạn hiện đang được xử lý. Chúng tôi đánh giá cao sự tin tưởng của bạn và mong muốn được phục vụ bạn một lần nữa!
        </p>

        <!-- Info Box -->
        <div class="info-box p-4 mx-auto my-4" style="max-width: 750px;">
            <h3 class="fw-bold text-[#3f0a75] mb-3">Thông Tin</h3>
            <p class="d-flex align-items-center gap-2 mb-2">
                <i class="far fa-user text-[#3a3a3a]"></i>
                <span id="info-name">Dane Nguyen</span>
            </p>
            <p class="d-flex align-items-center gap-2 mb-2">
                <i class="fas fa-paw text-[#3a3a3a]"></i>
                <span id="info-pet-ids">Không xác định</span>
            </p>
            <p class="d-flex align-items-center gap-2 mb-2">
                <i class="fas fa-phone-alt text-[#3a3a3a]"></i>
                <span id="info-phone">(093) 8772 - 416</span>
            </p>
            <p class="d-flex align-items-center gap-2 mb-2">
                <i class="fas fa-map-marker-alt text-[#3a3a3a]"></i>
                <span id="info-address">4517 Washington Ave. Manchester, Kentucky 39495</span>
            </p>
            <p class="d-flex align-items-center gap-2 mb-2">
                <i class="fas fa-clock text-[#3a3a3a]"></i>
                <span id="info-time">Không xác định</span>
            </p>
            <p class="d-flex align-items-center gap-2 mb-2">
                <i class="fas fa-credit-card text-[#3a3a3a]"></i>
                <span id="info-payment">Không xác định</span>
            </p>
        </div>

        <!-- Order Code Box -->
        <div class="order-box p-4 mx-auto my-4" style="max-width: 750px;">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <p class="fw-bold text-[#3f0a75] mb-0">
                    Mã hóa <span class="fw-normal">đơn</span>: <span class="text-[#3f0a75]">#BS3214421312342</span>
                </p>
                <a href="#" class="btn btn-purple btn-sm d-flex align-items-center gap-1 text-decoration-none">
                    <i class="far fa-copy"></i>
                    <span>Copy Code</span>
                </a>
            </div>
            <p class="d-flex align-items-center gap-2 text-[#9e9e9e] mb-3">
                <i class="fas fa-award"></i>
                <span>+1000 Point</span>
            </p>
            <!-- Staff Confirmation -->
            <div class="text-sm mb-2">
                <span>Nhân viên được chọn: </span>
                <span id="staff-selected" class="fw-bold text-[#3f0a75]">Không xác định</span>
            </div>
            <!-- Invoice Lines -->
            <div id="invoice-lines" class="text-sm mb-2">
                <!-- Dịch vụ sẽ được thêm động từ JS -->
            </div>
            <div class="d-flex justify-content-between mb-2">
                <span>Giảm giá</span>
                <span id="discount-amount">0đ</span>
            </div>
            <div class="d-flex justify-content-between fw-bold">
                <span>Tổng Cộng</span>
                <span id="total-price" class="text-[#3f0a75]">0đ</span>
            </div>
            <!-- Back Button -->
        </div>
    </section>
</main>
<!-- End: Main -->

<?php start_section('scripts'); ?>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

<!-- JavaScript to display data -->
<script>
    function getQueryParam(param) {
        const urlParams = new URLSearchParams(window.location.search);
        return urlParams.get(param);
    }

    document.addEventListener('DOMContentLoaded', () => {
        // Hiển thị nhân viên
        const staff = getQueryParam('staff');
        const staffSelectedElement = document.querySelector('#staff-selected');
        if (staff) {
            staffSelectedElement.textContent = decodeURIComponent(staff);
            sessionStorage.setItem('selectedStaff', staff);
        } else {
            staffSelectedElement.textContent = 'Không xác định';
        }

        // Hiển thị thông tin khách hàng
        const formData = JSON.parse(localStorage.getItem('formData'));
        if (formData) {
            document.getElementById('info-name').textContent = formData.name || 'Không xác định';
            document.getElementById('info-pet-ids').textContent = formData.petIds?.join(', ') || 'Không xác định';
            document.getElementById('info-phone').textContent = formData.phone || 'Không xác định';
            document.getElementById('info-address').textContent = formData.address || 'Không xác định';
            document.getElementById('info-time').textContent = formData.time ? `${formData.date} ${formData.time}` : 'Không xác định';
            document.getElementById('info-payment').textContent = formData.paymentMethod === 'card' ? `Card (${formData.cardNumber})` : formData.paymentMethod === 'momo' ? `Momo (${formData.momoPhone})` : 'Tiền mặt';
        }

        // Hiển thị dịch vụ và tổng tiền
        const orderData = JSON.parse(localStorage.getItem('orderData'));
        const invoiceLines = document.getElementById('invoice-lines');
        const totalPrice = document.getElementById('total-price');
        const discountAmount = document.getElementById('discount-amount');
        if (orderData && orderData.services) {
            orderData.services.forEach(service => {
                const item = document.createElement('div');
                item.className = 'invoice-line';
                item.innerHTML = `
            <span>${service.name}</span>
            <span class="text-center">${service.quantity}</span>
            <span class="price">${(service.price * service.quantity).toLocaleString('vi-VN')}₫</span>`;
                invoiceLines.appendChild(item);
            });
            totalPrice.textContent = orderData.total.toLocaleString('vi-VN') + '₫';
            discountAmount.textContent = orderData.discount.toLocaleString('vi-VN') + '₫';
        }
    });

    function goBackToPage3() {
        window.location.href = '<?= base_url('/cart/staff') ?>';
    }
</script>
<?php end_section(); ?>