<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Rquests ; 
use App\Models\User;
use App\Http\Resources\user as userResource ; 

class userController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
            //Get users
            $users = user::paginate(10);
            //return collection of users as aresource
            return userResource::collection($users);
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
        $user = $request->isMethod('put') ? user::findOrFail($request->id) : new user ;
        $user->id = $request->input('user_id');
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = $request->input('password');
        $user->jop = $request->input('jop');
        $user->gender = $request->input('gender');

        if ($user->save()) {
            return new userResource ($user);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //GEt singl user
        $user = user::findOrFail($id) ;
        return new userResource($user);
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
        $user = user::findOrFail($id);

        if($user->delete()) {

            return new userResource($user);
        }
    }
    public function dataConter()
    {
      
        $male = count(user::where('gender' , "=" , "male")->get());
        $female= count(user::where('gender' , "=" , "female")->get());
        $user= count(user::all());

       return response()->json([
            'male' => $male ,
            'female' =>$female,
            'user' =>$user
        ]);
    }

}

