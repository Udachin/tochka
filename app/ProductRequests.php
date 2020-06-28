<?php

namespace App;

class ProductRequests
{
    /**
     * @var ProductRequest[]
     */
    private $requests = [];

    public function add(ProductRequest $request): void
    {
        $this->requests[$request->id] = $request;
    }

    public function getByProductId(int $id): ?ProductRequest
    {
        return $this->requests[$id] ?? null;
    }

    /**
     * @return ProductRequest[]
     */
    public function getAll(): array
    {
        return $this->requests;
    }

    /**
     * @return int[]
     */
    public function getAllProductId(): array
    {
        return array_keys($this->requests);
    }
}