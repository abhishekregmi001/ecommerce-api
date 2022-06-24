<?php

namespace App\Repositories;

use App\Interfaces\ProductRepositoryInterface;
use App\Models\Product;

class ProductRepository implements ProductRepositoryInterface 
{
    public function addProduct( $product)
    {
        return Product::create( $product);
    }
    public function updateProduct($product,$id)
    {
        return Product::whereId($id)->update($request);
    }
    public function Pdelete($id)
    {
        Product::destroy($id);
    }
    // public function searchProduct(Request $request)
    // {
    //     return Product::find($request);
    // }
    public function product_info($id)
    {
        return Product::find($id);
    }
}