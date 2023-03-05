<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Service;


class ServiceController extends Controller
{
    public function index(){
        try {
            $services = Service::all();

            if(count($services) == 0){
                return response()-> json();
            }

            return response()->json([
                'services' => $services
            ],200);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ],400);            
        }
    }

    public function show($id){
        try{
            $service = Service::find($id);

            if(!$service){
                return response()->json([
                    'error'=>'Service not found'
                ],404);
            }

            return response()->json([
                'service' => $service
            ],200);

        }catch (\Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ],400);
        }
    }

    public function create(Request $request){
        try{
            $user_id=auth()->user()->id;

            $request->validate([
            'title'=>'required|string',
            'description'=>'required|string',
            'image'=>'required|string',
            ]);

            $service = Service::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'image'=>$request->image,
            'user_id'=>$user_id
            ]);

            return response()->json([
                'message'=>'Service created successfully'
            ]);
        }catch ( \Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ],400);
        }
    }

    public function update($id, Request $request){
        try{
            $service = Service::find($id);

            if(!$service){
                return response()->json([
                    'error'=>'Service not found'
                ],404);
            }

            $service->update($request->all());

            return response()->json([
                'message' => 'Service update succesfully',
            ],200);
        }catch ( \Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ],400);
        }
    }

    public function destroy($id){
        try {
            $service = Service::find($id);

            if(!$service){
                return response()->json([
                    'error'=>'Service not found'
                ],404);
            }

            Service::destroy($id);

            return response()->json([
                'message' => 'Service deleted succesfully',
            ],200);

        } catch ( \Exception $e){
            return response()->json([
                'error' => $e->getMessage()
            ],400);
        }
    }
}
