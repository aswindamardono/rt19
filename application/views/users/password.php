<div class="card card-warning">
    <div class="card-header">
        <h3 class="card-title"><i class="fas fa-key"></i> <?= $title ?></h3>
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

            <div class="callout callout-info">
                <h5><i class="fas fa-user"></i> <?= htmlspecialchars($user->nama_lengkap) ?></h5>
                <p>Username: <strong><?= htmlspecialchars($user->username) ?></strong> &mdash; Role: <strong><?= htmlspecialchars($user->nama_role) ?></strong></p>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Password Baru *</label>
                        <input type="password" name="password" class="form-control" required minlength="6"
                               placeholder="Minimal 6 karakter">
                    </div>
                    <div class="form-group">
                        <label>Konfirmasi Password *</label>
                        <input type="password" name="password_confirm" class="form-control" required minlength="6"
                               placeholder="Ketik ulang password baru">
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer">
            <button type="submit" class="btn btn-warning"><i class="fas fa-key"></i> Ganti Password</button>
            <a href="<?= base_url('users') ?>" class="btn btn-default">Batal</a>
        </div>
    </form>
</div>
