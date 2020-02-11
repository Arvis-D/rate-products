<?php


$password = "sasdasdasdasdasdasd";
$password = password_hash($password, PASSWORD_DEFAULT);
echo $password. "  " . strlen($password);