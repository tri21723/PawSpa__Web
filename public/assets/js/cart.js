document.addEventListener('DOMContentLoaded', function () {
    const checkboxes = document.querySelectorAll('.service-check');
    const mainCheckbox = document.querySelector('#mainCheckbox');
    const invoiceItems = document.getElementById('invoice-items');
    const totalPriceElem = document.getElementById('total-price');
    const selectedCount = document.getElementById('selected-count');
    const couponInput = document.getElementById('coupon');
    const applyCouponBtn = document.getElementById('apply-coupon');
    const couponDiscountElem = document.getElementById('coupon-discount');
    const discountAmountElem = document.getElementById('discount-amount');
    let discount = 0;

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
        // Giả lập kiểm tra mã giảm giá (có thể thay bằng API thực tế)
        if (couponCode === 'DISCOUNT10') {
            discount = 10000; // Ví dụ: giảm 10.000đ
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
        btn.addEventListener('click', function () {
            const items = invoiceItems.querySelectorAll('.invoice-line');
            const orderData = {
                services: [],
                total: parseInt(totalPriceElem.textContent.replace(/[^\d]/g, '')),
                discount: discount
            };

            items.forEach(item => {
                const name = item.getAttribute('data-name');
                const price = parseInt(item.getAttribute('data-price'));
                const quantity = parseInt(item.getAttribute('data-quantity'));
                orderData.services.push({ name, price, quantity });
            });

            localStorage.setItem('orderData', JSON.stringify(orderData));
            window.location.href = '/cart/info';
        });
    }

    // Khôi phục trạng thái khi tải trang
    restoreState();
});