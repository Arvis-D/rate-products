<?php

namespace App\Views\Pages;

use App\Views\View;

class CreateProduct extends View
{
    private $csrf;
    private $formRowText;

    public function __construct()
    {
        $this->parent = 'Layouts\Master';
        $this->extendAs = 'content';
        $this->csrf = self::get('Components\Csrf');
        $this->formRowText = self::get('Components\FormRowText');
    }

    protected function render()
    {
        ?>
        <nav>
        <div class="nav-items">
            <a class="nav-item" href="/">Products</a>
            <a class="nav-item active" href="/product/add">Add a product</a>
            <button form="create-product" class="btn" type="submit">Save</button>
        </div>
        </nav>

        <form method="post" class="form" id="create-product" action="/product/store">
            <?php 
            $this->csrf->show(); 
            $this->formRowText->set('sku', 'Product SKU', true)->show();
            $this->formRowText->set('name', 'Product name', true)->show(); 
            $this->formRowText->set('price', 'Product price', true)->show();  
            ?>
        <div class="form-row">
            <select id="type" name="type" form="create-product" class="type-select">
            <option value="Furniture">Furniture</option>
            <option value="CD">CD</option>
            <option value="Book">Book</option>
            </select>
            <label for="type">Product type:</label>
        </div>

        <div class="dynamic-part" id="dynamic-furniture">
            <?php  
            $this->formRowText->set('height', 'Height', true)->show();
            $this->formRowText->set('width', 'Width', true)->show(); 
            $this->formRowText->set('length', 'Length', true)->show();  
            ?>
        </div>

        <div class="dynamic-part" id="dynamic-cd">
            <?php $this->formRowText->set('size', 'Size', true)->show(); ?>
        </div>

        <div class="dynamic-part" id="dynamic-book">
            <?php $this->formRowText->set('book', 'Weight', true)->show(); ?>
        </div>

        </form>

        <script src="/public/js/dynamicForm.js"></script>
        <?php
    }
}