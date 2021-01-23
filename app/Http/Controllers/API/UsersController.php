<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{

/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return User::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|string|max:255|unique:users,email',
            'password' => 'required|string|min:8',

        ]);
        return User::create([
                'name'=>$request['name'],
                'email'=>$request['email'],
                'password'=>Hash::make($request['password']),
                'type'=>$request['type'],
                'bio'=>$request['bio'],
                'photo'=>$request['photo'],
        ]);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function profile()
    {
        return auth('api')->user();
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
        $user=User::findorFail($id);

        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|string|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|string|min:8',

        ]);
        $user->update($request->all());
        return ["message"=>"Updated User Info"];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $data=User::findorFail($id);
        $data->delete();

        return response()->json('user deleted');
    }
}
