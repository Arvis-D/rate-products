<?php 

class ProductsView
{
    private $data = 'sadasdasdasd';
    private $parent = 'MasterView';
    public $extendAs = 'content';

    public function show()
    {   
        new $this->parent()
    }

    public function render()
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
        <?= $this->data ?>
        <script src="/public/js/massDelete.js"></script>
        <?php
    }
}


$n = new ProductsView;


$n->render();