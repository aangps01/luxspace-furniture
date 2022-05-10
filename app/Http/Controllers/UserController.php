<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserPostRequest;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->ajax()) {
            return datatables()->of(User::query())
                ->addColumn('action', function ($data) {
                    return '
                        <a href="' . route('dashboard.user.edit', $data->id) . '" class="bg-gray-500 text-white rounded-md px-2 py-1 m-2">
                            Edit
                        </a>
                        <form action="' . route('dashboard.user.destroy', $data->id) . '" method="POST" class="inline-block">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button class="bg-red-500 text-white rounded-md px-2 py-1 m-[8px]">Delete</button>
                        </form>
                   ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('pages.dashboard.user.index');
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
    public function edit(User $user)
    {
        return view('pages.dashboard.user.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserPostRequest $request, User $user)
    {
        $validated = $request->validated();
        try {
            $user->update($validated);
        } catch (\Throwable $th) {
            return redirect()->route('dashboard.user.index')->with('failed', 'Failed to update data');
        }
        return redirect()->route('dashboard.user.index')->with('success', 'Successfully updated');
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
