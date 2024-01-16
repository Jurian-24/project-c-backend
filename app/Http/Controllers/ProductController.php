<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

use function in_array;
use function array_push;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::all();

        return view('company-admin.products')->with('products', $products);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

     /**
     * @var Product $products
     *
     * Description: Get the products that match the title and get the images where the image is 800px wide
     */
    public function show($title)
    {

        $products = Product::where('title', 'LIKE', '%' . $title . '%')
            ->orWhere('brand', 'LIKE', '%' . $title . '%')
            ->where('order_availability_status', "IN_ASSORTMENT")
            ->with(['productImages' => function ($query) {
                $query->where('width', 800);
            }])
            ->get();

        $productMatches = [];

        foreach($products as $product) {
            if($product->productImages->count() > 0) {
                $product->product_image = $product->productImages[0]->url;

                unset($product->product_images);
            }

            $implodedTitle = explode(' ', strtolower($product->title));

            if(in_array($title, $implodedTitle)) {
                array_push($productMatches, $product);
            }

        }

        return response()->json($products, 200);
    }

    public function searchCategorie($categorie)
    {
        // search categories
        $products = Product::where('main_category', 'LIKE', '%' . $categorie . '%')
            ->with('productImages')
            ->get();

        return view('company-admin.products')->with('products', $products);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
