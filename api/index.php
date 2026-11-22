<?php
if (isset($_GET['dbgx'])) {
    header('Content-Type: text/plain');
    print_r(array_intersect_key($_SERVER, array_flip(['REQUEST_URI','SCRIPT_NAME','PATH_INFO','QUERY_STRING','PHP_SELF','SCRIPT_FILENAME'])));
    echo "uploads dir ada: " . (is_dir('/var/task/user/uploads') ? 'ya' : 'tidak') . "\n";
    echo "isi root: " . implode(', ', array_slice(scandir('/var/task/user'), 2)) . "\n";
    exit;
}
chdir(__DIR__ . '/..');
require __DIR__ . '/../index.php';