<?php

namespace App\Imports;

use App\Product;
use App\Propertyvalue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Illuminate\Support\Str;

class ProductsUpdate implements ToCollection 
{
    protected $startLine;
    protected $lastLine;
    protected $columns = [];
    protected $collection;

    public function __construct($startLine = 1, $columns = ['autoscu' => '2'], $lastLine = NULL) {
        $this->startLine = $startLine;
        $this->lastLine = $lastLine;
        $this->columns = $columns;
    }

    public function collection(Collection $rows){
        foreach ($rows as $key => $row) 
        {
            if ($this->lastLine && $key == $this->lastLine) {
                break;
            }
            if ($key >= $this->startLine) {
                $product = Product::where($this->columns['scu_type'], $row[$this->columns['column_scu']-1])->first();
                // dd($key, $row[$this->columns['column_scu']-1], $this->columns['scu_type'], $this->columns['column_scu'], $product);

                if ($product) {
                    // dd($this->columns);

                    if ($this->columns['column_product'] && $row[$this->columns['column_product']-1]) {
                        $product->product = $row[$this->columns['column_product']-1];
                    }

                    if ($this->columns['scu'] && $row[$this->columns['scu']-1]) {
                        $product->scu = $row[$this->columns['scu']-1];
                    }

                    if ($row[$this->columns['column_price']-1]) {
                        $product->price = $row[$this->columns['column_price']-1];
                    }
                    
                    // if ($row[$this->columns['column_incomin_price']-1]) {
                    //     $product->incomin_price = $row[$this->columns['column_incomin_price']-1];
                    // }

                    // dd($product);
                    $product->update();
                }
                                            
            }            
        }        
    }
}