<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jam;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class JamController extends Controller
{
    public function index()
    {
        //get data from table dosen
        $post = Jam::get();
        //make response JSON
        return response()->json([
            'success' => true,
            'count' => count($post),
            'message' => 'List Data Jam',
            'data'    => $post
        ], 200);
    }

    public function show($kode)
    {
        $post = DB::table('jam')
            ->where('kode', $kode)
            ->get();
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Jam',
            'data'    => $post
        ], 200);
    }

    // public function store(Request $request)
    // {
    //     //set validation
    //     $validator = Validator::make($request->all(), [
    //         'range_jam'  => 'required',
    //         'aktif'      => 'required',
    //     ]);

    //     //response error validation
    //     if ($validator->fails()) {
    //         return response()->json($validator->errors(), 400);
    //     }

    //     //save to database
    //     $post = Jam::create([
    //         'range_jam'  => $request->range_jam,
    //         'aktif'      => $request->aktif,
    //     ]);

    //     //success save to database
    //     if($post) {

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Jam Created',
    //             'data'    => $post  
    //         ], 201);

    //     } 

    //     //failed save to database
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Jam Failed to Save',
    //     ], 409);

    // }

    // public function update(Request $request, $id)
    // {
    //     //set validation
    //     $validator = Validator::make($request->all(),[
    //         'range_jam' =>'required',
    //         'aktif'     =>'required',
    //     ]);

    //     //response error validation
    //     if($validator->fails()){
    //         return response()->json($validator->errors()->toJson());
    //     }
    //     $post= Jam::where('id', $id)->update([
    //         'range_jam' =>$request->range_jam,
    //         'aktif'     =>$request->aktif,
    //     ]);
    //     if($post){
    //         return response()->json([
    //             'status'  =>true, 
    //             'message' =>'Jam Updated',
    //         //    'data'    => $post 
    //         ], 200);
    //     } else {
    //         return response()->json([
    //             'status'  =>false, 
    //             'message' =>'Jam Failed to Update'
    //         ], 404);
    //     }
    // }

    // public function destroy($id)
    // {
    //     //find post by ID
    //     $post = Jam::findOrfail($id);
    //     if($post) {
    //         //delete post
    //         $post->delete();
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Jam Deleted',
    //         ], 200);
    //     }
    //     //data post not found
    //     return response()->json([
    //         'success' => false,
    //         'message' => 'Jam Not Found',
    //     ], 404);
    // }
}
