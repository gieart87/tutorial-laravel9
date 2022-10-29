<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Product;
use App\Models\Brand;
use App\Models\Category;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();

        return view('products.index', ['products' => $products]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::orderBy('name', 'asc')->get()->pluck('name', 'id');
        $categories = Category::orderBy('name', 'asc')->get()->pluck('name', 'id');

        return view('products.create', ['brands' => $brands, 'categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $params = $request->validated();
        if ($product = Product::create($params)) {
            $product->categories()->sync($params['category_ids']);

            return redirect(route('products.index'))->with('success', 'Added!');
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $brands = Brand::orderBy('name', 'asc')->get()->pluck('name', 'id');
        $categories = Category::orderBy('name', 'asc')->get()->pluck('name', 'id');


        return view('products.edit', ['product' => $product, 'brands' => $brands, 'categories' => $categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $params = $request->validated();

        if ($product->update($params)) {
            $product->categories()->sync($params['category_ids']);

            return redirect(route('products.index'))->with('success', 'Updated!'); 
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->categories()->detach();

        if ($product->delete()) {
            return redirect(route('products.index'))->with('success', 'Deleted!');
        }

        return redirect(route('products.index'))->with('error', 'Sorry, unable to delete this!');
    }
}
