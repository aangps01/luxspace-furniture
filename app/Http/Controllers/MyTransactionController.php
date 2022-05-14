<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\TransactionItem;

class MyTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Transaction::with('user')->where('user_id', auth()->user()->id);
        if (request()->ajax()) {
            return datatables()->of($query)
                ->addColumn('action', function ($data) {
                    return '
                        <a href="' . route('dashboard.transaction.show', $data->id) . '" class="bg-blue-500 text-white rounded-md px-2 py-1 m-2">
                            Show
                        </a>
                        <a href="' . route('dashboard.transaction.edit', $data->id) . '" class="bg-gray-500 text-white rounded-md px-2 py-1 m-2">
                            Edit
                        </a>
                   ';
                })
                ->editColumn('total_price', function ($data) {
                    return number_format($data->total_price);
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.dashboard.transaction.index');
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
    public function show(Transaction $myTransaction)
    {
        if (request()->ajax()) {
            $query = TransactionItem::with('product')->where('transaction_id', $myTransaction->id);
            return datatables()->of($query)
                ->editColumn('product.price', function ($data) {
                    return 'Rp. ' . number_format($data->product->price);
                })
                ->make(true);
        }

        return view('pages.dashboard.transaction.show', [
            'transaction' => $myTransaction
        ]);
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
