<?php

namespace App\Http\Controllers\API;

use App\Models\User;
// use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Request;

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
        if (Gate::allows('isAdmin') || Gate::allows('isAuthor') ) {
            return User::paginate(10);
        }
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
      
    }
    public function search()
    {
        if (Gate::allows('isAdmin') || Gate::allows('isAuthor') ) {
        if ($search=Request::get('q')) {
            $users=User::where(function($query) use ($search){
            $query->where('name','LIKE',"%$search%")->orWhere('email','LIKE',"%$search%")
            ->orWhere('type','Like',"%$search%");
            })->paginate('10');
            return $users;
        }

        
            return User::paginate(10);
        }

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
    public function updateProfile(Request $request){
        $user= auth('api')->user();
        
        $request->validate([
            'name' => 'required|string|max:191',
            'email' => 'required|email|string|max:191|unique:users,email,'.$user->id,
            'password' => 'sometimes|required|string|min:8',

        ]);

        
            $currentPhoto=$user->photo;
            if ($request->photo != $currentPhoto) {
                $photoName=time().'.'.explode('/',explode(':',substr($request->photo,0,strpos
                ($request->photo,';')))[1])[1];
                Image::make($request->photo)->save(public_path("img/profile/").$photoName);
                $request->merge(['photo'=>$photoName]);

                 $profilePhoto=public_path("img/profile/").$currentPhoto;

                 if (file_exists($profilePhoto)) {
                     @unlink($profilePhoto);
                 }

            }
            if (!empty($request->password)) {
                $request->merge(['password'=> Hash::make($request['password'])]);
            }

            $user->update($request->all());
         return ['message'=>'success'];
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
            'password' => 'sometimes|required|string|min:8',

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
