<?php

use Config\Database;
use Config\Enviroment;

require_once '../vendor/autoload.php';

Enviroment::loadEnv();

$db = new Database();

$db = $db->connect();