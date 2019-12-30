<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function get_users(Request $request){
        $columns = ['name', 'email', 'created_at'];

        $length = $request->input('length');
        $column = $request->input('column');
        $dir = $request->input('dir');
        $searchValue = $request->input('search');

        $query = User::select('id', 'name', 'email', 'created_at')->orderBy($columns[$column], $dir);

        if ($searchValue){
            $query->where(function ($query) use ($searchValue){
               $query->where('name', 'like', '%' . $searchValue . '%')
                   ->orWhere('email', 'like', '%' . $searchValue . '%');
            });
        }

        $users = $query->paginate($length);
        return ['data' => $users, 'draw' => $request->input('draw')];

    }
}
