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
                        <form action="' . route('dashboard.gallery.destroy', $data->id) . '" method="POST" class="inline-block">
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
                    $is_checked = $data->is_featured ? 'checked' : '';
                    return '
                    <form action="' . route('dashboard.gallery.update', $data->id) . '" method="POST">
                        ' . csrf_field() . '
                        ' . method_field('PUT') . '
                        <label for="default-toggle-' . $data->id . '" class="inline-flex relative items-center cursor-pointer">
                        <input type="checkbox" name="is_featured" id="default-toggle-' . $data->id . '" class="sr-only peer "' . $is_checked . ' onChange="this.form.submit()">
                        <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[' . "''" . '] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-600"></div>
                        </label>
                    </form>
                    ';
                })
                ->rawColumns(['action', 'url', 'is_featured'])
                ->make(true);
        }
        return view('pages.dashboard.gallery.index', compact('product'));
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
    public function update(Request $request, ProductGallery $productGallery)
    {
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
