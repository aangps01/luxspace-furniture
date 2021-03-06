<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(Transaction::query())
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
    public function show(Transaction $transaction)
    {
        if (request()->ajax()) {
            $query = TransactionItem::with('product')->where('transaction_id', $transaction->id);
            return datatables()->of($query)
                ->editColumn('product.price', function ($data) {
                    return 'Rp. ' . number_format($data->product->price);
                })
                ->make(true);
        }

        return view('pages.dashboard.transaction.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaction $transaction)
    {
        return view('pages.dashboard.transaction.edit', compact('transaction'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'status' => 'required|in:PENDING,CHALLENGE,SUCCESS,FAILED,SHIPPING,SHIPPED',
        ]);

        try {
            $transaction->update($validated);
        } catch (\Throwable $th) {
            return redirect()->route('dashboard.transaction.index')->with('failed', 'Failed to update data');
        }
        return redirect()->route('dashboard.transaction.index')->with('success', 'Successfully updated status');
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
