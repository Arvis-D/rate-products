<?php

namespace App\Views\Components;

use App\Views\View;

class Csrf extends View
{
    protected function render()
    {
        ?>
        <input type="hidden" value="<?= $_SESSION['csrf'] ?>" name="csrf">
        <?php
    }
}