<?php

namespace App\Imports;

use App\Category;
use App\Vendor;
use App\vendorPhoto;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class VendorImport implements ToCollection, WithHeadingRow
{
    public function collection(Collection $rows)
    {
        foreach ($rows as $key => $value) {

            $category = explode(', ', $value['category']);

            if ($category[0]) {
                $catId = [];
                foreach ($category as $data) {
                    $cat = Category::updateOrCreate([
                        'category_name' => $data
                    ], ['category_name' => $data]);
                    $catId[] = $cat['id'];
                }
                $category_id = implode(',', $catId);
                if ($value['vendor_name'] != '') {
                    $featured = 0;
                    if ($value['featured_vendor'] == 'Yes') {
                        $featured = 1;
                    }
                    $vendor = Vendor::create([
                        'category_id' => $category_id,
                        'name' => $value['vendor_name'],
                        'description' => $value['description'],
                        'logo' => $value['logo'],
                        'booth_number' => $value['booth'],
                        'booth_hall' => $value['booth_hall'],
                        'email' => $value['email'],
                        'phone' => $value['phone'],
                        'website' => $value['website'],
                        'booth_map' => $value['booth_map'],
                        'featured' => $featured,
                    ]);
                    if (!empty($value['photos'])) {
                        $photos = explode(',', $value['photos']);
                        foreach ($photos as $photo) {
                            $img = vendorPhoto::create([
                                'photo' => $photo,
                                'vendor_id' => $vendor['id']
                            ]);
                        }
                    }
                }
            }
        }
        return 1;
    }
}
