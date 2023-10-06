<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index()
    {
        $users = User::where('status', 'unactive')->paginate(10);
        return view('users.index', compact('users'));
    }

    public function update($id, Request $request)
    {
        $user = User::find($id)
        ->where('status','unactive')
        ->update(['status'=>$request->status]);

        return redirect()->route('dashboard.users.index');
    }

    public function edit($id){

    }

    public function create(){

    }
    public function store(){

    }

    public function destroy($id){

    }
}
