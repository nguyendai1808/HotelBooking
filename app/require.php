<?php
require_once './app/Core/App.php';
require_once './app/Core/Controller.php';
require_once './app/Core/Database.php';
require_once './app/Core/Session.php';
require_once './app/Core/Pagination.php';
require_once './app/Core/LoadPage.php';
require_once './app/Core/PaymenVnpay.php';
require_once './app/Core/Mail.php';

require_once './app/PHPMailer/Exception.php';
require_once './app/PHPMailer/PHPMailer.php';
require_once './app/PHPMailer/SMTP.php';

require_once './app/Config/config.php';

$init = new App();
