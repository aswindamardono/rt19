<?php
defined('BASEPATH') OR exit('No direct script access allowed');
$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Landing publik
$route['home'] = 'home';
$route['info/struktur'] = 'home/struktur';
$route['info/pengumuman'] = 'home/pengumuman';
$route['info/inventaris'] = 'home/inventaris';
$route['struktur-organisasi'] = 'home/struktur';

// Auth
$route['login'] = 'auth/login';
$route['logout'] = 'auth/logout';
$route['register'] = 'auth/register';

// Dashboard
$route['dashboard'] = 'dashboard';

// Warga
$route['warga'] = 'warga';
$route['warga/tambah'] = 'warga/tambah';
$route['warga/edit/(:num)'] = 'warga/edit/$1';
$route['warga/hapus/(:num)'] = 'warga/hapus/$1';
$route['warga/detail/(:num)'] = 'warga/detail/$1';
$route['warga/import'] = 'warga/import';
$route['warga/export_excel'] = 'warga/export_excel';
$route['warga/export_pdf'] = 'warga/export_pdf';
$route['warga/datatable'] = 'warga/datatable';

// Keuangan
$route['keuangan'] = 'keuangan';
$route['keuangan/pemasukan'] = 'keuangan/pemasukan';
$route['keuangan/pengeluaran'] = 'keuangan/pengeluaran';
$route['keuangan/laporan'] = 'keuangan/laporan';
$route['keuangan/export_pdf'] = 'keuangan/export_pdf';
$route['keuangan/export_excel'] = 'keuangan/export_excel';

// Iuran
$route['iuran'] = 'iuran';
$route['iuran/bayar/(:num)'] = 'iuran/bayar/$1';
$route['iuran/tunggakan'] = 'iuran/tunggakan';
$route['iuran/generate'] = 'iuran/generate';

// Surat
$route['surat'] = 'surat';
$route['surat/ajukan'] = 'surat/ajukan';
$route['surat/proses/(:num)'] = 'surat/proses/$1';
$route['surat/download/(:num)'] = 'surat/download/$1';
$route['surat/cetak/(:num)'] = 'surat/cetak/$1';

// Pengumuman
$route['pengumuman'] = 'pengumuman';
$route['pengumuman/tambah'] = 'pengumuman/tambah';
$route['pengumuman/edit/(:num)'] = 'pengumuman/edit/$1';
$route['pengumuman/detail/(:num)'] = 'pengumuman/detail/$1';

// Struktur Organisasi
$route['struktur'] = 'struktur';
$route['struktur/tambah'] = 'struktur/tambah';
$route['struktur/edit/(:num)'] = 'struktur/edit/$1';
$route['struktur/hapus/(:num)'] = 'struktur/hapus/$1';
$route['struktur/toggle/(:num)'] = 'struktur/toggle/$1';

// User Management
$route['user'] = 'user';
$route['user/tambah'] = 'user/tambah';
$route['user/edit/(:num)'] = 'user/edit/$1';
$route['user/profil'] = 'user/profil';

// Notifikasi
$route['notifikasi'] = 'notifikasi';
$route['notifikasi/baca/(:num)'] = 'notifikasi/baca/$1';

// Google Sheets
$route['google_sheets/sync'] = 'google_sheets/sync';

// API
$route['api/dashboard_stats'] = 'api/dashboard_stats';
$route['api/chart_keuangan'] = 'api/chart_keuangan';
