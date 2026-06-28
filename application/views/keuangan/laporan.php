<div class="card">
    <div class="card-header">
        <h3 class="card-title">Laporan Keuangan</h3>
        <div class="card-tools">
            <a href="<?= base_url('google_sheets/sync') ?>" class="btn btn-success btn-sm">
                <i class="fas fa-sync-alt"></i> Sync ke Google Sheets
            </a>
        </div>
    </div>
    <div class="card-body">
        <form action="<?= current_url() ?>" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Dari Tanggal</label>
                        <input type="date" name="start_date" class="form-control" value="<?= $start_date ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>Sampai Tanggal</label>
                        <input type="date" name="end_date" class="form-control" value="<?= $end_date ?>" required>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label>&nbsp;</label><br>
                        <button type="submit" class="btn btn-primary"><i class="fas fa-search"></i> Tampilkan</button>
                    </div>
                </div>
            </div>
        </form>

        <hr>

        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Tanggal</th>
                    <th>Jenis</th>
                    <th>Kategori</th>
                    <th>Keterangan</th>
                    <th>Pemasukan</th>
                    <th>Pengeluaran</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1; 
                $total_masuk = 0;
                $total_keluar = 0;
                foreach($laporan as $row): 
                    if($row->jenis == 'pemasukan') {
                        $total_masuk += $row->nominal;
                    } else {
                        $total_keluar += $row->nominal;
                    }
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= date('d-m-Y', strtotime($row->tanggal)) ?></td>
                    <td>
                        <?php if($row->jenis == 'pemasukan'): ?>
                            <span class="badge badge-success">Pemasukan</span>
                        <?php else: ?>
                            <span class="badge badge-danger">Pengeluaran</span>
                        <?php endif; ?>
                    </td>
                    <td><?= $row->kategori ?></td>
                    <td><?= $row->keterangan ?></td>
                    <td class="text-right"><?= $row->jenis == 'pemasukan' ? 'Rp ' . number_format($row->nominal, 0, ',', '.') : '-' ?></td>
                    <td class="text-right"><?= $row->jenis == 'pengeluaran' ? 'Rp ' . number_format($row->nominal, 0, ',', '.') : '-' ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="text-right">TOTAL</th>
                    <th class="text-right text-success">Rp <?= number_format($total_masuk, 0, ',', '.') ?></th>
                    <th class="text-right text-danger">Rp <?= number_format($total_keluar, 0, ',', '.') ?></th>
                </tr>
                <tr>
                    <th colspan="5" class="text-right">SALDO AKHIR PERIODE INI</th>
                    <th colspan="2" class="text-center bg-info">Rp <?= number_format($total_masuk - $total_keluar, 0, ',', '.') ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
