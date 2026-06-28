<div class="row">
    <div class="col-md-12">
        <div class="card card-primary card-tabs">
            <div class="card-header p-0 pt-1">
                <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="custom-tabs-one-umum-tab" data-toggle="pill" href="#custom-tabs-one-umum" role="tab" aria-controls="custom-tabs-one-umum" aria-selected="true">Umum & Sistem</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-keuangan-tab" data-toggle="pill" href="#custom-tabs-one-keuangan" role="tab" aria-controls="custom-tabs-one-keuangan" aria-selected="false">Keuangan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="custom-tabs-one-integrasi-tab" data-toggle="pill" href="#custom-tabs-one-integrasi" role="tab" aria-controls="custom-tabs-one-integrasi" aria-selected="false">Integrasi & API</a>
                    </li>
                </ul>
            </div>
            
            <form action="<?= base_url('pengaturan/update') ?>" method="POST">
                <input type="hidden" name="<?= $this->security->get_csrf_token_name(); ?>" value="<?= $this->security->get_csrf_hash(); ?>">
                
                <div class="card-body">
                    <div class="tab-content" id="custom-tabs-one-tabContent">
                        
                        <!-- TAB UMUM -->
                        <div class="tab-pane fade show active" id="custom-tabs-one-umum" role="tabpanel" aria-labelledby="custom-tabs-one-umum-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nama RT</label>
                                        <input type="text" class="form-control" name="nama_rt" value="<?= html_escape($pengaturan['nama_rt'] ?? '') ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Perumahan</label>
                                        <input type="text" class="form-control" name="nama_perumahan" value="<?= html_escape($pengaturan['nama_perumahan'] ?? '') ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Nama Ketua RT</label>
                                        <input type="text" class="form-control" name="nama_ketua_rt" value="<?= html_escape($pengaturan['nama_ketua_rt'] ?? '') ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Email RT</label>
                                        <input type="email" class="form-control" name="email_rt" value="<?= html_escape($pengaturan['email_rt'] ?? '') ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Alamat Lengkap</label>
                                        <textarea class="form-control" name="alamat_lengkap" rows="3"><?= html_escape($pengaturan['alamat_lengkap'] ?? '') ?></textarea>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Kelurahan</label>
                                        <input type="text" class="form-control" name="kelurahan" value="<?= html_escape($pengaturan['kelurahan'] ?? '') ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Kecamatan</label>
                                        <input type="text" class="form-control" name="kecamatan" value="<?= html_escape($pengaturan['kecamatan'] ?? '') ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Kabupaten/Kota</label>
                                        <input type="text" class="form-control" name="kabupaten" value="<?= html_escape($pengaturan['kabupaten'] ?? '') ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Provinsi</label>
                                        <input type="text" class="form-control" name="provinsi" value="<?= html_escape($pengaturan['provinsi'] ?? '') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- TAB KEUANGAN -->
                        <div class="tab-pane fade" id="custom-tabs-one-keuangan" role="tabpanel" aria-labelledby="custom-tabs-one-keuangan-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Nominal Iuran Bulanan Default (Rp)</label>
                                        <input type="number" class="form-control" name="nominal_iuran" value="<?= html_escape($pengaturan['nominal_iuran'] ?? '') ?>">
                                        <small class="text-muted">Digunakan saat melakukan auto-generate tagihan bulanan.</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Batas Tanggal Pembayaran Iuran (Tgl)</label>
                                        <input type="number" class="form-control" name="batas_bayar" min="1" max="28" value="<?= html_escape($pengaturan['batas_bayar'] ?? '') ?>">
                                        <small class="text-muted">Tanggal jatuh tempo pembayaran setiap bulannya.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- TAB INTEGRASI -->
                        <div class="tab-pane fade" id="custom-tabs-one-integrasi" role="tabpanel" aria-labelledby="custom-tabs-one-integrasi-tab">
                            <div class="row">
                                <div class="col-md-6">
                                    <h5>Pengaturan Google Sheets</h5>
                                    <hr>
                                    <div class="form-group">
                                        <label>ID Google Spreadsheet</label>
                                        <input type="text" class="form-control" name="google_sheet_id" value="<?= html_escape($pengaturan['google_sheet_id'] ?? '') ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Path Google Credentials (JSON)</label>
                                        <input type="text" class="form-control" name="google_credentials_path" value="<?= html_escape($pengaturan['google_credentials_path'] ?? '') ?>">
                                        <small class="text-muted">Contoh: application/third_party/google-credentials.json</small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h5>Pengaturan WhatsApp Gateway</h5>
                                    <hr>
                                    <div class="form-group">
                                        <label>URL WhatsApp Gateway API</label>
                                        <input type="url" class="form-control" name="wa_gateway_url" value="<?= html_escape($pengaturan['wa_gateway_url'] ?? '') ?>">
                                    </div>
                                    <div class="form-group">
                                        <label>Token WhatsApp Gateway</label>
                                        <input type="text" class="form-control" name="wa_gateway_token" value="<?= html_escape($pengaturan['wa_gateway_token'] ?? '') ?>">
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan Pengaturan</button>
                </div>
            </form>
        </div>
    </div>
</div>
