<?php
if ($page != 'loginAdmin.php') {
    
    $header = $data['loadpage']['header'] ?? null;
    $footer = $data['loadpage']['footer'] ?? null;

    require_once APPROOT . '/views/admin/includes/header.php';

    require_once APPROOT . '/views/admin/' . $page;

    require_once APPROOT . '/views/admin/includes/footer.php';
} else {

    require_once APPROOT . '/views/admin/loginAdmin.php';
}
