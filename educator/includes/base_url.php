<?php
$protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
$base_url = $protocol . $_SERVER['HTTP_HOST'] . '/ki/KI_Management_System/';

// Make it a global constant
define('BASE_URL', $base_url);



?>