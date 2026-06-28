<div class="card card-danger">
    <div class="card-header">
        <h3 class="card-title">Daftar Tunggakan Iuran (Batas Pembayaran Tanggal 10)</h3>
    </div>
    <div class="card-body">
        <table class="table table-bordered table-striped" id="table-tunggakan">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama Warga</th>
                    <th>RT</th>
                    <th>No HP</th>
                    <th>Bulan / Tahun</th>
                    <th>Nominal</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $no = 1; 
                $total_tunggakan = 0;
                foreach($tunggakan as $row): 
                    $total_tunggakan += $row->nominal;
                    $months = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td><?= $row->nama_lengkap ?></td>
                    <td><?= $row->rt ?></td>
                    <td>
                        <a href="https://wa.me/<?= preg_replace('/^0/', '62', $row->no_hp) ?>" target="_blank" class="btn btn-xs btn-success">
                            <i class="fab fa-whatsapp"></i> Hubungi
                        </a>
                    </td>
                    <td><?= $months[$row->bulan] . ' ' . $row->tahun ?></td>
                    <td class="text-right">Rp <?= number_format($row->nominal, 0, ',', '.') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <th colspan="5" class="text-right">TOTAL TUNGGAKAN</th>
                    <th class="text-right text-danger">Rp <?= number_format($total_tunggakan, 0, ',', '.') ?></th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>

<?php 
$data['custom_js'] = "
<script>
    $(document).ready(function() {
        $('#table-tunggakan').DataTable({
            'responsive': true,
            'autoWidth': false
        });
    });
</script>
";
?>
