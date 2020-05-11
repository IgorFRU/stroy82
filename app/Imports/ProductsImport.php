<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

use Illuminate\Support\Str;

class ProductsImport implements ToCollection
{
    protected $startLine;
    protected $columns = [];
    protected $collection;

    public function __construct($startLine = 1, $columns = ['title' => '1']) {
        $this->startLine = $startLine;
        $this->collection = collect([]);
        foreach ($columns as $key => $column) {     
            if (Str::is('column*', $key) && $column !== NULL) {
                $this->columns[substr($key, 7)] = $column-1;
            }
        }
        // $this->columns = $columns;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $row) 
        {
            if ($key >= $this->startLine) {

                $item = [];
                foreach ($this->columns as $key2 => $column) {
                    $item[$key2] = $row[$column];
                }
                // dd($item);
                if ($item['product'] !== NULL) {
                    $this->collection->push($item);
                }                
            }
            
            // User::create([
            //     'name' => $row[0],
            // ]);
        }

        dd($this->collection);
    }
}
