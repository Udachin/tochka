<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateOrderRequest;
use App\LogFacade;
use App\OrderBookerService;
use App\OrderInfoMapper;
use App\ProductRequest;
use App\ProductRequests;

class OrderCreateController extends Controller
{
    /**
     * @var OrderBookerService
     */
    private $orderBookerService;

    public function __construct(OrderBookerService $orderBookerService)
    {
        $this->orderBookerService = $orderBookerService;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateOrderRequest $request)
    {
        LogFacade::info('Создание заказа');
        $request->validated();

        $orderInfo = OrderInfoMapper::map($request);

        $productRequests = new ProductRequests();
        foreach ($request->orders as $requestOrder) {
            $productRequest        = new ProductRequest();
            $productRequest->id    = $requestOrder["id"];
            $productRequest->count = $requestOrder["count"];
            $productRequests->add($productRequest);
        }

        $orderId = $this->orderBookerService->book($orderInfo, $productRequests);

        return response()->json([
            'orderId' => $orderId,
            'status'  => 'success',
        ]);
    }
}
