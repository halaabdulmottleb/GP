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
        $id = $request->input('user_id');
        $user = User::find($id);
        $user->name =  $request->get('name');
        $user->jop = $request->get('jop');
        $user->save();


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
        return User::findOrFail($id);
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
    public function jops ()
    {
        $jops = [];
        $users = user::all();
        foreach($users as $user) {
            $jops[] = $user->jop;
        }

         return $jops ;

    }

}

