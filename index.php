<?php

require_once 'settings.php';
require_once 'functions.php';

if(empty(ACCESS_TOKEN) && isset($_GET['code']))  {
    echo getToken();
    exit();
}

require_once 'view.php';
