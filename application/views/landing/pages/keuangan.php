<section class="public-hero">
  <div class="public-hero-content" data-aos="fade-up" data-aos-duration="700">
    <span class="hero-pill">
      <i class="fas fa-leaf"></i> Orchid Regency Sidoarjo
    </span>
    <h1>Transparansi &amp; Kemudahan<br>Untuk Warga Orchid Regency RT-19</h1>
    <p>
      Sistem informasi, administrasi, dan transparansi keuangan
      lingkungan RT-19 Orchid Regency Sidoarjo &mdash; agar setiap warga
      bisa memantau kas, iuran, dan informasi terbaru kapan saja.
    </p>
  </div>
</section>

<div class="pub-page" data-aos="fade-up" data-aos-duration="500">

  <!-- Ringkasan Keuangan Page -->
  <div class="pub-page-header">
    <h1><i class="fas fa-chart-pie"></i> Ringkasan Keuangan</h1>
    <p>Periode pemasukan &amp; pengeluaran: <strong><?= htmlspecialchars($bulan_label, ENT_QUOTES) ?></strong></p>
  </div>

  <div class="pub-stat-grid" data-aos="fade-up" data-aos-delay="100">
    <!-- Total Saldo -->
    <div class="pub-stat">
      <div class="pub-stat-icon balance"><i class="fas fa-wallet"></i></div>
      <div class="pub-stat-label">Total Saldo Kas RT</div>
      <div class="pub-stat-value balance">
        Rp <?= number_format((float) $total_kas, 0, ',', '.') ?>
      </div>
      <div class="pub-stat-period">Akumulasi seluruh transaksi</div>
    </div>

    <!-- Pemasukan Bulan Kemarin (Clickable) -->
    <div class="pub-stat pub-stat-interactive" onclick="openModalTransaksi('pemasukan', <?= $last_month ?>, <?= $last_year ?>)" role="button" tabindex="0" title="Klik untuk melihat rincian transaksi">
      <div class="pub-stat-icon income"><i class="fas fa-arrow-down"></i></div>
      <div class="pub-stat-label">
        Pemasukan Bulan Kemarin
        <span class="stat-click-hint"><i class="fas fa-search-plus"></i> Detail</span>
      </div>
      <div class="pub-stat-value income">
        Rp <?= number_format((float) $pemasukan_bln, 0, ',', '.') ?>
      </div>
      <div class="pub-stat-period">
        <span><?= htmlspecialchars($bulan_label, ENT_QUOTES) ?></span>
        <span class="stat-cta-link"><i class="fas fa-arrow-right"></i> Lihat Rincian</span>
      </div>
    </div>

    <!-- Pengeluaran Bulan Kemarin (Clickable) -->
    <div class="pub-stat pub-stat-interactive" onclick="openModalTransaksi('pengeluaran', <?= $last_month ?>, <?= $last_year ?>)" role="button" tabindex="0" title="Klik untuk melihat rincian transaksi">
      <div class="pub-stat-icon expense"><i class="fas fa-arrow-up"></i></div>
      <div class="pub-stat-label">
        Pengeluaran Bulan Kemarin
        <span class="stat-click-hint"><i class="fas fa-search-plus"></i> Detail</span>
      </div>
      <div class="pub-stat-value expense">
        Rp <?= number_format((float) $pengeluaran_bln, 0, ',', '.') ?>
      </div>
      <div class="pub-stat-period">
        <span><?= htmlspecialchars($bulan_label, ENT_QUOTES) ?></span>
        <span class="stat-cta-link"><i class="fas fa-arrow-right"></i> Lihat Rincian</span>
      </div>
    </div>
  </div>

  <!-- Info Banner -->
  <div class="tx-info-tip" data-aos="fade-up" data-aos-delay="150">
    <i class="fas fa-info-circle"></i>
    <span>Klik pada kartu <strong>Pemasukan</strong> atau <strong>Pengeluaran</strong> di atas untuk membuka riwayat transaksi lengkap per bulan dan tahun.</span>
  </div>

  <!-- CTA -->
  <div class="pub-cta" data-aos="zoom-in" data-aos-delay="200">
    <h3>Pengurus RT-19?</h3>
    <p>Masuk untuk mengelola data warga, kas, iuran, dan surat menyurat.</p>
    <a href="<?= base_url('auth') ?>" class="pub-cta-btn">
      <i class="fas fa-sign-in-alt"></i> Login Sekarang
    </a>
  </div>

</div>

<!-- =========================================================================
     MODAL DETAIL TRANSAKSI (POPUP)
     ========================================================================= -->
<div class="tx-modal-overlay" id="modalDetailTransaksi" onclick="if(event.target===this) closeModalTransaksi()">
  <div class="tx-modal-dialog" role="dialog" aria-modal="true" aria-labelledby="txModalTitle">
    
    <!-- Modal Header -->
    <div class="tx-modal-header">
      <div class="tx-modal-title-wrap">
        <div class="tx-modal-header-icon" id="txHeaderIcon">
          <i class="fas fa-receipt"></i>
        </div>
        <div>
          <h2 class="tx-modal-title" id="txModalTitle">Rincian Transaksi Kas RT</h2>
          <p class="tx-modal-subtitle">Transparansi pemasukan &amp; pengeluaran kas RT-19</p>
        </div>
      </div>
      <button type="button" class="tx-modal-close-btn" onclick="closeModalTransaksi()" aria-label="Tutup modal">
        <i class="fas fa-times"></i>
      </button>
    </div>

    <!-- Modal Filter Toolbar -->
    <div class="tx-filter-toolbar">
      <!-- Jenis Transaksi Tabs -->
      <div class="tx-type-pills">
        <button type="button" class="tx-pill-btn active" id="btnTypePemasukan" onclick="setTypeFilter('pemasukan')">
          <i class="fas fa-arrow-down"></i> Pemasukan
        </button>
        <button type="button" class="tx-pill-btn" id="btnTypePengeluaran" onclick="setTypeFilter('pengeluaran')">
          <i class="fas fa-arrow-up"></i> Pengeluaran
        </button>
        <button type="button" class="tx-pill-btn" id="btnTypeSemua" onclick="setTypeFilter('semua')">
          <i class="fas fa-list"></i> Semua
        </button>
      </div>

      <!-- Controls: Bulan, Tahun, Prev/Next -->
      <div class="tx-filter-controls">
        <button type="button" class="tx-nav-btn" onclick="stepMonth(-1)" title="Bulan Sebelumnya">
          <i class="fas fa-chevron-left"></i>
        </button>

        <div class="tx-select-group">
          <select id="filterBulan" class="tx-select" onchange="onPeriodChange()">
            <option value="1">Januari</option>
            <option value="2">Februari</option>
            <option value="3">Maret</option>
            <option value="4">April</option>
            <option value="5">Mei</option>
            <option value="6">Juni</option>
            <option value="7">Juli</option>
            <option value="8">Agustus</option>
            <option value="9">September</option>
            <option value="10">Oktober</option>
            <option value="11">November</option>
            <option value="12">Desember</option>
          </select>
        </div>

        <div class="tx-select-group">
          <select id="filterTahun" class="tx-select" onchange="onPeriodChange()">
            <?php 
              $cur_year = (int) date('Y');
              for ($y = $cur_year + 1; $y >= 2023; $y--): 
            ?>
              <option value="<?= $y ?>"><?= $y ?></option>
            <?php endfor; ?>
          </select>
        </div>

        <button type="button" class="tx-nav-btn" onclick="stepMonth(1)" title="Bulan Berikutnya">
          <i class="fas fa-chevron-right"></i>
        </button>
      </div>
    </div>

    <!-- Search & Summary Bar -->
    <div class="tx-meta-bar">
      <div class="tx-search-box">
        <i class="fas fa-search"></i>
        <input type="text" id="txSearchInput" placeholder="Cari kategori atau keterangan..." oninput="filterTableRows()">
      </div>
      <div class="tx-summary-chips">
        <div class="tx-chip tx-chip-period" id="txChipPeriod">
          <i class="far fa-calendar-alt"></i> <span id="txPeriodeLabel">-</span>
        </div>
        <div class="tx-chip tx-chip-total" id="txChipTotal">
          <span id="txTotalLabel">Total: Rp 0</span>
        </div>
        <div class="tx-chip tx-chip-count" id="txChipCount">
          <span id="txCountBadge">0 Transaksi</span>
        </div>
      </div>
    </div>

    <!-- Modal Body / Content -->
    <div class="tx-modal-body">
      
      <!-- Loading State -->
      <div class="tx-loading-state" id="txLoadingState" style="display: none;">
        <div class="tx-spinner"></div>
        <p>Memuat rincian transaksi...</p>
      </div>

      <!-- Content Container -->
      <div id="txContentContainer">
        <!-- Desktop Table -->
        <div class="tx-table-responsive">
          <table class="tx-table">
            <thead>
              <tr>
                <th style="width: 50px;">No</th>
                <th style="width: 140px;">Tanggal</th>
                <th style="width: 160px;">Kategori</th>
                <th>Keterangan</th>
                <th style="width: 180px; text-align: right;">Nominal</th>
              </tr>
            </thead>
            <tbody id="txTableBody">
              <!-- Rendered via JS -->
            </tbody>
          </table>
        </div>

        <!-- Mobile Cards List -->
        <div class="tx-cards-list" id="txCardsList">
          <!-- Rendered via JS -->
        </div>

        <!-- Empty State -->
        <div class="tx-empty-state" id="txEmptyState" style="display: none;">
          <div class="tx-empty-icon">
            <i class="far fa-folder-open"></i>
          </div>
          <h4>Tidak Ada Transaksi</h4>
          <p id="txEmptyText">Tidak ditemukan catatan transaksi pada periode yang dipilih.</p>
        </div>
      </div>
    </div>

    <!-- Modal Footer -->
    <div class="tx-modal-footer">
      <div class="tx-footer-note">
        <i class="fas fa-shield-alt"></i> Data kas terverifikasi oleh Bendahara RT-19
      </div>
      <button type="button" class="tx-btn-close-footer" onclick="closeModalTransaksi()">
        Tutup
      </button>
    </div>

  </div>
</div>

<!-- =========================================================================
     STYLES KHUSUS MODAL & STATS INTERAKTIF
     ========================================================================= -->
<style>
/* Stat Cards Interaktif */
.pub-stat-interactive {
  cursor: pointer;
  transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
  position: relative;
  outline: none;
}
.pub-stat-interactive:hover, .pub-stat-interactive:focus-visible {
  transform: translateY(-4px);
  box-shadow: 0 12px 24px -6px rgba(16, 185, 129, 0.18), 0 4px 8px -2px rgba(0, 0, 0, 0.06);
  border-color: rgba(16, 185, 129, 0.35);
}
.stat-click-hint {
  display: inline-flex;
  align-items: center;
  gap: 3px;
  font-size: 0.7rem;
  padding: 2px 6px;
  background: #f1f5f9;
  color: #475569;
  border-radius: 999px;
  margin-left: 6px;
  font-weight: 500;
  vertical-align: middle;
}
.pub-stat-interactive:hover .stat-click-hint {
  background: var(--emerald-50);
  color: var(--emerald-700);
}
.stat-cta-link {
  font-size: 0.8rem;
  font-weight: 600;
  color: var(--emerald-600);
  margin-left: auto;
  display: inline-flex;
  align-items: center;
  gap: 4px;
}
.pub-stat-period {
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
}

/* Tip info bar */
.tx-info-tip {
  max-width: 960px;
  margin: 1rem auto 0;
  background: #ecfdf5;
  border: 1px solid #a7f3d0;
  border-radius: 12px;
  padding: 0.85rem 1.25rem;
  display: flex;
  align-items: center;
  gap: 0.75rem;
  font-size: 0.875rem;
  color: #065f46;
  box-shadow: 0 1px 3px rgba(0,0,0,0.03);
}
.tx-info-tip i {
  font-size: 1.15rem;
  color: #059669;
  flex-shrink: 0;
}

/* Modal Overlay & Dialog */
.tx-modal-overlay {
  position: fixed;
  inset: 0;
  background: rgba(15, 23, 42, 0.65);
  backdrop-filter: blur(6px);
  -webkit-backdrop-filter: blur(6px);
  z-index: 9999;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1rem;
  opacity: 0;
  visibility: hidden;
  transition: all 0.25s ease;
}
.tx-modal-overlay.is-open {
  opacity: 1;
  visibility: visible;
}
.tx-modal-dialog {
  background: #ffffff;
  width: 100%;
  max-width: 900px;
  max-height: 90vh;
  border-radius: 20px;
  box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
  display: flex;
  flex-direction: column;
  overflow: hidden;
  transform: scale(0.94) translateY(12px);
  transition: all 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
  border: 1px solid rgba(226, 232, 240, 0.8);
}
.tx-modal-overlay.is-open .tx-modal-dialog {
  transform: scale(1) translateY(0);
}

/* Modal Header */
.tx-modal-header {
  padding: 1.25rem 1.5rem;
  background: linear-gradient(135deg, #064e3b 0%, #047857 60%, #0d9488 100%);
  color: white;
  display: flex;
  align-items: center;
  justify-content: space-between;
  border-bottom: 1px solid rgba(255,255,255,0.1);
}
.tx-modal-title-wrap {
  display: flex;
  align-items: center;
  gap: 0.85rem;
}
.tx-modal-header-icon {
  width: 44px;
  height: 44px;
  border-radius: 12px;
  background: rgba(255, 255, 255, 0.15);
  backdrop-filter: blur(8px);
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.25rem;
  color: #a7f3d0;
  flex-shrink: 0;
}
.tx-modal-title {
  margin: 0;
  font-size: 1.25rem;
  font-weight: 700;
  color: #ffffff !important;
  font-family: 'Plus Jakarta Sans', sans-serif !important;
}
.tx-modal-subtitle {
  margin: 2px 0 0;
  font-size: 0.825rem;
  color: #d1fae5;
}
.tx-modal-close-btn {
  width: 36px;
  height: 36px;
  border-radius: 50%;
  border: none;
  background: rgba(255, 255, 255, 0.15);
  color: white;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.2s;
  font-size: 1rem;
}
.tx-modal-close-btn:hover {
  background: rgba(255, 255, 255, 0.3);
  transform: rotate(90deg);
}

/* Toolbar & Filters */
.tx-filter-toolbar {
  padding: 1rem 1.5rem;
  background: #f8fafc;
  border-bottom: 1px solid #e2e8f0;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 0.75rem;
}
.tx-type-pills {
  display: inline-flex;
  background: #e2e8f0;
  padding: 3px;
  border-radius: 10px;
  gap: 2px;
}
.tx-pill-btn {
  border: none;
  background: transparent;
  padding: 0.45rem 0.9rem;
  font-size: 0.825rem;
  font-weight: 600;
  color: #475569;
  border-radius: 8px;
  cursor: pointer;
  transition: all 0.15s ease;
  display: inline-flex;
  align-items: center;
  gap: 6px;
}
.tx-pill-btn:hover {
  color: #0f172a;
}
.tx-pill-btn.active#btnTypePemasukan {
  background: #059669;
  color: #ffffff;
  box-shadow: 0 2px 6px rgba(5, 150, 105, 0.25);
}
.tx-pill-btn.active#btnTypePengeluaran {
  background: #dc2626;
  color: #ffffff;
  box-shadow: 0 2px 6px rgba(220, 38, 38, 0.25);
}
.tx-pill-btn.active#btnTypeSemua {
  background: #0f172a;
  color: #ffffff;
  box-shadow: 0 2px 6px rgba(15, 23, 42, 0.25);
}

.tx-filter-controls {
  display: flex;
  align-items: center;
  gap: 0.4rem;
}
.tx-nav-btn {
  width: 36px;
  height: 36px;
  border-radius: 8px;
  border: 1px solid #cbd5e1;
  background: white;
  color: #334155;
  display: inline-flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.15s;
}
.tx-nav-btn:hover {
  background: #f1f5f9;
  border-color: #94a3b8;
  color: #0f172a;
}
.tx-select-group {
  position: relative;
}
.tx-select {
  appearance: none;
  -webkit-appearance: none;
  background: white url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E") no-repeat right 0.6rem center/14px;
  border: 1px solid #cbd5e1;
  border-radius: 8px;
  padding: 0.45rem 2rem 0.45rem 0.85rem;
  font-size: 0.85rem;
  font-weight: 600;
  color: #1e293b;
  cursor: pointer;
  outline: none;
  transition: border-color 0.15s;
}
.tx-select:focus {
  border-color: var(--emerald-500);
  box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
}

/* Meta Bar (Search & Summary Chips) */
.tx-meta-bar {
  padding: 0.75rem 1.5rem;
  background: #ffffff;
  border-bottom: 1px solid #f1f5f9;
  display: flex;
  align-items: center;
  justify-content: space-between;
  flex-wrap: wrap;
  gap: 0.75rem;
}
.tx-search-box {
  position: relative;
  flex: 1;
  min-width: 220px;
  max-width: 320px;
}
.tx-search-box i {
  position: absolute;
  left: 0.75rem;
  top: 50%;
  transform: translateY(-50%);
  color: #94a3b8;
  font-size: 0.85rem;
}
.tx-search-box input {
  width: 100%;
  border: 1px solid #e2e8f0;
  border-radius: 8px;
  padding: 0.45rem 0.75rem 0.45rem 2.2rem;
  font-size: 0.825rem;
  color: #1e293b;
  background: #f8fafc;
  outline: none;
  transition: all 0.15s;
}
.tx-search-box input:focus {
  background: #ffffff;
  border-color: var(--emerald-500);
  box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.12);
}

.tx-summary-chips {
  display: flex;
  align-items: center;
  gap: 0.5rem;
  flex-wrap: wrap;
}
.tx-chip {
  padding: 0.35rem 0.75rem;
  border-radius: 6px;
  font-size: 0.8rem;
  font-weight: 600;
  display: inline-flex;
  align-items: center;
  gap: 5px;
}
.tx-chip-period {
  background: #f1f5f9;
  color: #334155;
}
.tx-chip-total {
  background: #ecfdf5;
  color: #065f46;
  border: 1px solid #a7f3d0;
}
.tx-chip-total.expense {
  background: #fef2f2;
  color: #991b1b;
  border-color: #fecaca;
}
.tx-chip-count {
  background: #f8fafc;
  color: #64748b;
  border: 1px solid #e2e8f0;
}

/* Modal Body */
.tx-modal-body {
  padding: 1.25rem 1.5rem;
  overflow-y: auto;
  flex: 1;
  min-height: 260px;
  background: #fafafa;
}

/* Table Design */
.tx-table-responsive {
  display: block;
  width: 100%;
  overflow-x: auto;
  background: white;
  border-radius: 12px;
  border: 1px solid #e2e8f0;
  box-shadow: 0 1px 3px rgba(0,0,0,0.02);
}
.tx-table {
  width: 100%;
  border-collapse: collapse;
  text-align: left;
  font-size: 0.875rem;
}
.tx-table th {
  background: #f8fafc;
  color: #475569;
  font-weight: 700;
  padding: 0.75rem 1rem;
  border-bottom: 1px solid #e2e8f0;
  font-size: 0.8rem;
  text-transform: uppercase;
  letter-spacing: 0.03em;
}
.tx-table td {
  padding: 0.85rem 1rem;
  border-bottom: 1px solid #f1f5f9;
  color: #334155;
  vertical-align: middle;
}
.tx-table tr:last-child td {
  border-bottom: none;
}
.tx-table tr:hover td {
  background: #f8fafc;
}

/* Badges & Format */
.tx-badge-cat {
  display: inline-flex;
  align-items: center;
  gap: 4px;
  padding: 3px 8px;
  border-radius: 6px;
  font-size: 0.75rem;
  font-weight: 600;
  background: #f1f5f9;
  color: #475569;
}
.tx-nominal {
  font-weight: 700;
  font-family: 'Plus Jakarta Sans', monospace, sans-serif;
  font-size: 0.95rem;
}
.tx-nominal.pemasukan {
  color: #059669;
}
.tx-nominal.pengeluaran {
  color: #dc2626;
}
.tx-btn-bukti {
  border: none;
  background: #ecfdf5;
  color: #047857;
  padding: 4px 8px;
  border-radius: 6px;
  font-size: 0.75rem;
  font-weight: 600;
  cursor: pointer;
  display: inline-flex;
  align-items: center;
  gap: 4px;
  transition: all 0.15s;
}
.tx-btn-bukti:hover {
  background: #047857;
  color: white;
}

/* Mobile Cards */
.tx-cards-list {
  display: none;
  flex-direction: column;
  gap: 0.75rem;
}
.tx-mobile-card {
  background: white;
  border-radius: 12px;
  border: 1px solid #e2e8f0;
  padding: 1rem;
  box-shadow: 0 1px 3px rgba(0,0,0,0.03);
}
.tx-card-head {
  display: flex;
  justify-content: space-between;
  align-items: flex-start;
  margin-bottom: 0.5rem;
}
.tx-card-date {
  font-size: 0.775rem;
  color: #64748b;
  font-weight: 500;
}
.tx-card-desc {
  font-size: 0.875rem;
  color: #1e293b;
  margin-bottom: 0.75rem;
  line-height: 1.4;
}
.tx-card-foot {
  display: flex;
  justify-content: space-between;
  align-items: center;
  padding-top: 0.5rem;
  border-top: 1px dashed #f1f5f9;
}

/* Loading & Empty States */
.tx-loading-state, .tx-empty-state {
  text-align: center;
  padding: 3rem 1.5rem;
}
.tx-spinner {
  width: 40px;
  height: 40px;
  border: 3px solid #d1fae5;
  border-top-color: #059669;
  border-radius: 50%;
  animation: txSpin 0.7s linear infinite;
  margin: 0 auto 1rem;
}
@keyframes txSpin {
  to { transform: rotate(360deg); }
}
.tx-empty-icon {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  background: #f1f5f9;
  color: #94a3b8;
  font-size: 1.75rem;
  display: flex;
  align-items: center;
  justify-content: center;
  margin: 0 auto 1rem;
}
.tx-empty-state h4 {
  margin: 0 0 0.25rem;
  color: #334155;
  font-size: 1.05rem;
}
.tx-empty-state p {
  margin: 0;
  color: #64748b;
  font-size: 0.85rem;
}

/* Modal Footer */
.tx-modal-footer {
  padding: 0.9rem 1.5rem;
  background: #ffffff;
  border-top: 1px solid #e2e8f0;
  display: flex;
  align-items: center;
  justify-content: space-between;
}
.tx-footer-note {
  font-size: 0.8rem;
  color: #64748b;
  display: flex;
  align-items: center;
  gap: 6px;
}
.tx-footer-note i {
  color: #059669;
}
.tx-btn-close-footer {
  border: 1px solid #cbd5e1;
  background: #f8fafc;
  color: #334155;
  padding: 0.45rem 1.15rem;
  border-radius: 8px;
  font-size: 0.85rem;
  font-weight: 600;
  cursor: pointer;
  transition: all 0.15s;
}
.tx-btn-close-footer:hover {
  background: #e2e8f0;
  color: #0f172a;
}

/* Lightbox Preview */
.tx-lightbox-overlay {
  position: fixed;
  inset: 0;
  background: rgba(0, 0, 0, 0.85);
  backdrop-filter: blur(8px);
  z-index: 10000;
  display: flex;
  align-items: center;
  justify-content: center;
  padding: 1.5rem;
  opacity: 0;
  visibility: hidden;
  transition: all 0.2s ease;
}
.tx-lightbox-overlay.is-open {
  opacity: 1;
  visibility: visible;
}
.tx-lightbox-box {
  position: relative;
  max-width: 90vw;
  max-height: 90vh;
  text-align: center;
}
.tx-lightbox-box img {
  max-width: 100%;
  max-height: 80vh;
  border-radius: 12px;
  box-shadow: 0 20px 40px rgba(0,0,0,0.5);
}
.tx-lightbox-close {
  position: absolute;
  top: -40px;
  right: 0;
  font-size: 2rem;
  color: white;
  background: transparent;
  border: none;
  cursor: pointer;
}

/* Responsive Breakpoints */
@media (max-width: 768px) {
  .tx-table-responsive {
    display: none;
  }
  .tx-cards-list {
    display: flex;
  }
  .tx-filter-toolbar {
    flex-direction: column;
    align-items: stretch;
  }
  .tx-type-pills {
    display: flex;
  }
  .tx-pill-btn {
    flex: 1;
    justify-content: center;
  }
  .tx-filter-controls {
    justify-content: space-between;
  }
  .tx-select-group {
    flex: 1;
  }
  .tx-select {
    width: 100%;
  }
  .tx-meta-bar {
    flex-direction: column;
    align-items: stretch;
  }
  .tx-search-box {
    max-width: 100%;
  }
  .tx-summary-chips {
    justify-content: space-between;
  }
}
</style>

<!-- =========================================================================
     JAVASCRIPT LOGIC TRANSAKSI MODAL
     ========================================================================= -->
<script>
(function() {
  // State
  var currentType = 'pemasukan';
  var currentMonth = <?= (int) $last_month ?>;
  var currentYear = <?= (int) $last_year ?>;
  var cachedData = [];
  var isFetching = false;

  var namaBulan = [
    '', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
  ];

  window.openModalTransaksi = function(type, month, year) {
    currentType = type || 'pemasukan';
    if (month) currentMonth = parseInt(month, 10);
    if (year) currentYear = parseInt(year, 10);

    updateTypePillsUI();
    document.getElementById('filterBulan').value = currentMonth;
    document.getElementById('filterTahun').value = currentYear;
    document.getElementById('txSearchInput').value = '';

    var modal = document.getElementById('modalDetailTransaksi');
    modal.classList.add('is-open');
    document.body.style.overflow = 'hidden';

    fetchTransaksiData();
  };

  window.closeModalTransaksi = function() {
    var modal = document.getElementById('modalDetailTransaksi');
    modal.classList.remove('is-open');
    document.body.style.overflow = '';
  };

  window.setTypeFilter = function(type) {
    if (currentType === type) return;
    currentType = type;
    updateTypePillsUI();
    fetchTransaksiData();
  };

  window.onPeriodChange = function() {
    currentMonth = parseInt(document.getElementById('filterBulan').value, 10);
    currentYear = parseInt(document.getElementById('filterTahun').value, 10);
    fetchTransaksiData();
  };

  window.stepMonth = function(delta) {
    currentMonth += delta;
    if (currentMonth < 1) {
      currentMonth = 12;
      currentYear -= 1;
    } else if (currentMonth > 12) {
      currentMonth = 1;
      currentYear += 1;
    }

    document.getElementById('filterBulan').value = currentMonth;
    
    // Pastikan tahun ada di select option, jika belum ada tambahkan
    var tahunSelect = document.getElementById('filterTahun');
    var optionFound = false;
    for (var i = 0; i < tahunSelect.options.length; i++) {
      if (parseInt(tahunSelect.options[i].value, 10) === currentYear) {
        optionFound = true;
        break;
      }
    }
    if (!optionFound) {
      var opt = document.createElement('option');
      opt.value = currentYear;
      opt.textContent = currentYear;
      tahunSelect.appendChild(opt);
    }
    tahunSelect.value = currentYear;

    fetchTransaksiData();
  };

  function updateTypePillsUI() {
    var btnIn = document.getElementById('btnTypePemasukan');
    var btnOut = document.getElementById('btnTypePengeluaran');
    var btnAll = document.getElementById('btnTypeSemua');
    var headerIcon = document.getElementById('txHeaderIcon');
    var modalTitle = document.getElementById('txModalTitle');

    btnIn.classList.remove('active');
    btnOut.classList.remove('active');
    btnAll.classList.remove('active');

    if (currentType === 'pemasukan') {
      btnIn.classList.add('active');
      headerIcon.innerHTML = '<i class="fas fa-arrow-down"></i>';
      headerIcon.style.color = '#a7f3d0';
      modalTitle.textContent = 'Rincian Transaksi Pemasukan Kas RT';
    } else if (currentType === 'pengeluaran') {
      btnOut.classList.add('active');
      headerIcon.innerHTML = '<i class="fas fa-arrow-up"></i>';
      headerIcon.style.color = '#fecaca';
      modalTitle.textContent = 'Rincian Transaksi Pengeluaran Kas RT';
    } else {
      btnAll.classList.add('active');
      headerIcon.innerHTML = '<i class="fas fa-receipt"></i>';
      headerIcon.style.color = '#93c5fd';
      modalTitle.textContent = 'Rincian Seluruh Transaksi Kas RT';
    }
  }

  function formatRupiah(num) {
    return 'Rp ' + Number(num || 0).toLocaleString('id-ID');
  }

  function formatTanggalIndo(dateStr) {
    if (!dateStr) return '-';
    var parts = dateStr.split('-');
    if (parts.length !== 3) return dateStr;
    var d = parseInt(parts[2], 10);
    var m = parseInt(parts[1], 10);
    var y = parts[0];
    var blnSingkat = ['', 'Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
    return d + ' ' + (blnSingkat[m] || '') + ' ' + y;
  }

  function escapeHtml(str) {
    if (!str) return '';
    return str.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
  }

  function fetchTransaksiData() {
    if (isFetching) return;
    isFetching = true;

    var loading = document.getElementById('txLoadingState');
    var container = document.getElementById('txContentContainer');
    loading.style.display = 'block';
    container.style.opacity = '0.4';

    var url = '<?= base_url("home/get_transaksi_ajax") ?>?month=' + currentMonth + '&year=' + currentYear + '&type=' + currentType;

    fetch(url)
      .then(function(res) { return res.json(); })
      .then(function(res) {
        isFetching = false;
        loading.style.display = 'none';
        container.style.opacity = '1';

        if (res.status === 'success') {
          cachedData = res.data || [];
          updateSummaryUI(res);
          renderList(cachedData);
        }
      })
      .catch(function(err) {
        isFetching = false;
        loading.style.display = 'none';
        container.style.opacity = '1';
        console.error('Error fetching transactions:', err);
      });
  }

  function updateSummaryUI(res) {
    var periodeLabel = document.getElementById('txPeriodeLabel');
    var totalLabel = document.getElementById('txTotalLabel');
    var countBadge = document.getElementById('txCountBadge');
    var chipTotal = document.getElementById('txChipTotal');

    periodeLabel.textContent = (namaBulan[res.month] || '') + ' ' + res.year;
    countBadge.textContent = res.count + ' Transaksi';

    chipTotal.classList.remove('expense');

    if (currentType === 'pemasukan') {
      totalLabel.textContent = 'Total Pemasukan: ' + formatRupiah(res.total_pemasukan);
    } else if (currentType === 'pengeluaran') {
      chipTotal.classList.add('expense');
      totalLabel.textContent = 'Total Pengeluaran: ' + formatRupiah(res.total_pengeluaran);
    } else {
      var net = (res.total_pemasukan || 0) - (res.total_pengeluaran || 0);
      if (net < 0) chipTotal.classList.add('expense');
      totalLabel.textContent = 'Pemasukan: ' + formatRupiah(res.total_pemasukan) + ' | Pengeluaran: ' + formatRupiah(res.total_pengeluaran);
    }
  }

  function renderList(items) {
    var tbody = document.getElementById('txTableBody');
    var cards = document.getElementById('txCardsList');
    var empty = document.getElementById('txEmptyState');
    var emptyText = document.getElementById('txEmptyText');

    tbody.innerHTML = '';
    cards.innerHTML = '';

    if (!items || items.length === 0) {
      empty.style.display = 'block';
      emptyText.textContent = 'Tidak ditemukan catatan transaksi ' + (currentType === 'pemasukan' ? 'pemasukan' : (currentType === 'pengeluaran' ? 'pengeluaran' : '')) + ' pada periode ' + (namaBulan[currentMonth] || '') + ' ' + currentYear + '.';
      return;
    }

    empty.style.display = 'none';

    items.forEach(function(item, idx) {
      var isIncome = item.jenis === 'pemasukan';
      var nominalClass = isIncome ? 'pemasukan' : 'pengeluaran';
      var sign = isIncome ? '+ ' : '- ';
      var formattedNominal = sign + formatRupiah(item.nominal);
      var formattedDate = formatTanggalIndo(item.tanggal);
      var category = escapeHtml(item.kategori || '-');
      var keterangan = escapeHtml(item.keterangan || '-');

      // Desktop Row
      var tr = document.createElement('tr');
      tr.innerHTML = 
        '<td><span style="color:#94a3b8; font-weight:600;">' + (idx + 1) + '</span></td>' +
        '<td><i class="far fa-calendar" style="color:#94a3b8; margin-right:4px;"></i> ' + formattedDate + '</td>' +
        '<td><span class="tx-badge-cat">' + category + '</span></td>' +
        '<td><span style="font-weight:500;">' + keterangan + '</span></td>' +
        '<td style="text-align: right;"><span class="tx-nominal ' + nominalClass + '">' + formattedNominal + '</span></td>';
      tbody.appendChild(tr);

      // Mobile Card
      var card = document.createElement('div');
      card.className = 'tx-mobile-card';
      card.innerHTML = 
        '<div class="tx-card-head">' +
          '<span class="tx-badge-cat">' + category + '</span>' +
          '<span class="tx-card-date"><i class="far fa-calendar"></i> ' + formattedDate + '</span>' +
        '</div>' +
        '<div class="tx-card-desc">' + keterangan + '</div>' +
        '<div class="tx-card-foot">' +
          '<span style="font-size:0.8rem; color:#64748b; font-weight:500;">Nominal</span>' +
          '<div class="tx-nominal ' + nominalClass + '">' + formattedNominal + '</div>' +
        '</div>';
      cards.appendChild(card);
    });
  }

  window.filterTableRows = function() {
    var query = document.getElementById('txSearchInput').value.toLowerCase().trim();
    if (!query) {
      renderList(cachedData);
      return;
    }
    var filtered = cachedData.filter(function(item) {
      var ket = (item.keterangan || '').toLowerCase();
      var kat = (item.kategori || '').toLowerCase();
      var nom = String(item.nominal || '').toLowerCase();
      return ket.indexOf(query) !== -1 || kat.indexOf(query) !== -1 || nom.indexOf(query) !== -1;
    });
    renderList(filtered);
  };

  // Keyboard shortcut ESC to close
  document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
      if (document.getElementById('modalDetailTransaksi').classList.contains('is-open')) {
        closeModalTransaksi();
      }
    }
  });

})();
</script>