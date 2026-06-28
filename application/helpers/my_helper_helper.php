<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Format Rupiah
 */
if (!function_exists('rupiah')) {
    function rupiah($angka) {
        return 'Rp ' . number_format($angka, 0, ',', '.');
    }
}

/**
 * Format Tanggal Indonesia
 */
if (!function_exists('tgl_indo')) {
    function tgl_indo($tanggal) {
        if (empty($tanggal)) return '-';
        $bulan = array(
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        );
        $split = explode('-', date('Y-m-d', strtotime($tanggal)));
        return $split[2] . ' ' . $bulan[(int)$split[1]] . ' ' . $split[0];
    }
}

/**
 * Nama Bulan Indonesia
 */
if (!function_exists('nama_bulan')) {
    function nama_bulan($bulan) {
        $nama = array(
            1 => 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        );
        return isset($nama[(int)$bulan]) ? $nama[(int)$bulan] : '';
    }
}

/**
 * Check role access
 */
if (!function_exists('cek_akses')) {
    function cek_akses($allowed_roles = array()) {
        $CI =& get_instance();
        $role_id = $CI->session->userdata('role_id');
        if (!in_array($role_id, $allowed_roles)) {
            redirect('dashboard');
        }
    }
}

/**
 * Active menu helper
 */
if (!function_exists('active_menu')) {
    function active_menu($controller, $method = '') {
        $CI =& get_instance();
        $active = ($CI->router->fetch_class() == $controller);
        if (!empty($method)) {
            $active = $active && ($CI->router->fetch_method() == $method);
        }
        return $active ? 'active' : '';
    }
}

/**
 * Menu open helper
 */
if (!function_exists('menu_open')) {
    function menu_open($controllers = array()) {
        $CI =& get_instance();
        return in_array($CI->router->fetch_class(), $controllers) ? 'menu-open' : '';
    }
}

/**
 * Generate Nomor Surat
 */
if (!function_exists('generate_nomor_surat')) {
    function generate_nomor_surat($id, $jenis) {
        $kode = '';
        switch ($jenis) {
            case 'Surat Keterangan Domisili': $kode = 'SKD'; break;
            case 'Surat Pengantar SKCK': $kode = 'SKCK'; break;
            case 'Surat Pengantar Nikah': $kode = 'SPN'; break;
            case 'Surat Keterangan Tidak Mampu': $kode = 'SKTM'; break;
            case 'Surat Keterangan Usaha': $kode = 'SKU'; break;
            default: $kode = 'SRT'; break;
        }
        return sprintf('%03d/%s/RT19/%s/%s', $id, $kode, date('m'), date('Y'));
    }
}

/**
 * Time ago
 */
if (!function_exists('time_ago')) {
    function time_ago($datetime) {
        $now = new DateTime();
        $ago = new DateTime($datetime);
        $diff = $now->diff($ago);

        if ($diff->y > 0) return $diff->y . ' tahun lalu';
        if ($diff->m > 0) return $diff->m . ' bulan lalu';
        if ($diff->d > 0) return $diff->d . ' hari lalu';
        if ($diff->h > 0) return $diff->h . ' jam lalu';
        if ($diff->i > 0) return $diff->i . ' menit lalu';
        return 'Baru saja';
    }
}

/**
 * Status badge
 */
if (!function_exists('status_badge')) {
    function status_badge($status) {
        $badges = array(
            'Lunas' => 'success',
            'Belum Bayar' => 'danger',
            'Diajukan' => 'info',
            'Diproses' => 'warning',
            'Selesai' => 'success',
            'Ditolak' => 'danger',
        );
        $class = isset($badges[$status]) ? $badges[$status] : 'secondary';
        return '<span class="badge badge-' . $class . '">' . $status . '</span>';
    }
}
