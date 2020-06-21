<?php

namespace App;

use App\Casts\OrderDataJson;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = "order";

    protected $casts = [
        "data" => OrderDataJson::class,
    ];

    protected $fillable = [
        "firstName",
        "lastName",
        "middleName",
        "email",
        "phone",
        "orders",
    ];
}
