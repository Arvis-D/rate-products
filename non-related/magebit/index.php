<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="frontend/css.css">
    <link rel="shortcut icon" href="frontend/images/logo.png">
    <title>Magebit login</title>
</head>
<body>

<?php
session_start();
include_once "backend/autoload.php";
$route = new Router($_SERVER["REQUEST_URI"]);
$route->url();
?>

<footer>
  <h4>Made by Arvis</h4>
</footer>

</body>
</html>