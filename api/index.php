<?php
if (isset($_GET['dbg'])) {
    header('Content-Type: text/plain');
    print_r(array_intersect_key($_SERVER, array_flip(['REQUEST_URI','SCRIPT_NAME','PATH_INFO','QUERY_STRING','PHP_SELF','SCRIPT_FILENAME'])));
    exit;
}
chdir(__DIR__ . '/..');
require __DIR__ . '/../index.php';