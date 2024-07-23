<?php

$header = $data['loadpage']['header'] ?? null;
$footer = $data['loadpage']['footer'] ?? null;
$bookingForm = $data['loadpage']['bookingForm'] ?? null;
$comments = $data['loadpage']['comments'] ?? null;

require_once APPROOT . '/views/user/includes/header.php';

require_once APPROOT . '/views/user/pages/' . $page;

require_once APPROOT . '/views/user/includes/footer.php';
