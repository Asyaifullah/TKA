<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$route['default_controller'] = 'auth/login';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

// Approval
$route['approval'] = 'approval/index';
$route['approval/(:any)'] = 'approval/$1';
$route['user/perbaiki_tka/(:num)'] = 'user/perbaiki_tka/$1';
//verifikasi
$route['auth/otp_form'] = 'auth/otp_form';
$route['auth/verify_otp'] = 'auth/verify_otp';
$route['auth/resend_otp'] = 'auth/resend_otp';
$route['auth/forgot_password'] = 'auth/forgot_password';
$route['auth/verify_security'] = 'auth/verify_security';
$route['auth/check_security_answer'] = 'auth/check_security_answer';
$route['auth/reset_password'] = 'auth/reset_password';
$route['auth/do_reset_password'] = 'auth/do_reset_password';
//operator
$route['operator/dashboard'] = 'operator/dashboard';
$route['operator/semua_tka'] = 'operator/semua_tka';
$route['operator/detail_tka/(:num)'] = 'operator/detail_tka/$1';
$route['operator/edit_nomor_surat/(:num)'] = 'operator/edit_nomor_surat/$1';
$route['operator/update_nomor_surat/(:num)'] = 'operator/update_nomor_surat/$1';
$route['operator/download_surat_word/(:num)'] = 'operator/download_surat_word/$1';
$route['operator/kirim_notifikasi'] = 'operator/kirim_notifikasi';
$route['operator/kirim_notifikasi_action'] = 'operator/kirim_notifikasi_action';
$route['operator/edit_nomor_surat/(:num)'] = 'operator/edit_nomor_surat/$1';
$route['operator/update_nomor_surat/(:num)'] = 'operator/update_nomor_surat/$1';
$route['admin/export_tka_xlsx'] = 'Admin/export_tka_xlsx';
$route['admin/export_perusahaan_xlsx'] = 'Admin/export_perusahaan_xlsx';
//admin
$route['admin/toggle_officer_status/(:num)'] = 'admin/toggle_officer_status/$1';
$route['admin/delete_officer/(:num)']        = 'admin/delete_officer/$1';
$route['admin/reset_officer_password/(:num)']= 'admin/reset_officer_password/$1';
$route['admin/officers'] = 'admin/officers';
$route['admin/dashboard'] = 'admin/dashboard';

$route['login'] = 'auth/login';
$route['do-login'] = 'auth/do_login';

$route['register'] = 'auth/register';
$route['do-register'] = 'auth/do_register';

$route['logout'] = 'auth/logout';

$route['dashboard'] = 'dashboard/index';

