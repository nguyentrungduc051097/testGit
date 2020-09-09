<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductCtrl extends Controller {
    private $product;
    public function __construct(Product $product) {
        $this->product = $product;
    }

    public function index() {
        $listProduct = $this->product->all();
        return response()->json($listProduct);
    }

    public function store() {
        
    }
}
