<?php
require('../vendor/autoload.php');

use Protobellum\Demo;
use Protobellum\Army;

session_start();

header('Content-Type: application/json');

$war    = $_GET['war'];
$demo   = isset($_SESSION[$war]) ? $_SESSION[$war] : new Demo();

$demo->doBattle();

$_SESSION[$war] = $demo;
