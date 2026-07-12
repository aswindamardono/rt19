<?php
$role_id = $this->session->userdata('role_id');
$seg1 = $this->uri->segment(1);

$is_active = function ($s) use ($seg1) {
  return $seg1 === $s ? 'active' : ''; };
?>
</div><!-- /aos-wrapper -->

<footer class="rt-footer">
  &copy; <?= date('Y') ?> RT-19 Orchid Regency Sidoarjo &middot; v1.0.0
</footer>
</main><!-- /.rt-main -->

<!-- ============================================================
     BOTTOM NAV (Mobile)
     ============================================================ -->
<?php
// Build mobile menu items based on role
$mobile_menus = [];

// Dashboard always first
$mobile_menus[] = ['url' => 'dashboard', 'icon' => 'fa-th-large', 'label' => 'Home', 'seg' => 'dashboard'];

if ($role_id == 3) {
  // KHUSUS BENDAHARA
  // Urutan 1 & 2 akan di kiri: Home, Pemasukan
  $mobile_menus[] = ['url' => 'keuangan/pemasukan', 'icon' => 'fa-arrow-down', 'label' => 'Pemasukan', 'seg' => 'keuangan'];
  
  // Tengah (Popup)
  $mobile_menus[] = ['url' => 'surat', 'icon' => 'fa-envelope', 'label' => 'Surat', 'seg' => 'surat'];
  $mobile_menus[] = ['url' => 'pengumuman', 'icon' => 'fa-bullhorn', 'label' => 'Pengumuman', 'seg' => 'pengumuman'];
  $mobile_menus[] = ['url' => 'iuran', 'icon' => 'fa-hand-holding-usd', 'label' => 'Iuran', 'seg' => 'iuran'];
  
  // Urutan terakhir akan di kanan: Pengeluaran, Laporan
  $mobile_menus[] = ['url' => 'keuangan/pengeluaran', 'icon' => 'fa-arrow-up', 'label' => 'Pengeluaran', 'seg' => 'keuangan'];
  $mobile_menus[] = ['url' => 'keuangan/laporan', 'icon' => 'fa-file-invoice-dollar', 'label' => 'Laporan', 'seg' => 'keuangan'];
} else {
  // UNTUK ROLE LAINNYO
  if (in_array($role_id, [1, 4, 6])) {
    $mobile_menus[] = ['url' => 'warga', 'icon' => 'fa-users', 'label' => 'Warga', 'seg' => 'warga'];
    $mobile_menus[] = ['url' => 'inventaris', 'icon' => 'fa-boxes', 'label' => 'Inventaris', 'seg' => 'inventaris'];
  }

  if (in_array($role_id, [1, 6])) {
    $mobile_menus[] = ['url' => 'keuangan/pemasukan', 'icon' => 'fa-arrow-down', 'label' => 'Pemasukan', 'seg' => 'keuangan'];
    $mobile_menus[] = ['url' => 'keuangan/pengeluaran', 'icon' => 'fa-arrow-up', 'label' => 'Pengeluaran', 'seg' => 'keuangan'];
    $mobile_menus[] = ['url' => 'keuangan/laporan', 'icon' => 'fa-file-invoice-dollar', 'label' => 'Laporan', 'seg' => 'keuangan'];
    $mobile_menus[] = ['url' => 'iuran', 'icon' => 'fa-hand-holding-usd', 'label' => 'Iuran', 'seg' => 'iuran'];
  }

  $mobile_menus[] = ['url' => 'surat', 'icon' => 'fa-envelope', 'label' => 'Surat', 'seg' => 'surat'];
  $mobile_menus[] = ['url' => 'pengumuman', 'icon' => 'fa-bullhorn', 'label' => 'Pengumuman', 'seg' => 'pengumuman'];

  if (in_array($role_id, [1, 4, 6])) {
    $mobile_menus[] = ['url' => 'struktur', 'icon' => 'fa-sitemap', 'label' => 'Struktur', 'seg' => 'struktur'];
  }

  if (in_array($role_id, [1])) {
    $mobile_menus[] = ['url' => 'users', 'icon' => 'fa-users-cog', 'label' => 'User', 'seg' => 'users'];
    $mobile_menus[] = ['url' => 'pengaturan', 'icon' => 'fa-cogs', 'label' => 'Pengaturan', 'seg' => 'pengaturan'];
  }
}

// Bottom bar: show first 2 on left, last 2 on right, rest in FAB popup
$bar_left = array_slice($mobile_menus, 0, 2);
$bar_right_start = max(2, count($mobile_menus) - 2);
$bar_right = array_slice($mobile_menus, $bar_right_start, 2);
$popup_menus = array_slice($mobile_menus, 2, $bar_right_start - 2);
// Add logout to popup
$popup_menus[] = ['url' => 'auth/logout', 'icon' => 'fa-sign-out-alt', 'label' => 'Keluar', 'seg' => 'logout', 'logout' => true];
?>

<!-- Bottom Nav (Mobile) -->
<nav class="rt-bottom-nav">
  <?php foreach ($bar_left as $m): ?>
    <a href="<?= base_url($m['url']) ?>" class="rt-bnav-item <?= $seg1 === $m['seg'] ? 'active' : '' ?>">
      <i class="fas <?= $m['icon'] ?>"></i><span><?= $m['label'] ?></span>
    </a>
  <?php endforeach; ?>

  <!-- Center FAB -->
  <div class="rt-bnav-fab-wrap">
    <button type="button" class="rt-bnav-fab" id="bnav-fab-btn" aria-label="Menu">
      <i class="fas fa-plus"></i>
    </button>
  </div>

  <?php foreach ($bar_right as $m): ?>
    <a href="<?= base_url($m['url']) ?>" class="rt-bnav-item <?= $seg1 === $m['seg'] ? 'active' : '' ?>">
      <i class="fas <?= $m['icon'] ?>"></i><span><?= $m['label'] ?></span>
    </a>
  <?php endforeach; ?>
</nav>

<!-- FAB Popup Overlay -->
<div class="rt-fab-overlay" id="fab-overlay"></div>

<!-- FAB Popup Menu -->
<div class="rt-fab-popup" id="fab-popup">
  <div class="rt-fab-popup-inner">
    <?php foreach ($popup_menus as $m): ?>
      <a href="<?= base_url($m['url']) ?>" class="rt-fab-menu-item <?= $seg1 === ($m['seg'] ?? '') ? 'active' : '' ?>"
        <?= !empty($m['logout']) ? 'onclick="return confirm(\'Yakin ingin keluar?\');"' : '' ?>>
        <div class="rt-fab-menu-icon <?= !empty($m['logout']) ? 'logout' : '' ?>">
          <i class="fas <?= $m['icon'] ?>"></i>
        </div>
        <span><?= $m['label'] ?></span>
      </a>
    <?php endforeach; ?>
  </div>
</div>

<script>
  (function () {
    var fab = document.getElementById('bnav-fab-btn');
    var popup = document.getElementById('fab-popup');
    var overlay = document.getElementById('fab-overlay');
    var isOpen = false;

    function toggleFab() {
      isOpen = !isOpen;
      fab.classList.toggle('is-open', isOpen);
      popup.classList.toggle('is-open', isOpen);
      overlay.classList.toggle('is-open', isOpen);
      document.body.style.overflow = isOpen ? 'hidden' : '';
    }

    fab.addEventListener('click', function (e) {
      e.stopPropagation();
      toggleFab();
    });

    overlay.addEventListener('click', function () {
      if (isOpen) toggleFab();
    });

    // Add ripple effect on nav items
    document.querySelectorAll('.rt-bnav-item, .rt-fab-menu-item').forEach(function (el) {
      el.addEventListener('click', function (e) {
        var ripple = document.createElement('span');
        ripple.className = 'rt-ripple';
        var rect = el.getBoundingClientRect();
        ripple.style.left = (e.clientX - rect.left) + 'px';
        ripple.style.top = (e.clientY - rect.top) + 'px';
        el.appendChild(ripple);
        setTimeout(function () { ripple.remove(); }, 600);
      });
    });
  })();
</script>

<!-- ============================================================
     SCRIPTS
     ============================================================ -->
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App (untuk komponen seperti products-list & utility) -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<!-- DataTables & Plugins -->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>

<!-- ChartJS -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.7.1/dist/chart.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.8/dist/sweetalert2.all.min.js"></script>

<!-- AOS Animation -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
  AOS.init({ duration: 700, easing: 'ease-out-cubic', once: true, mirror: false });
</script>

<!-- Flash messages -->
<script>
  $(function () {
    <?php if ($this->session->flashdata('success')): ?>
      Swal.fire({
        icon: 'success',
        title: 'Berhasil!',
        text: <?= json_encode($this->session->flashdata('success')) ?>,
        timer: 2800,
        showConfirmButton: false,
        toast: true,
        position: 'top-end'
      });
    <?php endif; ?>

    <?php if ($this->session->flashdata('error')): ?>
      Swal.fire({
        icon: 'error',
        title: 'Gagal!',
        text: <?= json_encode($this->session->flashdata('error')) ?>,
        showConfirmButton: true
      });
    <?php endif; ?>
    
    // Image Preview with SweetAlert2
    $(document).on('click', '.img-preview', function() {
      var src = $(this).attr('src');
      var alt = $(this).attr('alt') || 'Preview Gambar';
      Swal.fire({
        title: alt,
        imageUrl: src,
        imageAlt: alt,
        showConfirmButton: false,
        showCloseButton: true,
        width: 'auto',
        padding: '1em',
        customClass: {
          image: 'img-fluid rounded'
        }
      });
    });
  });
</script>
<style>
  .img-preview {
    cursor: pointer;
    transition: transform 0.2s;
  }
  .img-preview:hover {
    transform: scale(1.05);
  }
</style>

<?php if (isset($custom_js) && $custom_js): ?>
  <?= $custom_js ?>
<?php endif; ?>

</body>

</html>