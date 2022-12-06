<?php

namespace App\Imports;

use App\Models\Brands;
use App\Models\Products;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return Products
    */
    public function model(array $row)
    {
        $brand = Brands::firstOrCreate([
            'name' => $row['brand']
        ]);

        return new Products([
            //
            'name' => $row['product_name'],
            'price' => $row['price'],
            'brand'=> $brand->id
        ]);
    }
}
