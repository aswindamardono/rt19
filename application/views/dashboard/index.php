<!-- ============================================================
     STAT CARDS
     ============================================================ -->
<div class="row">
  <div class="col-lg-3 col-md-6 col-6 mb-3" data-aos="fade-up" data-aos-delay="100">
    <div class="small-box bg-info">
      <div class="inner">
        <h3><?= number_format($total_warga) ?></h3>
        <p>Total Warga</p>
      </div>
      <div class="icon"><i class="fas fa-users"></i></div>
      <a href="<?= base_url('warga') ?>" class="small-box-footer">
        Lebih Lanjut <i class="fas fa-arrow-circle-right ml-1"></i>
      </a>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-6 mb-3" data-aos="fade-up" data-aos-delay="200">
    <div class="small-box bg-success">
      <div class="inner">
        <h3><?= number_format($total_kk) ?></h3>
        <p>Kepala Keluarga</p>
      </div>
      <div class="icon"><i class="fas fa-home"></i></div>
      <a href="<?= base_url('warga') ?>" class="small-box-footer">
        Lebih Lanjut <i class="fas fa-arrow-circle-right ml-1"></i>
      </a>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-6 mb-3" data-aos="fade-up" data-aos-delay="300">
    <div class="small-box bg-warning">
      <div class="inner">
        <h3 style="font-size:1.4rem;">Rp <?= number_format($total_kas, 0, ',', '.') ?></h3>
        <p>Saldo Kas RT</p>
      </div>
      <div class="icon"><i class="fas fa-wallet"></i></div>
      <a href="<?= base_url('keuangan/laporan') ?>" class="small-box-footer">
        Lebih Lanjut <i class="fas fa-arrow-circle-right ml-1"></i>
      </a>
    </div>
  </div>

  <div class="col-lg-3 col-md-6 col-6 mb-3" data-aos="fade-up" data-aos-delay="400">
    <div class="small-box bg-danger">
      <div class="inner">
        <h3 style="font-size:1.4rem;">Rp <?= number_format($total_tunggakan, 0, ',', '.') ?></h3>
        <p>Total Tunggakan</p>
      </div>
      <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
      <a href="<?= base_url('iuran/tunggakan') ?>" class="small-box-footer">
        Lebih Lanjut <i class="fas fa-arrow-circle-right ml-1"></i>
      </a>
    </div>
  </div>
</div>

<!-- ============================================================
     CHART + TUNGGAKAN LIST
     ============================================================ -->
<div class="row">
  <div class="col-lg-8 mb-3" data-aos="fade-right" data-aos-delay="500">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-chart-bar mr-2 text-success"></i>Grafik Keuangan (6 Bulan Terakhir)</h3>
      </div>
      <div class="card-body">
        <canvas id="keuanganChart" height="110"></canvas>
      </div>
    </div>
  </div>

  <div class="col-lg-4 mb-3" data-aos="fade-left" data-aos-delay="600">
    <div class="card card-danger">
      <div class="card-header">
        <h3 class="card-title"><i class="fas fa-exclamation-circle mr-2"></i>Warga Menunggak</h3>
      </div>
      <div class="card-body p-0">
        <ul class="list-unstyled m-0" style="max-height: 360px; overflow-y: auto;">
          <?php if(!empty($warga_menunggak)): ?>
            <?php foreach(array_slice($warga_menunggak, 0, 5) as $w): ?>
              <li style="padding: 0.85rem 1.1rem; border-bottom: 1px solid #f1f5f9;">
                <div style="display:flex; justify-content:space-between; align-items:center; gap:0.5rem;">
                  <div style="min-width:0;">
                    <div style="font-weight:600; color:var(--emerald-900); font-size:0.92rem; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">
                      <?= htmlspecialchars($w->nama_lengkap, ENT_QUOTES) ?>
                    </div>
                    <div style="font-size:0.78rem; color:#64748b; margin-top:2px;">
                      Total: <strong style="color:#dc2626;">Rp <?= number_format($w->total_tunggakan, 0, ',', '.') ?></strong>
                    </div>
                  </div>
                  <span class="badge badge-warning"><?= (int)$w->bulan_menunggak ?> Bln</span>
                </div>
              </li>
            <?php endforeach; ?>
          <?php else: ?>
            <li style="padding: 2rem 1rem; text-align:center; color:#64748b;">
              <i class="fas fa-check-circle text-success" style="font-size:2rem; margin-bottom:0.5rem; display:block;"></i>
              Tidak ada warga menunggak
            </li>
          <?php endif; ?>
        </ul>
      </div>
      <div class="card-footer text-center" style="background: rgba(239,68,68,0.05);">
        <a href="<?= base_url('iuran/tunggakan') ?>" style="color:#dc2626; font-weight:600; font-size:0.85rem; text-decoration:none;">
          Lihat Semua Tunggakan <i class="fas fa-arrow-right ml-1"></i>
        </a>
      </div>
    </div>
  </div>
</div>
