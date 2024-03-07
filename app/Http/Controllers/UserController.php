<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Ramsey\Uuid\Type\Time;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();

        return response()->json([
            'message' => count($user). ' Users Found',
            'data' => $user,
            'status' => true
        ],200);
    }
    public function show($id)
    {
        $user = User::find($id);
        if ($user != null){
            return response()->json([
                'message' => 'Record Found',
                'data' => $user,
                'status' => true
            ],200);
        }else{
            return response()->json([
                'message' => 'Record Not Found',
                'data' => [],
                'status' => true
            ],200);
        }

    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required'
        ]);
        if ($validator->fails()){
            return response()->json([
                'message' => 'Please Fix the errors',
                'errors' => $validator->errors(),
                'status' => false
            ],200);
        }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->save();

        return response()->json([
            'message' => 'Users added Successfully',
            'data' => $user,
            'status' => true
        ],200);
    }
    public function update(Request $request ,$id)
    {
        $user = User::find($id);

            if($user == null){
                return response()->json([
                    'message' => 'Record Not Found',
                    'status' => false
                ],200);
            }

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'email' => 'required|email',
        ]);
        if ($validator->fails()){
            return response()->json([
                'message' => 'Please Fix the errors',
                'errors' => $validator->errors(),
                'status' => false
            ],200);
        }

        $user->name = $request->name;
        $user->email = $request->email;
        $user->save();

        return response()->json([
            'message' => 'Users updated Successfully',
            'data' => $user,
            'status' => true
        ],200);
    }
    public function destroy( $id)
    {
        $user = User::find($id);

        if($user == null){
            return response()->json([
                'message' => 'Record Not Found',
                'status' => false
            ],200);
        }

        $user->delete();
        return response()->json([
            'message' => 'Users deleted Successfully',
            'data' => $user,
            'status' => true
        ],200);
    }
    public function upload(Request $request)
    {
        $validate = Validator::make($request->all(),[
           'image' => 'required|mimes:png,jpg,jpeg,gif'
        ]);
        if ($validate->fails()){
            return response()->json([
                'status' => false,
                'message' => 'Please Fix the Errors',
                'errors' => $validate->errors()
            ]);
        }
        $img = $request->image;
        $ext = $img->getClientOriginalExtension();
        $imageName = time().'.'.$ext;
        $img->move(public_path().'/uploads/',$imageName);


        $image = new Image();
        $image->image = $imageName;
        $image->save();

        return response()->json([
            'status' => true,
            'message' => 'Image Uploaded Successfully',
            'path' =>  asset('/uploads/' .$imageName ),
            'data' => $image
        ]);
    }
}
