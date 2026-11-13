<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	https://codeigniter.com/userguide3/general/hooks.html
|
*/

/**
 * Pre-Controller Hook
 * Set bahasa dari session sebelum controller di-load
 */
$hook['pre_controller'][] = array(
    'function' => 'set_language',
    'filename' => 'LanguageHook.php',
    'filepath' => 'hooks'
);

/**
 * LanguageHook function
 * Membaca bahasa dari session dan set ke CI config
 */
