<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Product::query())
                ->addColumn('action', function ($data) {
                    return '
                        <a href="' . route('dashboard.product.gallery.index', $data->slug) . '" class="bg-yellow-500 text-white rounded-md px-2 py-1 m-2">
                            Gallery
                        </a>
                        <a href="' . route('dashboard.product.edit', $data->slug) . '" class="bg-gray-500 text-white rounded-md px-2 py-1 m-2">
                            Edit
                        </a>
                        <form action="' . route('dashboard.product.destroy', $data->slug) . '" method="POST" class="inline-block">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button class="bg-red-500 text-white rounded-md px-2 py-1 m-[8px]">Delete</button>
                        </form>
                   ';
                })
                ->editColumn('price', function ($data) {
                    return number_format($data->price);
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.dashboard.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.dashboard.product.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();
        $slug = Str::slug($request->name);
        try {
            $product = new Product($validated);
            $product->slug = $slug;
            $product->save();
        } catch (\Throwable $th) {
            return redirect()->route('dashboard.product.index')->with('error', 'Failed to save data');
        }
        return redirect()->route('dashboard.product.index')->with('success', 'Successfully Added');
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
    public function edit(Product $product)
    {
        return view('pages.dashboard.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($request->name);
        try {
            $product->update($validated);
        } catch (\Throwable $th) {
            return redirect()->route('dashboard.product.index')->with('error', 'Failed to save data');
        }
        return redirect()->route('dashboard.product.index')->with('success', 'Successfully Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try {
            $product->delete();
        } catch (\Throwable $th) {
            return redirect()->route('dashboard.product.index')->with('error', 'Failed to delete data');
        }
        return redirect()->route('dashboard.product.index')->with('success', 'Successfully Deleted data');
    }
}
