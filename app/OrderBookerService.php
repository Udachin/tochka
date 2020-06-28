<?php

namespace App;

use App\Repository\ProductRepository;
use Illuminate\Database\DatabaseManager;

class OrderBookerService
{
    /**
     * @var DatabaseManager
     */
    private $databaseManager;

    /**
     * @var ProductRepository
     */
    private $productRepository;

    public function __construct(ProductRepository $productRepository, DatabaseManager $databaseManager)
    {
        $this->productRepository = $productRepository;
        $this->databaseManager   = $databaseManager;
    }

    public function book(OrderInfo $orderInfo, ProductRequests $productRequests): int
    {
        $order              = new Order();
        $order->first_name  = $orderInfo->firstName;
        $order->last_name   = $orderInfo->lastName;
        $order->middle_name = $orderInfo->middleName;
        $order->phone       = $orderInfo->phone;
        $order->email       = $orderInfo->email;

        $this->databaseManager->transaction(function () use ($order, $productRequests) {
            $requestedProductIds  = $productRequests->getAllProductId();
            $currentProductCounts = $this->productRepository->getByIdList($requestedProductIds);

            foreach ($currentProductCounts as $currentProduct) {
                $currentProductId      = $currentProduct->id;
                $currentProductCount   = $currentProduct->count;
                $requestedProductCount = $productRequests->getByProductId($currentProductId)->count;
                if ($requestedProductCount > $currentProductCount) {
                    throw new \Exception("Текущее доступное число товаров '$currentProductCount' для id = '$currentProductId', запрошено '$requestedProductCount'");
                }

                $this->productRepository->decreaseCount($currentProductId, $requestedProductCount);

                $orderData            = new OrderData();
                $orderData->productId = $currentProductId;
                $orderData->count     = $currentProductCount;
                $orderData->price     = $currentProductCount * $currentProduct->price;
                $data[]               = $orderData;
            }

            $order->data = $data;
            $order->save();
        });

        return $order->id;
    }
}