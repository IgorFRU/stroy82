<?php

namespace App\Exports;

use App\Product;

use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style;

class ProductsExport
{
    static $products;
    static $fileName;
    static $spreadsheet;
    static $sheet;
    static $date;
    static $column_numbers;
    static $column_values;
    static $titles = [
        'scu'           => 'Артикул',
        'price'         => 'Цена',
        'product'       => 'Название товара',
        'category'      => 'Категория',
        'manufacture'   => 'Производитель',
        'vendor'        => 'Поставщик',
        'description'   => 'Описание товара',
        'slug'          => 'Ссылка',
        'size_l'        => 'Длина',
        'size_w'        => 'Ширина',
        'size_t'        => 'Толщина',
        'mass'          => 'Масса',
        'properties'    => 'Характеристики',
    ];   
    
    static $alfabet = [
        3 => 'C',
        4 => 'D',
        5 => 'E',
        6 => 'F',
        7 => 'G',
        8 => 'H',
        9 => 'I',
        10 => 'J',
    ];

    static $styleBold = [
        'font' => [
            'bold' => true,
        ],
    ];

    static $styleBlackBorders = [
        'borders' => [
            'outline' => [
                'borderStyle' => Style\Border::BORDER_THICK,
                'color' => ['argb' => '000000000'],
            ],
        ],
    ];

    static $styleSmall = [
        'font' => [
            'size' => '8',
        ],
    ];

    static $styleBig = [
        'font' => [
            'size' => '16',
        ],
    ];

    /**
     * main method of class
     *
     * @param Project $project
     * @param string $method
     * @return void
     */
    public static function export($products, array $column_numbers, array $column_values)
    {
        self::$products = $products;
        self::$column_numbers = ($column_numbers[0] != '') ? preg_split("/[,]/", $column_numbers[0]) : [] ;
        self::$column_values = ($column_values[0] != '') ? preg_split("/[,]/", $column_values[0]) : [] ;
        // dd(self::$column_numbers, $column_numbers);
        self::$date = \Carbon\Carbon::now()->toDateTimeString();
        self::$fileName = 'Export_Stroy82_' . self::$date . '.xls';
        self::$spreadsheet = new Spreadsheet();
        // $method = Str::camel($method);
        self::fillFile(self::$products);
    }

    public static function fillFile() {
        self::$sheet = self::$spreadsheet->getActiveSheet();
        self::$sheet->setTitle('1');

        self::$sheet->getPageSetup()->setOrientation(\PhpOffice\PhpSpreadsheet\Worksheet\PageSetup::ORIENTATION_PORTRAIT)->setFitToWidth(1);
        self::$sheet->getPageMargins()->setTop(1);
        self::$sheet->getPageMargins()->setRight(0.75);
        self::$sheet->getPageMargins()->setLeft(0.75);
        self::$sheet->getPageMargins()->setBottom(1);

        $line = 1;

        self::setCellValue('A', $line, '№', [self::$styleBold, self::$styleBlackBorders]);
        self::setCellValue('B', $line, 'Артикул сайта', [self::$styleBold, self::$styleBlackBorders]);

        if (count(self::$column_numbers) > 0) {
            foreach (self::$column_numbers as $key => $number) {
                // dd(self::$alfabet[(int)$number], self::$titles[self::$column_values[$key]]);
                self::setCellValue(self::$alfabet[(int)$number], $line, self::$titles[self::$column_values[$key]], [self::$styleBold, self::$styleBlackBorders]);
            }
        }

        $i = 1;
        if (count(self::$products) > 0) {
            foreach (self::$products as $product) {
                $line++;
                self::setCellValue('A', $line, $i);
                self::setCellValue('B', $line, $product->autoscu);
                
                if (count(self::$column_numbers)) {
                    foreach (self::$column_numbers as $key => $number) {
                        switch (self::$column_values[$key]) {
                            case 'scu':
                                $cellData = (isset($product->scu)) ? $product->scu : '' ;
                                break;
                            case 'price':
                                $cellData = (isset($product->price)) ? $product->price : '' ;
                                break;
                            case 'product':
                                $cellData = (isset($product->product)) ? $product->product : '' ;
                                break;
                            case 'category':
                                $cellData = (isset($product->category)) ? $product->category->category : '' ;
                                break;
                            case 'manufacture':
                                $cellData = (isset($product->manufacture)) ? $product->manufacture->manufacture : '' ;
                                break;
                            case 'vendor':
                                $cellData = (isset($product->vendor)) ? $product->vendor->vendor : '' ;
                                break;
                            case 'description':
                                $cellData = (isset($product->description)) ? $product->description : '' ;
                                break;
                            case 'slug':
                                if($product->category) {
                                    $cellData = route('product', ['category' => $product->category->slug, 'product' => $product->slug]);
                                }
                                else {
                                    $cellData = route('product.without_category', ['product' => $product->slug]);                                   
                                }
                                break;
                            case 'size_l':
                                $cellData = (isset($product->size_l)) ? $product->size_l . $product->size_type . '.' : '' ;
                                break;
                            case 'size_w':
                                $cellData = (isset($product->size_w)) ? $product->size_w . $product->size_type . '.' : '' ;
                                break;
                            case 'size_t':
                                $cellData = (isset($product->size_t)) ? $product->size_t . $product->size_type . '.' : '' ;
                                break;
                            case 'mass':
                                $cellData = (isset($product->mass)) ? $product->mass . ' кг.' : '' ;
                                break;
                            case 'properties':
                                if (isset($product->propertyvalue)) {
                                    if (count($product->propertyvalue)) {
                                        $cellData = '';
                                        foreach ($product->propertyvalue as $key => $value) {
                                            $cellData .= $value->properties->property . ': ' . $value->value . '; ';
                                        }
                                    }
                                }                                
                                break;
                            default:
                                $cellData = 'error!';
                                break;
                        }
                        if ($cellData == NULL) {
                            $cellData = '';
                        }
                        // dd(self::$column_values[$key], $cellData, $product->product);
                        self::setCellValue(self::$alfabet[(int)$number], $line, $cellData);
                    }
                }                
                $i++;
            }
        }

        self::createFile();
    }

    public static function createFile() {
        $writer = new Xlsx(self::$spreadsheet);

        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="' . self::$fileName . '"');
        // header('Cache-Control: max-age=0');

        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter(self::$spreadsheet, 'Xls');
        $writer->save('php://output');

        return $writer;
    }

    /**
     * Filling and styling cell
     *
     * @param string $cell
     * @param string $row
     * @param string $value
     * @param array $style
     * @param string $width
     * @param string $height
     * @return void
     */
    public static function setCellValue(string $cell, string $row, string $value, array $style = NULL, string $width = NULL, string $height = NULL) {
        if (!is_null($width)) {
            self::$sheet->getColumnDimension($cell)->setWidth($width);
        }
        if (!is_null($height)) {
            self::$sheet->getRowDimension($row)->setRowHeight($height);
        }
        self::$sheet->setCellValue($cell . $row, $value);
        if (!is_null($style)) {
            foreach ($style as $key => $value) {
                self::$sheet->getStyle($cell . $row)->applyFromArray($value);
            }
        }
    }

}