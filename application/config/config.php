<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// Set timezone
date_default_timezone_set('Asia/Jakarta');

// ------------------------------------------------------------------------
// BASE URL DINAMIS - OTOMATIS MENYESUAIKAN DENGAN DOMAIN SAAT INI
// ------------------------------------------------------------------------
$protocol = 'http';
if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
    $protocol = 'https';
}
if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https') {
    $protocol = 'https';
}
$host = $_SERVER['HTTP_HOST'];
$path = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\') . '/';
$config['base_url'] = $protocol . '://' . $host . $path;
// ------------------------------------------------------------------------
// INDEX PAGE
// ------------------------------------------------------------------------
$config['index_page'] = '';

// ------------------------------------------------------------------------
// URI PROTOCOL
// ------------------------------------------------------------------------
$config['uri_protocol'] = 'REQUEST_URI';

// ------------------------------------------------------------------------
// URL SUFFIX
// ------------------------------------------------------------------------
$config['url_suffix'] = '';

// ------------------------------------------------------------------------
// LANGUAGE
// ------------------------------------------------------------------------
$config['language'] = 'english';

// ------------------------------------------------------------------------
// CHARACTER SET
// ------------------------------------------------------------------------
$config['charset'] = 'UTF-8';

// ------------------------------------------------------------------------
// HOOKS
// ------------------------------------------------------------------------
$config['enable_hooks'] = FALSE;

// ------------------------------------------------------------------------
// CLASS PREFIX
// ------------------------------------------------------------------------
$config['subclass_prefix'] = 'MY_';

// ------------------------------------------------------------------------
// COMPOSER AUTOLOAD
// ------------------------------------------------------------------------
$config['composer_autoload'] = FALSE;

// ------------------------------------------------------------------------
// ALLOWED URI CHARACTERS
// ------------------------------------------------------------------------
$config['permitted_uri_chars'] = 'a-z 0-9~%.:_\-';

// ------------------------------------------------------------------------
// ENABLE QUERY STRINGS
// ------------------------------------------------------------------------
$config['enable_query_strings'] = FALSE;
$config['controller_trigger'] = 'c';
$config['function_trigger'] = 'm';
$config['directory_trigger'] = 'd';

// ------------------------------------------------------------------------
// ALLOW GET ARRAY
// ------------------------------------------------------------------------
$config['allow_get_array'] = TRUE;

// ------------------------------------------------------------------------
// LOGGING
// ------------------------------------------------------------------------
$config['log_threshold'] = 0;
$config['log_path'] = '';
$config['log_file_extension'] = '';
$config['log_file_permissions'] = 0644;
$config['log_date_format'] = 'Y-m-d H:i:s';

// ------------------------------------------------------------------------
// ERROR VIEWS
// ------------------------------------------------------------------------
$config['error_views_path'] = '';

// ------------------------------------------------------------------------
// CACHE
// ------------------------------------------------------------------------
$config['cache_path'] = '';
$config['cache_query_string'] = FALSE;

// ------------------------------------------------------------------------
// ENCRYPTION KEY
// ------------------------------------------------------------------------
$config['encryption_key'] = 'TkaAppSecretKey2025!';

// ------------------------------------------------------------------------
// SESSION CONFIGURATION (Database)
// ------------------------------------------------------------------------
$config['sess_driver'] = 'database';
$config['sess_cookie_name'] = 'ci_session';
$config['sess_samesite'] = 'Lax';
$config['sess_expiration'] = 7200;        // 2 jam
$config['sess_save_path'] = 'ci_sessions'; // nama tabel sessions
$config['sess_match_ip'] = FALSE;
$config['sess_time_to_update'] = 300;      // 5 menit
$config['sess_regenerate_destroy'] = TRUE;

// ------------------------------------------------------------------------
// COOKIE SETTINGS
// ------------------------------------------------------------------------
$config['cookie_prefix'] = '';
$config['cookie_domain'] = '';
$config['cookie_path'] = '/';
$config['cookie_secure'] = FALSE;   // FALSE karena lokal HTTP, ngrok handle HTTPS
$config['cookie_httponly'] = TRUE;  // Keamanan: cookie tidak bisa diakses JS
$config['cookie_samesite'] = 'Lax';

// ------------------------------------------------------------------------
// OTHER SECURITY & STANDARDIZATION
// ------------------------------------------------------------------------
$config['standardize_newlines'] = FALSE;
$config['global_xss_filtering'] = TRUE;
$config['csrf_protection'] = TRUE;
$config['csrf_token_name'] = 'csrf_token_name';
$config['csrf_cookie_name'] = 'csrf_cookie_name';
$config['csrf_expire'] = 7200;
$config['csrf_regenerate'] = TRUE;   // Set FALSE jika sering konflik token antar tab
$config['compress_output'] = FALSE;
$config['time_reference'] = 'local';
$config['rewrite_short_tags'] = FALSE;
$config['proxy_ips'] = '';