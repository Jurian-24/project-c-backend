<?php

namespace Database\Seeders;

use App\Models\DiscountLabel;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AppieProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding Appie Products');

        $json = [];
        // for loop maken en een sleep toevoegen van 10 seconden of iets zodat we niet te veel requests aanmaken.

        for($i=0; $i < 9; $i++) {
            // create the request
            $response = Http::withHeaders([
                'Host' => env('APPIE_API_HOST'),
                'x-dynatrace' => env('APPIE_X_DYNATRACE'),
                'x-application' => env('APPIE_X_APPLICATION'),
                'user-agent' => env('APPIE_USER_AGENT'),
                'content-type' => env('APPIE_CONTENT_TYPE'),
                'Authorization' => "Bearer " . env('APPIE_API_TOKEN'),
            ])
            ->get("https://" . env('APPIE_API_HOST') . "/mobile-services/product/search/v2?page=". $i + 1 ."&size=300&shopType=AH");

            array_push($json, $response->json());

            sleep(20);
        }

        // create the products and add them to the database
        foreach($json as $products) {
            foreach($products['products'] as $product) {
                $this->command->info((string) $product['title']);
                $createdProduct = Product::create([
                    'ah_id'                     => $product['webshopId']                        ?? null,
                    'title'                     => $product['title']                            ?? null,
                    'sales_unit_size'           => $product['salesUnitSize']                    ?? null,
                    'unit_price_description'    => $product['unitPriceDescription']             ?? null,
                    'price'                     => $product['priceBeforeBonus']                 ?? null,
                    'order_availability_status' => $product['orderAvailabilityStatus']          ?? null,
                    'main_category'             => $product['mainCategory']                     ?? null,
                    'sub_category'              => $product['subCategory']                      ?? null,
                    'brand'                     => $product['brand']                            ?? null,
                    'shop_type'                 => $product['shopType']                         ?? null,
                    'available_online'          => $product['availableOnline']                  ?? false,
                    'is_previously_bought'      => $product['isPreviouslyBought']               ?? false,
                    'description_highlights'    => $product['descriptionHighlights']            ?? null,
                    'property_icons'            => implode(', ', $product['propertyIcons'])     ?? null,
                    'nutriscore'                => $product['nutriscore']                       ?? null,
                    'nix18'                     => $product['nix18']                            ?? false,
                    'is_stapel_bonus'           => $product['isStapelBonus']                    ?? false,
                    'extra_description'         => implode(', ', $product['extraDescriptions']) ?? null,
                    'is_bonus'                  => $product['isBonus']                          ?? false,
                    'is_orderable'              => $product['isOrderable']                      ?? false,
                    'is_infinite_bonus'         => $product['isInfiniteBonus']                  ?? false,
                    'is_sample'                 => $product['isSample']                         ?? false,
                    'is_sponsored'              => $product['isSponsored']                      ?? false,
                    'is_virtualBundle'          => $product['isVirtualBundle']                  ?? false,
                ]);

                foreach($product['images'] as $image) {
                    ProductImage::create([
                        'product_id' => $createdProduct->id,
                        'width' => $image['width'],
                        'height' => $image['height'],
                        'url' => $image['url'],
                    ]);
                }

                foreach($product['discountLabels'] as $discountLabel) {
                    DiscountLabel::create([
                        'product_id' => $createdProduct->id,
                        'code' => $discountLabel['code'],
                        'default_description' => $discountLabel['defaultDescription'],
                        'count' => $discountLabel['count'] ?? null,
                        'price' => $discountLabel['price'] ?? null,
                        'percentage' => $discountLabel['percentage'] ?? null,
                        'precise_percentage' => $discountLabel['precisePercentage'] ?? null,
                    ]);
                }

                // todo: maak een table aan voor de discount labels als die er zijn en maak voor elke discount label
                // een record aan in de database met de product id en de discount label (object).
            }
        }

        $this->command->info('Seeding Appie Products complete');
    }
}
