<?php

require_once './core/App.php';
require_once './core/Controller.php';
require_once './core/Database.php';
require_once './core/Session.php';
require_once './core/LoadPage.php';

require_once './core/Pagination.php';
require_once './core/Validate.php';
require_once './core/Mail.php';

require_once 'config.php';

Session::start();

$init = new App();
