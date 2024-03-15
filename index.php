<?php
require 'vendor/autoload.php';
$availabeRoutes = ['chatbot'];

$route = 'chatbot';

if (isset($_GET['page']) && in_array($_GET['page'], $availabeRoutes)) {
  $route = $_GET['page'];
};

