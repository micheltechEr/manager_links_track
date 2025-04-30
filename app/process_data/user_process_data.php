<?php
require_once __DIR__ . '/../controller/UserController.php';

$data = new UserController();
$data->registerUser();
?>