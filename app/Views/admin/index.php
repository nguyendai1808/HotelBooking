<?php
if ($page != 'loginAdmin.php') {

    require_once APPROOT . '/views/admin/includes/header.php';

    require_once APPROOT . '/views/admin/' . $page;

    require_once APPROOT . '/views/admin/includes/footer.php';
} else {

    require_once APPROOT . '/views/admin/loginAdmin.php';
}
