<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;


class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        return view('admin.form-product', compact('products', 'categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'bonus' => 'nullable',
            'price' => 'required|numeric',
            'garansi' => 'required',
            'discount' => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        Product::create($request->all());

        return redirect()->route('dashboard.product')->with('success', 'Produk berhasil ditambahkan!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.edit-product', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'nullable',
            'bonus' => 'nullable',
            'price' => 'required|numeric',
            'garansi' => 'required',
            'discount' => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);
        $product = Product::findOrFail($id);
        $product->update($request->all());
        return redirect()->route('dashboard.product')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('dashboard.product')->with('success', 'Produk berhasil dihapus!');
    }


    public function getProduct($id)
    {
        $product = Product::findOrFail($id);
        return response()->json($product);
    }

    public function getProductDetail($id)
    {
        $product = Product::find($id);

        if ($product) {
            return response()->json([
                'id' => $product->id,
                'description' => $product->description,
                'bonus' => $product->bonus,
                'garansi' => $product->garansi,
                'price' => $product->price,
                'discount' => $product->discount
            ]);
        }

        return response()->json(['error' => 'Produk tidak ditemukan'], 404);
    }


    public function search(Request $request)
    {
        $data = Product::where('name', 'LIKE', '%' . $request->q . '%')->get();
        return response()->json($data);
    }

    public function show($id)
    {
        return Product::findOrFail($id);
    }
}
