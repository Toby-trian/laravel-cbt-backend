<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSoalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Soal;

class SoalController extends Controller
{
    public function index(Request $request)
    {
//        $soals = Soal::paginate(10);
        $soals = DB::table('soals')
            ->when($request->input('pertanyaan'), function ($query, $name) {
                return $query->where('pertanyaan', 'like', '%' . $name . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
        return view('pages.soals.index_soal', compact('soals'));
    }
    public function create()
    {
        return view('pages.soals.create_soal');
    }
    public function store(StoreSoalRequest $request)
    {
        $data = $request->all();
        \App\Models\Soal::create($data);
        return redirect()->route('soal.index')->with('success', 'Soal successfully created');
    }
}
