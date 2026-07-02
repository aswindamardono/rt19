<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3 class="card-title m-0">Daftar Inventaris Barang</h3>
        <?php if(in_array($this->session->userdata('role_id'), [1, 4])): // Super Admin, Sekretaris ?>
        <a href="<?= base_url('inventaris/tambah') ?>" class="btn btn-primary btn-sm">
            <i class="fas fa-plus"></i> Tambah Barang
        </a>
        <?php endif; ?>
    </div>
    <div class="card-body">
        <?php if($this->session->flashdata('success')): ?>
            <div class="alert alert-success"><?= $this->session->flashdata('success') ?></div>
        <?php endif; ?>
        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <table id="table-inventaris" class="table table-bordered table-striped dt-responsive nowrap rt-table" style="width:100%">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama Barang</th>
                    <th>Jumlah</th>
                    <th>Kondisi</th>
                    <th>Keterangan</th>
                    <?php if(in_array($this->session->userdata('role_id'), [1, 4])): ?>
                    <th>Aksi</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php $no=1; foreach($inventaris as $item): ?>
                <tr>
                    <td><?= $no++ ?></td>
                    <td>
                        <?php if($item->foto): ?>
                            <img src="<?= base_url('assets/img/inventaris/' . $item->foto) ?>" alt="<?= htmlspecialchars($item->nama_barang, ENT_QUOTES) ?>" class="img-thumbnail" style="max-width: 80px; max-height: 80px; object-fit: cover;">
                        <?php else: ?>
                            <span class="text-muted"><i>Tidak ada foto</i></span>
                        <?php endif; ?>
                    </td>
                    <td><?= htmlspecialchars($item->nama_barang, ENT_QUOTES) ?></td>
                    <td><?= $item->jumlah ?></td>
                    <td>
                        <?php 
                            $badge_class = 'badge-success';
                            if ($item->kondisi == 'Rusak Ringan') $badge_class = 'badge-warning';
                            if ($item->kondisi == 'Rusak Berat') $badge_class = 'badge-danger';
                        ?>
                        <span class="badge <?= $badge_class ?>"><?= $item->kondisi ?></span>
                    </td>
                    <td><?= htmlspecialchars($item->keterangan, ENT_QUOTES) ?></td>
                    <?php if(in_array($this->session->userdata('role_id'), [1, 4])): ?>
                    <td>
                        <a href="<?= base_url('inventaris/edit/'.$item->id_inventaris) ?>" class="btn btn-warning btn-sm" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="<?= base_url('inventaris/hapus/'.$item->id_inventaris) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus data ini?')" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </a>
                    </td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
