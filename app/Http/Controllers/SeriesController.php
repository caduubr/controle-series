<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeriesController extends Controller
{
    public function index(Request $request) 
    {
        $series = Serie::query()->orderByRaw('LOWER(nome)')->get();
        $mensagemSucesso = $request->session()->get('mensagem.sucesso');

        return view('series.index') -> with('series', $series)
            ->with('mensagemSucesso', $mensagemSucesso); 
    }

    public function create() 
    {
        return view('series.create');
    }

    public function store(Request $request)
    {
        $serie = Serie::create($request->all());

        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$serie->nome}' adicionada");
    }

    public function destroy(Serie $series) 
    {   
        $series->delete();
        
        return to_route('series.index')
            ->with('mensagem.sucesso', "Série '{$series->nome}' removida.");
    }

    public function edit(Serie $series)
    {
        return view('series.edit')->with('serie', $series);
    }

    public function update(Serie $series, Request $request)
    {
        $series->fill($request->all());
        $series->save();

        return to_route('series.index')
        ->with('mensagem.sucesso', "Série '{$series->nome}' atualizada.");
    }
}
