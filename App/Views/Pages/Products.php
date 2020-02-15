<?php

namespace App\Views\Pages;

use App\Views\View;

class Products extends View
{
    private $products = [];
    public $title = 'Products';

    public function __construct()
    {
        $this->parent = 'Layouts\Master';
        $this->extendAs = 'content';
    }

    public function set($products)
    {
        $this->products = $products;
        return $this;
    }

    protected function render()
    {
        ?>
        <nav>
            <div class="nav-items">
                <a class="nav-item active" href="/">Products</a>
                <a class="nav-item" href="/product/add">Add a product</a>
                <button form="delete-products" class="btn btn-danger" type="submit">Delete selected</button>
            </div>
        </nav>
        <form id="delete-products" class="nav-item" action="product/delete">
            <input id="id-arr" type="hidden" name="idArr" value="">
        </form>
        <script src="/public/js/massDelete.js"></script>
        <?php
    }
}