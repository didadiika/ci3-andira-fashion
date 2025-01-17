<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route["login-super"] = "login/login_super";
$route["maintenance"] = "maintenance";

/* ROUTE SUPERADMIN */
$route["setting/langganan"] = "setting/langganan";
$route["setting/setting-backup"] = "setting/setting_backup";
$route["setting/setting-maintenance"] = "setting/setting_maintenance";


#ROUTES DIKA#
$route["produksi/kain"] = "produksi/kain";
$route["produksi/kain/input"] = "produksi/kain_input";
$route["produksi/kain/edit/(:any)"] = "produksi/kain_edit/$1";

$route["produksi/pemotong"] = "produksi/pemotong";
$route["produksi/pemotong/input"] = "produksi/pemotong_input";
$route["produksi/pemotong/edit/(:any)"] = "produksi/pemotong_edit/$1";

$route["produksi/penjahit"] = "produksi/penjahit";
$route["produksi/penjahit/input"] = "produksi/penjahit_input";
$route["produksi/penjahit/edit/(:any)"] = "produksi/penjahit_edit/$1";

$route["produksi/produksi"] = "produksi/produksi";
$route["produksi/daftar-produksi"] = "produksi/daftar_produksi";
$route["produksi/produksi/tambah-penjahit/(:any)"] = "produksi/produksi_tambah_penjahit/$1";
$route["produksi/produksi/setor-barang/(:any)/(:any)"] = "produksi/produksi_setor_barang/$1/$2";
$route["produksi/produksi/lihat-produksi/(:any)"] = "produksi/produksi_lihat_produksi/$1";

$route["produksi/laporan-produksi"] = "produksi/laporan_produksi";

$route["pembelian/toko"] = "pembelian/toko";
$route["pembelian/toko/input"] = "pembelian/toko_input";
$route["pembelian/toko/edit/(:any)"] = "pembelian/toko_edit/$1";

$route["pembelian/pembelian"] = "pembelian/pembelian";
$route["pembelian/pembelian/input"] = "pembelian/pembelian_input";
$route["pembelian/pembelian/edit/(:any)"] = "pembelian/pembelian_edit/$1";
$route["pembelian/pembelian/lihat/(:any)"] = "pembelian/pembelian_lihat/$1";
$route["pembelian/laporan-pembelian"] = "pembelian/laporan_pembelian";

$route["barang/barang"] = "barang/barang";
$route["barang/barang/input"] = "barang/barang_input";
$route["barang/barang/lihat/(:any)"] = "barang/barang_lihat/$1";
$route["barang/barang/edit/(:any)"] = "barang/barang_edit/$1";
$route["barang/barang-masuk"] = "barang/barang_masuk";
$route["barang/barang-masuk/input/(:any)"] = "barang/barang_masuk_input/$1";
$route["barang/barang-keluar"] = "barang/barang_keluar";
$route["barang/barang-keluar/input/(:any)"] = "barang/barang_keluar_input/$1";
$route["barang/stok-barang"] = "barang/stok_barang";
$route["barang/laporan-stok"] = "barang/laporan_stok";
$route["pembelian/laporan-pembelian"] = "pembelian/laporan_pembelian";

$route["penjualan/pelanggan"] = "penjualan/pelanggan";
$route["penjualan/pelanggan/input"] = "penjualan/pelanggan_input";
$route["penjualan/pelanggan/edit/(:any)"] = "penjualan/pelanggan_edit/$1";

$route["penjualan/penjualan"] = "penjualan/penjualan";
$route["penjualan/penjualan/input"] = "penjualan/penjualan_input";
$route["penjualan/penjualan/edit/(:any)"] = "penjualan/penjualan_edit/$1";
$route["penjualan/penjualan/lihat/(:any)"] = "penjualan/penjualan_lihat/$1";
$route["penjualan/daftar-penjualan"] = "penjualan/daftar_penjualan";
$route["penjualan/laporan-penjualan"] = "penjualan/laporan_penjualan";
$route["penjualan/simpan-penjualan/(:any)"] = "penjualan/simpan_penjualan/$1";
$route["penjualan/get-data-nota"] = "penjualan/get_data_nota";
$route["penjualan/simpan-pembayaran"] = "penjualan/simpan_pembayaran";

$route["akun/ganti-password"] = "akun/ganti_password";
$route["akun/tentang-software"] = "akun/tentang_software";