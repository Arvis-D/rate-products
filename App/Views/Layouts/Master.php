<?php 

namespace App\Views\Layouts;

use App\Views\View;

class Master extends View
{
    public function render()
    {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta http-equiv="X-UA-Compatible" content="ie=edge">
            <title><?= $data['title'] ?? $_SERVER['REQUEST_URI'] ?></title>
            <link href="https://fonts.googleapis.com/css?family=Roboto:300&display=swap" rel="stylesheet">
            <link href="/public/styles/style.css" rel="stylesheet">
        </head>
        <body>
            <?php $this->child('content')->show() ?>
        </body>
        </html>
        <?php
    }
}