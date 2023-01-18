<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\Matkul;
use Illuminate\Support\Facades\DB;

class MatakuliahController extends Controller
{

    public function index()
    {
        $post = Matkul::get();
        //make response JSON
        return response()->json([
            'success' => true,
            'count' => count($post),
            'message' => 'List Data Mata Kuliah',
            'data'    => $post
        ], 200);
    }

    public function show($kode)
    {
        $post = DB::table('matakuliah')
            ->where('kode', $kode)->get();
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Matakuliah',
            'data'    => $post
        ], 200);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kode_mk'   => 'required',
            'nama'      => 'required',
            'sks'       => 'required',
            'semester'  => 'required',
            'aktif'     => 'required',
            'jenis'     => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }
        $post = Matkul::create([
            'kode_mk'   => $request->kode_mk,
            'nama'      => $request->nama,
            'sks'       => $request->sks,
            'semester'  => $request->semester,
            'aktif'     => $request->aktif,
            'jenis'     => $request->jenis
        ]);
        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Matakuliah Created',
                'data'    => $post
            ], 201);
        }
        return response()->json([
            'success' => false,
            'message' => 'Matakuliah Failed to Save',
        ], 409);
    }

    public function update(Request $request, $kode)
    {
        $validator = Validator::make($request->all(), [
            'kode_mk'   => 'required',
            'nama'      => 'required',
            'sks'       => 'required',
            'semester'  => 'required',
            'aktif'     => 'required',
            'jenis'     => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson());
        }
        $post = Matkul::where('kode', $kode)->update([
            'kode_mk'   => $request->kode_mk,
            'nama'      => $request->nama,
            'sks'       => $request->sks,
            'semester'  => $request->semester,
            'aktif'     => $request->aktif,
            'jenis'     => $request->jenis
        ]);
        if ($post) {
            return response()->json([
                'status'  => true,
                'message' => 'Matakuliah Updated',
            ], 200);
        } else {
            return response()->json([
                'status'  => false,
                'message' => 'Matakuliah Failed to Update'
            ], 404);
        }
    }

    public function destroy($kode)
    {
        $post = DB::table('matakuliah')
            ->where('kode', $kode)->delete();
        if ($post) {
            return response()->json([
                'success' => true,
                'message' => 'Matakuliah Deleted',
            ], 200);
        }
        return response()->json([
            'success' => false,
            'message' => 'Matakuliah Not Found',
        ], 404);
    }
}
