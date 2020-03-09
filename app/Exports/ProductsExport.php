<?php

namespace App\Exports;

use App\Product;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;

class ProductsExport implements FromQuery
{
    protected $products;

    public function __construct($products)
    {
        $this->products = $products;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function query()
    {
        return Product::query()->whereIn('id', $this->products);
    }
}
