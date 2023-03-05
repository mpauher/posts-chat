<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function register(Request $request){
        try{
            $request->validate([
                'name' =>'required|string',
                'email' =>'required|string',
                'password' =>'required|string',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            return response()->json([
               'message' =>'User created successfully'
            ],201);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function index() {
        try {
            $users = User::all();

            if(count($users) == 0){
                return response()->json();           
            }

            return response()->json([
                'users' => $users
            ],200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function show($id){
        try {
            $user = User::find($id);

            if (!$user){
                return response()->json([
                    'error' => 'User not found'
                ],404);
            }

            return response()->json([
                'user' => $user
            ],200);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage
            ],400);
        }
    }

    public function update($id, Request $request){
        try {

            $user = User::find($id);
            $users = User::all();


            if(!$user){
                return response()->json([
                    'error' => 'User not found'
                ],404);
            }

            foreach($users as $user){
                if($user->email == $request->email){
                    return response()->json([
                        'error' => 'Email address must be unique'
                    ],404);
                }
            }

            $user->update($request->all());

            return response()->json([
                'message' => 'User updated successfully'
            ],200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage
            ],400);
        }
    }

    public function destroy($id){
        try {
            $user = User::find($id);

            if(!$user){
                return response()->json([
                    'error' => 'User not found'
                ],404);
            }

            $user->delete();

            return response()->json([
                'message' => 'User deleted successfully'
            ],200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => $e->getMessage
            ],400);
        }
    }
}
