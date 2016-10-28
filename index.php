<?php

require_once 'settings.php';
require_once 'functions.php';
require_once 'db.class.php';
require_once 'schedule.class.php';
require_once 'text.class.php';
require_once 'debug.php';

if(empty(ACCESS_TOKEN) && isset($_GET['code']))  {
    echo getToken();
    exit();
}

require_once 'view.php';
