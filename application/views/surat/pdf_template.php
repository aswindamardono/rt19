<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Surat Keterangan</title>
    <style>
        body { font-family: "Times New Roman", Times, serif; font-size: 12pt; line-height: 1.5; }
        .header { text-align: center; border-bottom: 3px solid black; padding-bottom: 10px; margin-bottom: 20px; }
        .header h1, .header h2, .header h3 { margin: 0; padding: 0; }
        .header h2 { font-size: 16pt; font-weight: bold; }
        .header p { font-size: 11pt; margin-top: 5px; }
        .title { text-align: center; font-weight: bold; text-decoration: underline; margin-bottom: 0px; font-size: 14pt; }
        .nomor { text-align: center; margin-top: 0px; margin-bottom: 30px; }
        .content { margin-left: 20px; margin-right: 20px; }
        table.profile { margin-left: 30px; }
        table.profile td { padding-bottom: 5px; }
        table.profile td:first-child { width: 150px; }
        .ttd { width: 300px; float: right; text-align: center; margin-top: 50px; }
        .ttd-name { font-weight: bold; text-decoration: underline; margin-top: 80px; }
    </style>
</head>
<body>
    <div class="header">
        <h2>RUKUN TETANGGA 19 (RT 19)</h2>
        <h3>PERUMAHAN ORCHID REGENCY</h3>
        <p>Desa/Kelurahan Sidoarjo, Kecamatan Sidoarjo, Kabupaten Sidoarjo, Jawa Timur</p>
    </div>

    <div class="title"><?= strtoupper($surat->jenis_surat) ?></div>
    <div class="nomor">Nomor: <?= $surat->nomor_surat ?></div>

    <div class="content">
        <p>Yang bertanda tangan di bawah ini Ketua RT 19 Perumahan Orchid Regency Sidoarjo, menerangkan dengan sesungguhnya bahwa:</p>

        <table class="profile">
            <tr>
                <td>Nama Lengkap</td>
                <td>: <strong><?= strtoupper($surat->nama_lengkap) ?></strong></td>
            </tr>
            <tr>
                <td>NIK</td>
                <td>: <?= $surat->nik ?></td>
            </tr>
            <tr>
                <td>Tempat, Tgl Lahir</td>
                <td>: <?= $surat->tempat_lahir ?>, <?= date('d-m-Y', strtotime($surat->tanggal_lahir)) ?></td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>: <?= $surat->jenis_kelamin ?></td>
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>: <?= $surat->pekerjaan ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>: <?= $surat->alamat ?> RT <?= $surat->rt ?> / RW <?= $surat->rw ?></td>
            </tr>
        </table>

        <p>Adalah benar-benar warga yang berdomisili di RT 19 Perumahan Orchid Regency. Surat keterangan ini dibuat untuk keperluan:</p>
        <p style="text-align: center; font-weight: bold; font-style: italic;">" <?= $surat->keperluan ?> "</p>
        <p>Demikian surat keterangan ini dibuat agar dapat dipergunakan sebagaimana mestinya.</p>
    </div>

    <div class="ttd">
        Sidoarjo, <?= date('d F Y', strtotime($surat->updated_at ?: date('Y-m-d'))) ?><br>
        Ketua RT 19,<br>
        <br><br><br><br>
        <div class="ttd-name">Ketua RT-19</div>
    </div>
</body>
</html>
