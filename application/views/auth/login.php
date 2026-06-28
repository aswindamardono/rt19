<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <meta name="theme-color" content="#064e3b">
  <title>Login — RT-19 Orchid Regency</title>

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.8/dist/sweetalert2.min.css">
  <link rel="stylesheet" href="<?= base_url('assets/css/custom.css') ?>?v=<?= @filemtime(FCPATH.'assets/css/custom.css') ?: time() ?>">
</head>
<body>

<div class="rt-login-container">
  <div class="rt-login-card">

    <div class="rt-login-logo">
      <img src="<?= base_url('assets/img/logo.png') ?>" alt="RT-19" onerror="this.style.display='none';this.parentNode.innerHTML='<i class=\'fas fa-home fa-2x\' style=\'color:white\'></i>';">
    </div>

    <h1 class="rt-login-title">RT-19 Orchid Regency</h1>
    <p class="rt-login-subtitle">Sistem Informasi Manajemen RT</p>

    <form action="<?= base_url('auth') ?>" method="post" autocomplete="on">
      <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

      <input
        type="text"
        name="username"
        class="rt-login-input"
        placeholder="Username"
        required
        autocomplete="username"
        autofocus>

      <input
        type="password"
        name="password"
        class="rt-login-input"
        placeholder="Password"
        required
        autocomplete="current-password">

      <button type="submit" class="rt-login-btn">
        <i class="fas fa-sign-in-alt"></i> &nbsp; MASUK
      </button>
    </form>

    <p class="rt-login-foot">
      &copy; <?= date('Y') ?> RT-19 Orchid Regency Sidoarjo
    </p>
  </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.8/dist/sweetalert2.all.min.js"></script>
<script>
  $(function () {
    <?php if($this->session->flashdata('error')): ?>
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
