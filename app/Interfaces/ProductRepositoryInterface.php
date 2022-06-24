<?php

namespace App\Interfaces;

interface ProductRepositoryInterface 
{
    public function addProduct( $product);
    public function updateProduct($product,$id);
    public function Pdelete($id);
    // public function searchProduct(Request $request);
    public function product_info($id);
}