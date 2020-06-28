<?php

namespace App;

class OrderInfoMapper
{
    public static function map(Http\Requests\CreateOrderRequest $request): OrderInfo
    {
        $orderInfo             = new OrderInfo();
        $orderInfo->firstName  = $request->firstName;
        $orderInfo->lastName   = $request->lastName;
        $orderInfo->middleName = $request->middleName;
        $orderInfo->phone      = $request->phone;
        $orderInfo->email      = $request->email;

        return $orderInfo;
    }
}