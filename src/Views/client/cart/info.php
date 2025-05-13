<?php
start_section('links');
?>
<link rel="stylesheet" href="<?= base_url('assets/css/cart.css') ?>">
<?php end_section();
?>

<!-- Start: Main -->
<main class="container mt-4">
    <!-- Progress Steps -->
    <div class="container-xl">
        <ul class="d-flex justify-content-center gap-5 text-xs font-semibold text-[#2e0a5a] py-3">
            <li class="d-flex align-items-center gap-2 step active">
                <div class="step-circle">1</div>
                <span>Chi Tiết Dịch Vụ</span>
            </li>
            <li class="d-flex align-items-center gap-2 step active">
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

    <div class="bg-body step-2-content active">
        <div class="form-container">
            <h5 class="text-purple text-font">Thông Tin</h5>
            <form id="stepForm">
                <!-- Phần Nhập Thông Tin -->
                <div class="form-section">
                    <h6>Nhập Thông Tin</h6>
                    <div class="mb-3">
                        <label class="form-label">Họ và tên</label>
                        <input type="text" class="form-control" id="name" placeholder="Nguyễn Văn A">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ID chó/mèo</label>
                        <div class="pet-id-container" id="petIdContainer">
                            <div class="mb-3">
                                <input type="text" class="form-control pet-id-input" id="petId" placeholder="ID chó/mèo">
                            </div>
                        </div>
                        <div class="quantity-input">
                            <button type="button" onclick="changePetIdCount(-1)">-</button>
                            <span id="petIdCount">1</span>
                            <button type="button" onclick="changePetIdCount(1)">+</button>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Số điện thoại</label>
                        <input type="text" class="form-control" id="phone" placeholder="090xxxxx">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Địa chỉ</label>
                        <input type="text" class="form-control" id="address" placeholder="4517 Washington Ave. Manchester">
                    </div>
                </div>

                <!-- Phần Hình Thức Thanh Toán -->
                <div class="form-section">
                    <h6>Hình Thức Thanh Toán</h6>
                    <div class="payment-method">
                        <label>
                            <input type="radio" name="paymentMethod" value="card" checked onclick="showPaymentDetails('card')">
                            <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg" alt="Visa">
                            Card
                        </label>
                        <label>
                            <input type="radio" name="paymentMethod" value="momo" onclick="showPaymentDetails('momo')">
                            <img src="https://upload.wikimedia.org/wikipedia/vi/f/fe/MoMo_Logo.png" alt="Momo">
                            Momo
                        </label>
                        <label>
                            <input type="radio" name="paymentMethod" value="cash" onclick="showPaymentDetails('cash')">
                            <i class="fas fa-money-bill-wave"></i>
                            Tiền mặt
                        </label>
                    </div>

                    <!-- Chi tiết thanh toán -->
                    <div id="cardDetails" class="payment-details active">
                        <div class="mb-3">
                            <label class="form-label">Card Number</label>
                            <div class="d-flex align-items-center gap-2">
                                <input type="text" class="form-control" id="cardNumber" placeholder="1234-4231-3214-3123">
                                <img src="https://upload.wikimedia.org/wikipedia/commons/0/04/Visa.svg" alt="Visa" width="40">
                            </div>
                        </div>
                    </div>
                    <div id="momoDetails" class="payment-details">
                        <div class="mb-3">
                            <label class="form-label">Số điện thoại Momo</label>
                            <input type="text" class="form-control" id="momoPhone" placeholder="090xxxxx">
                        </div>
                    </div>
                    <div id="cashDetails" class="payment-details">
                        <p>Thanh toán bằng tiền mặt tại quầy khi nhận dịch vụ.</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Thời gian đặt lịch</label>
                        <div class="date-time-inputs">
                            <div class="input-group">
                                <i class="fas fa-calendar-alt input-icon"></i>
                                <input type="date" class="form-control" id="date" value="2025-04-25" aria-label="Ngày đặt lịch">
                            </div>
                            <div class="time-inputs date-time-inputs">
                                <div class="input-group">
                                    <i class="fas fa-clock input-icon"></i>
                                    <select class="form-select" id="hourSelect" aria-label="Giờ">
                                        <option value="" disabled selected>Giờ</option>
                                        <script>
                                            for (let i = 0; i <= 23; i++) {
                                                document.write(`<option value="${i}">${i.toString().padStart(2, '0')}</option>`);
                                            }
                                        </script>
                                    </select>
                                </div>
                                <div class="input-group">
                                    <i class="fas fa-clock input-icon"></i>
                                    <select class="form-select" id="minuteSelect" aria-label="Phút">
                                        <option value="" disabled selected>Phút</option>
                                        <script>
                                            for (let i = 0; i <= 59; i++) {
                                                document.write(`<option value="${i}">${i.toString().padStart(2, '0')}</option>`);
                                            }
                                        </script>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nút Trở Về và Tiếp Theo -->
                <div class="button-group">
                    <button type="button" class="btn btn-outline-secondary btn-sm" onclick="goBack()">
                        <i class="fas fa-arrow-left"></i> Trở lại
                    </button>
                    <button type="button" class="btn btn-purple" onclick="goToStep(3)">Tiếp Theo</button>
                </div>
            </form>
        </div>
    </div>
</main>
<!-- End: Main -->

<?php start_section('scripts'); ?>
<script>
    // Xử lý thêm/xóa ô ID chó/mèo
    function changePetIdCount(delta) {
        const container = document.getElementById('petIdContainer');
        let inputs = container.getElementsByClassName('pet-id-input');
        let currentCount = inputs.length;

        if (delta === 1) {
            const newInputDiv = document.createElement('div');
            newInputDiv.className = 'mb-3';
            newInputDiv.innerHTML = `<input type="text" class="form-control pet-id-input" placeholder="ID chó/mèo">`;
            container.appendChild(newInputDiv);
        } else if (delta === -1 && currentCount > 1) {
            container.removeChild(inputs[currentCount - 1].parentElement);
        }

        inputs = container.getElementsByClassName('pet-id-input');
        document.getElementById('petIdCount').textContent = inputs.length;
        saveFormData();
    }

    // Xử lý hiển thị chi tiết thanh toán
    function showPaymentDetails(method) {
        document.querySelectorAll('.payment-details').forEach(detail => {
            detail.classList.remove('active');
        });
        document.getElementById(`${method}Details`).classList.add('active');
        saveFormData();
    }

    // Lưu dữ liệu form vào localStorage
    function saveFormData() {
        const petIds = Array.from(document.getElementsByClassName('pet-id-input')).map(input => input.value);
        const formData = {
            name: document.getElementById('name').value,
            petIds: petIds,
            phone: document.getElementById('phone').value,
            address: document.getElementById('address').value,
            paymentMethod: document.querySelector('input[name="paymentMethod"]:checked')?.value,
            cardNumber: document.getElementById('cardNumber').value,
            momoPhone: document.getElementById('momoPhone').value,
            date: document.getElementById('date').value,
            time: `${document.getElementById('hourSelect').value}:${document.getElementById('minuteSelect').value}`
        };
        localStorage.setItem('formData', JSON.stringify(formData));
    }

    // Khôi phục dữ liệu form từ localStorage
    function restoreFormData() {
        const formData = JSON.parse(localStorage.getItem('formData'));
        if (formData) {
            document.getElementById('name').value = formData.name || '';
            document.getElementById('phone').value = formData.phone || '';
            document.getElementById('address').value = formData.address || '';
            document.getElementById('date').value = formData.date || '2025-04-25';
            if (formData.petIds) {
                const container = document.getElementById('petIdContainer');
                container.innerHTML = '';
                formData.petIds.forEach((petId, index) => {
                    const newInputDiv = document.createElement('div');
                    newInputDiv.className = 'mb-3';
                    newInputDiv.innerHTML = `<input type="text" class="form-control pet-id-input" placeholder="ID chó/mèo" value="${petId}">`;
                    container.appendChild(newInputDiv);
                });
                document.getElementById('petIdCount').textContent = formData.petIds.length;
            }
            if (formData.paymentMethod) {
                document.querySelector(`input[name="paymentMethod"][value="${formData.paymentMethod}"]`).checked = true;
                showPaymentDetails(formData.paymentMethod);
            }
            document.getElementById('cardNumber').value = formData.cardNumber || '';
            document.getElementById('momoPhone').value = formData.momoPhone || '';
            if (formData.time) {
                const [hour, minute] = formData.time.split(':');
                document.getElementById('hourSelect').value = hour || '';
                document.getElementById('minuteSelect').value = minute || '';
            }
        }
    }

    // Xử lý chuyển bước
    function goBack() {
        saveFormData();
        window.location.href = "<?= base_url('/cart') ?>";
    }

    function goToStep(step) {
        const hourSelect = document.getElementById('hourSelect').value;
        const minuteSelect = document.getElementById('minuteSelect').value;
        const name = document.getElementById('name').value;
        const petIds = Array.from(document.getElementsByClassName('pet-id-input')).map(input => input.value);
        const phone = document.getElementById('phone').value;
        const address = document.getElementById('address').value;
        const paymentMethod = document.querySelector('input[name="paymentMethod"]:checked')?.value;
        const cardNumber = document.getElementById('cardNumber').value;
        const momoPhone = document.getElementById('momoPhone').value;

        if (!hourSelect || !minuteSelect) {
            alert("Vui lòng chọn giờ và phút!");
            return;
        }
        if (!name || !petIds[0] || !phone || !address || !paymentMethod) {
            alert("Vui lòng điền đầy đủ thông tin!");
            return;
        }
        if (paymentMethod === 'card' && !cardNumber) {
            alert("Vui lòng nhập số thẻ!");
            return;
        }
        if (paymentMethod === 'momo' && !momoPhone) {
            alert("Vui lòng nhập số điện thoại Momo!");
            return;
        }

        saveFormData();
        window.location.href = '<?= base_url('/cart/staff') ?>';
    }

    // Gắn sự kiện input để lưu dữ liệu
    document.querySelectorAll('input, select').forEach(element => {
        element.addEventListener('input', saveFormData);
        element.addEventListener('change', saveFormData);
    });

    // Khôi phục dữ liệu khi tải trang
    document.addEventListener('DOMContentLoaded', restoreFormData);
</script>
<?php end_section(); ?>