<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use RealRashid\SweetAlert\Facades\Alert;

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
            'stok' => 'nullable|numeric',
            'stok_preorder' => 'nullable|numeric',
            'category_id' => 'required|exists:categories,id',
            'is_preorder' => 'required|boolean',
            'available_date' => 'nullable|date',
        ]);

        $data = $request->all();

        if ($request->is_preorder) {
            $data['preorder_quantity'] = 0;
            $data['stok'] = 0;
            $data['stok_preorder'] = 0;
            $data['preorder_quantity'] = 0;
            $data['available_date'] = null;
        }

        $product = Product::create($data);



        Alert::success('Berhasil', 'Produk berhasil ditambahkan!');
        return redirect()->route('dashboard.product');
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
            'stok' => 'numeric',
            'category_id' => 'required|exists:categories,id',
        ]);
        $product = Product::findOrFail($id);
        $product->update($request->all());
        Alert::success('Berhasil', 'Produk berhasil diperbarui!');
        return redirect()->route('dashboard.product');
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
        Alert::success('Berhasil', 'Produk berhasil dihapus!');

        return redirect()->route('dashboard.product');
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
                'stok' => $product->stok,
                'discount' => $product->discount
            ]);
        }

        return response()->json(['error' => 'Produk tidak ditemukan'], 404);
    }


    public function search(Request $request)
    {
        $data = Product::where('name', 'LIKE', '%' . $request->q . '%')
            ->where(function ($query) {
                $query->where(function ($q) {
                    $q->where('stok', '>', 0)
                        ->whereColumn('stok', '!=', 'preorder_quantity');
                })
                    ->orWhere(function ($q) {
                        $q->where('is_preorder', 1)
                            ->where('stok_preorder', '>', 0)
                            ->whereColumn('stok_preorder', '!=', 'preorder_quantity');
                    });
            })
            ->get();

        return response()->json($data);
    }

    public function updateStock(Request $request, $id)
    {
        $request->validate([
            'is_preorder' => 'required|boolean',
            'stok' => 'nullable|integer|min:0',
            'stok_preorder' => 'nullable|integer|min:0',
            'available_date' => 'nullable|date'
        ]);

        $product = Product::findOrFail($id);

        if ($request->is_preorder) {
            $product->is_preorder = 1;
            $product->stok = 0;
            $product->stok_preorder = $request->stok_preorder ?? 0;
            $product->available_date = $request->available_date;
        } else {
            $product->is_preorder = 0;
            $product->stok = $request->stok ?? 0;
            $product->stok_preorder = 0;
            $product->available_date = null;
        }

        $product->save();

        return redirect()->back()->with('success', 'Stok dan status produk berhasil diperbarui.');
    }



    public function syncPreorder($id)
    {
        $product = Product::findOrFail($id);

        if ($product->is_preorder && $product->stok_preorder > 0) {

            $product->stok += $product->stok_preorder;
            $product->stok_preorder = 0;
            $product->is_preorder = 0;
            $product->available_date = null;
            $product->save();

            return redirect()->back()->with('success', 'Stok Pre-Order berhasil dipindahkan ke stok fisik.');
        }

        return redirect()->back()->with('error', 'Produk ini tidak dalam status preorder atau stok_preorder kosong.');
    }


    public function show($id)
    {
        return Product::findOrFail($id);
    }
}
