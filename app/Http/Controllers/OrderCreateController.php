<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\Order;
use App\OrderData;
use Illuminate\Support\Facades\DB;

class OrderCreateController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrderRequest $request)
    {
        $validatedData = (object)$request->validated();

        // map order
        $order              = new Order();
        $order->first_name  = $validatedData->firstName;
        $order->last_name   = $validatedData->lastName;
        $order->middle_name = $validatedData->middleName;
        $order->phone       = $validatedData->phone;
        $order->email       = $validatedData->email;

        $requestProductIdCounts = [];
        foreach ($validatedData->orders as $requestOrder) {
            $requestProductIdCounts[$requestOrder["id"]] = $requestOrder["count"];
        }

        DB::transaction(function () use ($order, $requestProductIdCounts) {
            $ids           = join(',', array_keys($requestProductIdCounts));
            $currentCounts = DB::select("SELECT id, count, price FROM product WHERE id IN ($ids)");

            foreach ($currentCounts as $currentProduct) {
                $currentProductId      = $currentProduct->id;
                $currentProductCount   = $currentProduct->count;
                $requestedProductCount = $requestProductIdCounts[$currentProductId];
                if ($requestedProductCount > $currentProductCount) {
                    throw new \Exception("Текущее доступное число товаров '$currentProductCount' для id = '$currentProductId', запрошено '$requestedProductCount'");
                }

                DB::update("UPDATE product SET count = count - :count WHERE id = :id", ["count" => $requestedProductCount, "id" => $currentProductId]);

                $orderData            = new OrderData();
                $orderData->productId = $currentProductId;
                $orderData->count     = $currentProductCount;
                $orderData->price     = $currentProductCount * $currentProduct->price;
                $data[]               = $orderData;
            }

            $order->data = $data;
            $order->save();
        });

        return response()->json([
            'orderId' => $order->id,
            'status'  => 'success',
        ]);
    }
}
