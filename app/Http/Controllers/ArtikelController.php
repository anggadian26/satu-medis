<?php

namespace App\Http\Controllers;

use App\Models\ArtikeModel;
use Illuminate\Auth\Events\Validated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ArtikelController extends Controller
{
    public function create(Request $request) {
        $val = Validator::make($request->all(), [
            'judul'     => 'required|max:225',
            'konten'    => 'required'
        ]);

        if($val->fails()) {
            return response()->json($val->errors(), 400);
        }

        $existingArticle = ArtikeModel::where('judul', $request->judul)
                                   ->where('tanggal', now()->toDateString())
                                   ->first();

        if ($existingArticle) {
            return response()->json(['error' => 'Artikel sudah ada'], 400);
        }

        $data = [
            'judul'     => $request->judul,
            'tanggal'   => now()->toDateString(),
            'konten'    => $request->konten
        ];

        $artikel = ArtikeModel::create($data);
        
        return response()->json($artikel, 200);
    }

    public function read() {
        $artikel = ArtikeModel::paginate(10);
        return response()->json($artikel, 200);
    }

    public function show($id) {
        $artikel = ArtikeModel::find($id);

        return response()->json($artikel, 200);
    }

    public function update(Request $request, $id) {
        $val = Validator::make($request->all(), [
            'judul'     => 'required|max:225',
            'konten'    => 'required'
        ]);

        if($val->fails()) {
            return response()->json($val->errors(), 400);
        }
        
        $existingArticle = ArtikeModel::where('judul', $request->judul)
                                   ->where('tanggal', now()->toDateString())
                                   ->first();

        if ($existingArticle) {
            return response()->json(['error' => 'Artikel sudah ada'], 400);
        }

        $artikel = ArtikeModel::find($id);

        if (is_null($artikel)) {
            return response()->json(['message' => 'Artikel tidak ada'], 404);
        }

        $data = [
            'judul'     => $request->judul,
            'tanggal'   => now()->toDateString(),
            'konten'    => $request->konten
        ];
        
        $artikel->update($data);

        return response()->json($artikel);
    }

    public function delete($id) {
        $artikel = ArtikeModel::find($id);

        if (is_null($artikel)) {
            return response()->json(['message' => 'Artikel tidak ada'], 404);
        }

        $artikel->delete();

        return response()->json(['message' => 'Artikel berhasil dihapus 🎉']);
    }

    public function search(Request $request) {
        $val = Validator::make($request->all(), [
            'search'    => 'required|min:3|max:100'
        ]);

        if ($val->fails()) {
            return response()->json($val->errors(), 400);
        }

        $search = $request->search;

        $artikel = ArtikeModel::where('judul', 'LIKE', '%' . $search . '%')->paginate(10);

        return response()->json($artikel);
    }
}
