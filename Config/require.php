<?php

require_once './Core/App.php';
require_once './Core/Controller.php';
require_once './Core/Database.php';
require_once './Core/Session.php';
require_once './Core/LoadPage.php';

require_once './Core/Pagination.php';
require_once './Core/Validate.php';
require_once './Core/Mail.php';

require_once 'config.php';

Session::start();

$init = new App();
