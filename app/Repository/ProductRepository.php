<?php

namespace App\Repository;

use App\Product;

class ProductRepository
{
    public function getAllAvailable()
    {
        return Product::where("count", ">", "0")->get();
    }

    public function getById(int $id)
    {
        return Product::find($id);
    }
}