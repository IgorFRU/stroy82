<?php

namespace App\Imports;

use App\Product;
use App\Propertyvalue;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Illuminate\Support\Str;

class ProductsImport implements ToCollection
{
    protected $startLine;
    protected $lastLine;
    protected $packaging;
    protected $columns = [];
    protected $collection;
    protected $rusColumns = [
        'Наименование',
        'Артикул',
        'Цена опт',
        'Цена розн.',
        'Ед. изм. в уп.',
    ];

    protected $category;
    protected $vendor;
    protected $unit;
    protected $manufacture;
    protected $size_type;
    protected $properties;

    public function __construct($startLine = 1, $columns = ['title' => '1'], $lastLine = NULL, $packaging = '0') {
        $this->startLine = $startLine;
        $this->lastLine = $lastLine;
        $this->packaging = $packaging;
        $this->collection = collect([]);
        foreach ($columns as $key => $column) {     
            if (Str::is('column*', $key) && $column !== NULL) {
                $this->columns[substr($key, 7)] = $column-1;
            }
        }
        $this->category     = ($columns['category']) ? $columns['category'] : NULL ;
        $this->vendor     = ($columns['vendor']) ? $columns['vendor'] : NULL ;
        $this->unit     = ($columns['unit']) ? $columns['unit'] : NULL ;
        $this->manufacture     = ($columns['manufacture']) ? $columns['manufacture'] : NULL ;
        $this->size_type     = ($columns['size_type']) ? $columns['size_type'] : NULL ;

        if (isset($columns['property_values'])) {
            foreach ($columns['property_values'] as $key => $value) {
                if (!empty($value)) {
                    $this->properties[$key] = $value-1;
                }                
            }
        }
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) 
        {
            if ($this->lastLine && $key == $this->lastLine) {
                break;
            }
            if ($key >= $this->startLine) {

                $item = [];
                foreach ($this->columns as $key2 => $column) {
                    if (isset($row[$column])) {
                        $item[$key2] = $row[$column];
                    }
                }
                // dd($item);
                $item['category_id']        = $this->category;
                $item['vendor_id']          = $this->vendor;
                $item['unit_id']            = $this->unit;
                $item['manufacture_id']     = $this->manufacture;
                $item['size_type']          = $this->size_type;
                $item['imported']           = '1';
                $item['autoscu']            = '';
                $item['slug']               = '';
                $item['published']          = '0';
                $item['packaging']          = $this->packaging;

                if ($item['product'] !== NULL) {
                    $this->collection->push($item);
                    $product = Product::create($item);

                    if (!empty($this->properties)) {
                        foreach ($this->properties as $prop => $prop_column) {
                            if (isset($row[$prop_column])) {
                                $propertyValue = new Propertyvalue;
                                $propertyValue->product_id = $product->id;
                                $propertyValue->property_id = $prop;
                                $propertyValue->value = $row[$prop_column];
                
                                $propertyValue->save();
                            }                            
                        }
                    }
                }                              
            }
            
            // User::create([
            //     'name' => $row[0],
            // ]);
            
        }        
    }
}
