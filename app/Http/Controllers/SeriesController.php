<?php

namespace App\Http\Controllers;

use App\Models\Serie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SeriesController extends Controller
{
    public function index(Request $request) 
    {
        //return redirect(to: 'https://google.com.br'); 

        $series = Serie::query()->orderByRaw('LOWER(nome)')->get();
        // dd($series);
        $mensagemSucesso = $request->session()->get('mensagem.sucesso');
        //forma nao tao funcional de exebir a mensagem
        //$request->session()->forget('mensagem.sucesso');

        // return view('series.index', compact('series'));
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
        session()->flash('mensagem.sucesso', "Série '{$serie->nome}' foi adicionada");

        return to_route('series.index');

    }

    public function destroy(Serie $series, Request $request) 
    {
        
        //Serie::destroy($request->series); // metodo antigo
        $series->delete();
        // $request->session()->put('mensagem.sucesso', 'Série removida.'); - forma que precisa de outra requisição para exibir uma mensagem
        session()->flash('mensagem.sucesso', "Série '{$series->nome}' removida."); // flash mensage limpa a mensagem exibida de forma automatica
        
        return to_route('series.index');
    }
}
