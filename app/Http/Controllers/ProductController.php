<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::all();

        $query = Product::with('category')->where('user_id', auth()->id());
    
        if ($request->has('category_id') && $request->category_id != '') {
            $query->where('category_id', $request->category_id);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

    
        $products = $query->paginate(1); // 10 products per page
    
        $totalProducts = Product::where('user_id', auth()->id())->count();
        $totalCategories = Category::where('user_id', auth()->id())->count();
        $totalStockValue = Product::where('user_id', auth()->id())
            ->selectRaw('SUM(price * quantity) as total_value')
            ->value('total_value');

        return view('products.index', compact('products', 'categories', 'totalProducts', 'totalCategories', 'totalStockValue'));    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:1',
            'quantity' => 'required|integer|min:1',
        ]);

        Product::create([
            'name' => $request->name,
            'category_id' => $request->category_id,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'user_id' => auth()->id(),
        ]);

        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
   
     public function edit($id)
     {
         $product = Product::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
         $categories = Category::all();
         return view('products.edit', compact('product', 'categories'));
     }
     

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
{
    $product = Product::where('id', $id)->where('user_id', auth()->id())->firstOrFail();

    $request->validate([
        'name' => 'required|string|max:255',
        'category_id' => 'required|exists:categories,id',
        'price' => 'required|numeric',
        'quantity' => 'required|integer|min:1',
    ]);

    $product->update([
        'name' => $request->name,
        'category_id' => $request->category_id,
        'price' => $request->price,
        'quantity' => $request->quantity,
    ]);

    return redirect()->route('products.index')->with('success', 'Product updated successfully.');
}


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
{
    $product = Product::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
    $product->delete();

    return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
}

}
