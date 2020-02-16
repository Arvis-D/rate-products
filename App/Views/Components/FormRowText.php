<?php

namespace App\Views\Components;

use App\Views\View;
use App\Utilities\SessionMessage;

class FormRowText extends View
{
    private $name = '';
    private $required = false;
    private $label = '';
    private $errors = '';
    private $old = '';

    public function __construct()
    {
        $this->errors = SessionMessage::get('inputErrors') ?? null;
        $this->old = SessionMessage::get('inputOld') ?? null;
    }

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
        <div class="input">
            <input 
                <?= (isset($this->errors[$this->name]) ? 'class="error"' : '') ?> 
                type="text"
                value = "<?= $this->old[$this->name] ?? '' ?>"
                id="<?=$this->name?>" 
                name="<?=$this->name?>" 
                <?= ($this->required ? 'required' : '') ?>>

            <?php if(isset($this->errors[$this->name])): ?>
                <div class="input-error"><?=$this->errors[$this->name]?></div>
            <?php endif ?>

        </div>
        <label for="<?= $this->name ?>" > <?=$this->label?> </label>
        </div>
        <?php
    }
}