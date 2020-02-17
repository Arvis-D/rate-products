<?php

namespace App\Views\Components;

use App\Views\View;

class Product extends View
{
    private $name;
    private $sku;
    private $price;
    private $type;
    private $attrUnit;
    private $attributes = [];

    public function set($data)
    {
        $this->name = $data['name'];
        $this->sku = "#{$data['sku']}";
        $this->price = number_format($data['price'], 2 , ',', ' ') . '€';
        $this->type = $data['type'];
        $this->attributes = (array) json_decode($data['attributes']);
        $this->id = $data['id'];

        $unit = '';
        switch ($this->type) {
            case 'book':
                $unit = 'KG';
                break;
            case 'furniture':
                $unit = 'mm';
                break;
            case 'cd':
                $unit = 'MB';
                break;
        }
        $this->attrUnit = $unit;

        return $this;
    }

    protected function render()
    {
        ?>
        <div class="product">
            <input class="delete-checkbox" type="checkbox" name="<?=$this->id?>">
            <h3><?=$this->name?></h3>
            <p class="sku"><?=$this->sku?></p>
            <p class="type"><span>Type: </span><?=$this->type?></p>

            <?php foreach($this->attributes as $key => $attribute): ?>
            <p class="attribute"><span><?=ucfirst($key)?>: </span><?=$attribute?><?=$this->attrUnit?></p>
            <?php endforeach ?>

            <p class="price"><?=$this->price?></p>
        </div>
        <?php
    }
}