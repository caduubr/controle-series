<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeriesController extends Controller
{
    public function index() 
    {
        //return redirect(to: 'https://google.com.br'); 

        $series = Serie::query()->orderBy('nome')->get();
        // dd($series);

        // return view('series.index', compact('series'));
        return view('series.index') -> with('series', $series); 
    }

    public function create() 
    {
        return view('series.create');
    }

    public function store(Request $request)
    {
        $nomeSerie = $request->input('nome');
        $serie = new Serie();
        $serie->nome = $nomeSerie;
        $serie->save();

        return redirect('/series');

    }
}
