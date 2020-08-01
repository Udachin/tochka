<?php

namespace App\Http\Controllers;

use App\Repository\ProductRepository;
use Illuminate\Http\Request;
use Illuminate\Redis\RedisManager;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductRepository $repository)
    {
        $availableProducts = $repository->getAllAvailable();
        return \App\Http\Resources\Product::collection($availableProducts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, ProductRepository $repository, RedisManager $redis)
    {
        $cachedProduct = $redis->connection()->get('product.' . $id);

        if ($cachedProduct) {
            $product = unserialize($cachedProduct);
        } else {
            $product = $repository->getById($id);
            $cachedProduct = serialize($product);
            $redis->connection()->set('product.' . $id, $cachedProduct, 180);
        }

        if ($product) {
            return new \App\Http\Resources\Product($product);
        }
        throw new \Exception("Продукта с указанным id не существует");
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
