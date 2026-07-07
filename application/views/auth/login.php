<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="theme-color" content="#064e3b">
  <title>Login — RT-19 Orchid Regency</title>
  <link rel="icon" type="image/png" href="<?= base_url('assets/img/favicon.png') ?>">
  <link rel="apple-touch-icon" href="<?= base_url('assets/img/favicon.png') ?>">

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.8/dist/sweetalert2.min.css">
  <link rel="stylesheet"
    href="<?= base_url('assets/css/custom.css') ?>?v=<?= @filemtime(FCPATH . 'assets/css/custom.css') ?: time() ?>">
  <style>
    @keyframes fadeIn {
      0% {
        opacity: 0;
        transform: translateY(20px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .rt-login-card {
      animation: fadeIn 0.8s ease-out forwards;
    }

    .rt-login-btn-outline {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
      margin-top: 12px;
      padding: 0.75rem 1rem;
      border-radius: 12px;
      border: 1px solid rgba(255, 255, 255, 0.3);
      background: rgba(255, 255, 255, 0.05);
      color: rgba(255, 255, 255, 0.9);
      font-size: 0.9rem;
      font-weight: 600;
      font-family: 'Plus Jakarta Sans', 'Inter', sans-serif;
      letter-spacing: 0.05em;
      text-decoration: none;
      transition: all 0.3s ease;
    }

    .rt-login-btn-outline:hover {
      background: rgba(255, 255, 255, 0.2);
      color: white;
      text-decoration: none;
      border-color: rgba(255, 255, 255, 0.6);
      transform: translateY(-2px);
    }
  </style>
</head>

<body>

  <div class="rt-login-container">
    <div class="rt-login-card">

      <div class="rt-login-logo">
        <img src="<?= base_url('assets/img/logo.png') ?>" alt="RT-19"
          onerror="this.style.display='none';this.parentNode.innerHTML='<i class=\'fas fa-home fa-2x\' style=\'color:white\'></i>';">
      </div>

      <h1 class="rt-login-title">RT-19 Orchid Regency</h1>
      <p class="rt-login-subtitle">Sistem Informasi Manajemen RT</p>

      <form action="<?= base_url('auth') ?>" method="post" autocomplete="on">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>"
          value="<?= $this->security->get_csrf_hash(); ?>">

        <input type="text" name="username" class="rt-login-input" placeholder="Username" required
          autocomplete="username" autofocus>

        <input type="password" name="password" class="rt-login-input" placeholder="Password" required
          autocomplete="current-password">

        <button type="submit" class="rt-login-btn">
          <i class="fas fa-sign-in-alt"></i> &nbsp; MASUK
        </button>
        <a href="<?= base_url() ?>" class="rt-login-btn-outline">
          <i class="fas fa-arrow-left"></i> &nbsp; KEMBALI
        </a>
      </form>

      <p class="rt-login-foot">
        &copy; <?= date('Y') ?> By ArasITC
      </p>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.8/dist/sweetalert2.all.min.js"></script>
  <script>
    $(function () {
      <?php if ($this->session->flashdata('error')): ?>
        Swal.fire({
          icon: 'error',
          title: 'Login Gagal',
          text: <?= json_encode($this->session->flashdata('error')) ?>,
          confirmButtonColor: '#059669'
        });
      <?php endif; ?>
    });
  </script>
</body>

</html>