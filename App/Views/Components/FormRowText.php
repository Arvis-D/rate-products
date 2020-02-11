<?php

namespace App\Views\Components;

use App\Views\View;

class FormRowText extends View
{
    use \App\Traits\SessionMessageTrait;

    private $name = '';
    private $required = false;
    private $label = '';

    public function set($name, $label, $required = false)
    {
        $this->name = $name;
        $this->label = $label;
        $this->required = $required;
        return $this;
    }

    protected function render()
    {
        ?>
        <div class="form-row ">
        <input class="dynamic-input" type="text"
            id="<?=$this->name?>" 
            name="<?=$this->name?>" 
            <?= ($this->required ? 'required' : '') ?>>
        <label for="<?= $this->name ?>" > <?=$this->label?> </label>
        </div>
        <?php
    }
}