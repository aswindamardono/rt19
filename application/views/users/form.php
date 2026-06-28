<div class="card card-primary">
    <div class="card-header">
        <h3 class="card-title"><?= $title ?></h3>
    </div>

    <form action="<?= current_url() ?>" method="POST">
        <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">

        <div class="card-body">
            <?php if($this->session->flashdata('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <?= $this->session->flashdata('error') ?>
                </div>
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Username *</label>
                        <input type="text" name="username" class="form-control" required 
                               value="<?= isset($user) ? htmlspecialchars($user->username) : '' ?>"
                               placeholder="Masukkan username">
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap *</label>
                        <input type="text" name="nama_lengkap" class="form-control" required 
                               value="<?= isset($user) ? htmlspecialchars($user->nama_lengkap) : '' ?>"
                               placeholder="Masukkan nama lengkap">
                    </div>
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" class="form-control" 
                               value="<?= isset($user) ? htmlspecialchars($user->email) : '' ?>"
                               placeholder="Masukkan email">
                    </div>
                </div>
                <div class="col-md-6">
                    <?php if(!isset($user)): ?>
                    <div class="form-group">
                        <label>Password *</label>
                        <input type="password" name="password" class="form-control" required minlength="6"
                               placeholder="Minimal 6 karakter">
                    </div>
                    <?php endif; ?>
                    <div class="form-group">
                        <label>Role *</label>
                        <select name="role_id" class="form-control" required>
                            <option value="">-- Pilih Role --</option>
                            <?php foreach($roles as $r): ?>
                                <option value="<?= $r->id ?>" <?= (isset($user) && $user->role_id == $r->id) ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($r->nama_role) ?> — <?= htmlspecialchars($r->deskripsi) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <?php if(isset($user)): ?>
                    <div class="form-group">
                        <label>Status Akun</label>
                        <select name="is_active" class="form-control">
                            <option value="1" <?= $user->is_active == 1 ? 'selected' : '' ?>>Aktif</option>
                            <option value="0" <?= $user->is_active == 0 ? 'selected' : '' ?>>Nonaktif</option>
                        </select>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
            <a href="<?= base_url('users') ?>" class="btn btn-default">Batal</a>
        </div>
    </form>
</div>
