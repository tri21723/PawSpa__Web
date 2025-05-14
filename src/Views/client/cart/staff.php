<?php start_section('links'); ?>

<link rel="stylesheet" href="<?= base_url('assets/css/cart.css') ?>">

<?php end_section(); ?>

  <!-- Start: Main -->
  <main class="flex-grow">
    <!-- Progress Steps và Back Button -->
    <div class="container-xl progress-container">
      <div class="back-button-container">
        <button onclick="goBackToPage2()" class="btn btn-outline-secondary btn-sm">
          <i class="fas fa-arrow-left"></i> Trở lại
        </button>
      </div>
      <ul class="d-flex justify-content-center gap-5 text-xs font-semibold text-[#2e0a5a] py-3">
        <li class="d-flex align-items-center gap-2 step active">
          <div class="step-circle">1</div>
          <span>Giỏ Hàng</span>
        </li>
        <li class="d-flex align-items-center gap-2 step active">
          <div class="step-circle">2</div>
          <span class="text-purple-700 fw-medium">Thông Tin</span>
        </li>
        <li class="d-flex align-items-center gap-2 step active">
          <div class="step-circle">3</div>
          <span class="text-purple-700 fw-medium">Nhân Viên</span>
        </li>
        <li class="d-flex align-items-center gap-2">
          <div class="step-circle inactive">4</div>
          <span class="text-[#d3d3d3]">Hoàn Tất</span>
        </li>
      </ul>
    </div>
    <!-- Cards Section -->
    <section class="max-w-7xl mx-auto px-6 pb-20">
      <div class="staff-grid" id="staff-list">
        <!-- Nhân viên sẽ được thêm động bằng JS -->
      </div>
    </section>
    <!-- Pagination -->
    <div class="pagination" id="pagination">
      <!-- Nút phân trang sẽ được thêm động bằng JS -->
    </div>
  </main>
  <!-- End: Main -->

<?php start_section('scripts'); ?>
<script>
    const staffData = [
      { name: "Bất Kì Nhân Viên", image: "https://storage.googleapis.com/a1aa/image/0c4cca89-b8c3-442e-7302-258ec924ef72.jpg", rating: "5.0" },
      { name: "Nhân Viên 1", image: "https://storage.googleapis.com/a1aa/image/ec408cff-28ae-4751-b3d7-33de936f03a2.jpg", rating: "5.0" },
      { name: "Nhân Viên 2", image: "https://placehold.co/160x160", rating: "4.8" },
      { name: "Nhân Viên 3", image: "https://placehold.co/160x160", rating: "4.9" },
      { name: "Nhân Viên 4", image: "https://placehold.co/160x160", rating: "5.0" },
      { name: "Nhân Viên 5", image: "https://placehold.co/160x160", rating: "4.7" },
      { name: "Nhân Viên 6", image: "https://placehold.co/160x160", rating: "4.9" },
      { name: "Nhân Viên 7", image: "https://placehold.co/160x160", rating: "5.0" },
      { name: "Nhân Viên 8", image: "https://placehold.co/160x160", rating: "4.8" }
    ];

    const itemsPerPage = 8;
    let currentPage = 1;

    function renderStaff(page) {
      const start = (page - 1) * itemsPerPage;
      const end = start + itemsPerPage;
      const staffList = document.getElementById('staff-list');
      staffList.innerHTML = '';

      const staffToShow = staffData.slice(start, end);
      staffToShow.forEach(staff => {
        const staffCard = `
          <article aria-label="Card for ${staff.name}" class="bg-[#f3f3f3] rounded-lg shadow-sm flex flex-col">
            <div class="bg-[#f3f3f3] rounded-t-lg p-6 flex justify-center">
              <img alt="Staff image" class="rounded-sm" height="160" src="${staff.image}" width="160"/>
            </div>
            <div class="bg-white rounded-b-lg p-4 flex flex-col flex-grow">
              <h3 class="font-extrabold text-xs mb-1 uppercase">${staff.name}</h3>
              <div class="flex items-center space-x-1 mb-3 text-xs text-gray-600">
                <i class="fas fa-star text-yellow-400 text-sm"></i>
                <span>(${staff.rating})</span>
              </div>
              <button onclick="redirectToOrderSuccess('${staff.name}')" class="bg-[#6a1b9a] text-white hover:bg-[#4a148c] text-[9px] font-semibold rounded-sm py-1 px-3 w-full">
                Xác Nhận
              </button>
            </div>
          </article>`;
        staffList.innerHTML += staffCard;
      });

      renderPagination();
    }

    function renderPagination() {
      const totalPages = Math.ceil(staffData.length / itemsPerPage);
      const pagination = document.getElementById('pagination');
      pagination.innerHTML = '';

      const prevButton = document.createElement('button');
      prevButton.innerHTML = '«';
      prevButton.disabled = currentPage === 1;
      prevButton.onclick = () => {
        if (currentPage > 1) {
          currentPage--;
          renderStaff(currentPage);
        }
      };
      pagination.appendChild(prevButton);

      for (let i = 1; i <= totalPages; i++) {
        const pageButton = document.createElement('button');
        pageButton.textContent = i;
        if (i === currentPage) {
          pageButton.classList.add('active');
        }
        pageButton.onclick = () => {
          currentPage = i;
          renderStaff(currentPage);
        };
        pagination.appendChild(pageButton);
      }

      const nextButton = document.createElement('button');
      nextButton.innerHTML = '»';
      nextButton.disabled = currentPage === totalPages;
      nextButton.onclick = () => {
        if (currentPage < totalPages) {
          currentPage++;
          renderStaff(currentPage);
        }
      };
      pagination.appendChild(nextButton);
    }

    function redirectToOrderSuccess(staff) {
      sessionStorage.setItem('selectedStaff', staff);
      window.location.href = `<?= base_url('/cart/finish') ?>`;
    }

    function goBackToPage2() {
      window.location.href = '<?= base_url('/cart/info') ?>';
    }

    document.addEventListener('DOMContentLoaded', () => {
      renderStaff(currentPage);

      const selectedStaff = sessionStorage.getItem('selectedStaff');
      if (selectedStaff) {
        const staffCards = document.querySelectorAll('article h3');
        staffCards.forEach(card => {
          if (card.textContent === selectedStaff.toUpperCase()) {
            card.closest('article').style.border = '2px solid #6a1b9a';
          }
        });
      }
    });
  </script>
<?php end_section(); ?>