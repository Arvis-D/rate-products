<?php

namespace App\Views\Pages;

use App\Views\View;
use App\Utilities\SessionMessage;

class Products extends View
{
    private $products = [];
    private $productView;
    public $title = 'Products';

    public function __construct()
    {
        $this->parent = 'Layouts\Master';
        $this->extendAs = 'content';
        $this->productView = self::get('Components\Product');
        $this->csrf = self::get('Components\Csrf');
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
        <div id="products">
            <?php foreach ($this->products as $product) {
                $this->productView->set($product)->show();
            } ?>
        </div>
        <form id="delete-products" method='post' class="nav-item" action="product/delete">
            <input id="id-arr" type="hidden" name="idArr" value="">
            <?php $this->csrf->show() ?>
        </form>
        <script src="/public/js/massDelete.js"></script>
        <?php
    }
}