<!-- Ringkasan Keuangan Page -->
<div class="pub-page-header">
  <h1><i class="fas fa-chart-pie"></i> Ringkasan Keuangan</h1>
  <p>Periode pemasukan &amp; pengeluaran: <strong><?= htmlspecialchars($bulan_label, ENT_QUOTES) ?></strong></p>
</div>

<div class="pub-stat-grid" data-aos="fade-up" data-aos-delay="100">
  <div class="pub-stat">
    <div class="pub-stat-icon balance"><i class="fas fa-wallet"></i></div>
    <div class="pub-stat-label">Total Saldo Kas RT</div>
    <div class="pub-stat-value balance">
      Rp <?= number_format((float)$total_kas, 0, ',', '.') ?>
    </div>
    <div class="pub-stat-period">Akumulasi seluruh transaksi</div>
  </div>

  <div class="pub-stat">
    <div class="pub-stat-icon income"><i class="fas fa-arrow-down"></i></div>
    <div class="pub-stat-label">Pemasukan Bulan Ini</div>
    <div class="pub-stat-value income">
      Rp <?= number_format((float)$pemasukan_bln, 0, ',', '.') ?>
    </div>
    <div class="pub-stat-period"><?= htmlspecialchars($bulan_label, ENT_QUOTES) ?></div>
  </div>

  <div class="pub-stat">
    <div class="pub-stat-icon expense"><i class="fas fa-arrow-up"></i></div>
    <div class="pub-stat-label">Pengeluaran Bulan Ini</div>
    <div class="pub-stat-value expense">
      Rp <?= number_format((float)$pengeluaran_bln, 0, ',', '.') ?>
    </div>
    <div class="pub-stat-period"><?= htmlspecialchars($bulan_label, ENT_QUOTES) ?></div>
  </div>
</div>

<!-- CTA -->
<div class="pub-cta" data-aos="zoom-in" data-aos-delay="200">
  <h3>Pengurus RT-19?</h3>
  <p>Masuk untuk mengelola data warga, kas, iuran, dan surat menyurat.</p>
  <a href="<?= base_url('auth') ?>" class="pub-cta-btn">
    <i class="fas fa-sign-in-alt"></i> Login Sekarang
  </a>
</div>
