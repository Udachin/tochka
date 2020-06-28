<?php

namespace App\Repository;

use App\Product;
use Illuminate\Database\DatabaseManager;

class ProductRepository
{
    /**
     * @var DatabaseManager
     */
    public $databaseManager;

    public function __construct(DatabaseManager $databaseManager)
    {
        $this->databaseManager = $databaseManager;
    }

    public function getAllAvailable()
    {
        return Product::where("count", ">", "0")->get();
    }

    public function getById(int $id)
    {
        return Product::find($id);
    }

    public function getByIdList(array $ids)
    {
        return Product::whereIn('id', $ids)->get();
    }

    public function decreaseCount(int $currentProductId, int $requestedProductCount)
    {
        $this->databaseManager->update(
            "UPDATE product SET count = count - :count WHERE id = :id",
            [
                "count" => $requestedProductCount,
                "id"    => $currentProductId,
            ]
        );
    }
}