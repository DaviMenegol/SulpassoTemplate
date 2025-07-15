<?php
$dbUser = 'root';
$dbServer = 'localhost';
$dbDatabase = 'webmobile';
$dbPassword = '';

// $dbUser = '~';
// $dbServer = '~~';
// $dbDatabase = '~~';
// $dbPassword = '~~';

$connection = new mysqli($dbServer,$dbUser,$dbPassword,$dbDatabase);
