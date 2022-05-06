<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductGalleryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        if (request()->ajax()) {
            $query = ProductGallery::query();

            return datatables()->of($query)
                ->addColumn('action', function ($data) {
                    return '
                        <form action="' . route('dashboard.product.gallery.destroy', $data->id) . '" method="POST" class="inline-block">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button class="bg-red-500 text-white rounded-md px-2 py-1 m-[8px]">Delete</button>
                        </form>
                   ';
                })
                ->editColumn('url', function ($data) {
                    return '<img src="' . Storage::url($data->url) . '" style="max-width: 180px">';
                })
                ->editColumn('is_featured', function ($data) {
                    return $data->is_featured ? 'Yes' : 'No';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.dashboard.product-gallery.index', compact('product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
