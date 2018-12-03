<?php
require "config.php";
global $pdo_dsn,$pdo_user,$pdo_pass;
$pdo = new PDO($pdo_dsn, $pdo_user, $pdo_pass);;