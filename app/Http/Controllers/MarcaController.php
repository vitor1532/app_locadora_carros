<?php

namespace App\Http\Controllers;

use App\Models\Marca;
use Illuminate\Http\Request;

class MarcaController extends Controller
{

    public function __construct(Marca $marca) {
        $this->marca = $marca;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$marcas = Marca::all();
        $marcas = $this->marca->all();
        return response()->json($marcas, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {

        $request->validate($this->marca->rules(), $this->marca->feedback());

        /*
         * Como acessar input text
         * dd($request->nome);
         * dd($request->get('nome');
         * dd($request->input('nome);
         * */

        /*
         * Como acessar input file
         * dd($request->imagem);
         * dd($request->file('imagem');
         * */
        $image = $request->file('imagem');
        $imagem_urn = $image->store('imagens', 'public');

        $marca = $this->marca->create([
            'nome' => $request->nome,
            'imagem' => $imagem_urn,
        ]);

        return response()->json($marca, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $marca = $this->marca->find($id);
        if($marca === null) {
            return response()->json(['erro' => 'registro não encontrado'], 404);
        }
        return response()->json($marca, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Marca  $marca
     * @return \Illuminate\Http\Response
     */
    public function edit(Marca $marca)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Integer
     * @return array
     */
    public function update(Request $request, $id)
    {
        $marca = $this->marca->find($id);
        //dd($request->file('imagem'));
        //dd($request->nome);
        if($marca === null) {
            return response()->json(['erro' => 'registro não encontrado'], 404);
        }

        if($request->method() === 'PATCH') {
            //dd($request->nome);
            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no model
            foreach($marca->rules() as $input => $regra) {

                //coletar apenas regras aplicaveis
                if(array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas, $marca->feedback());

            $image = $request->file('imagem');
            if($image !== null) {
                $imagem_urn = $image->store('imagens', 'public');
                $marca->update([
                    'imagem' => $imagem_urn,
                ]);
            } else {
                $marca->update([
                    'nome' => $request->nome,
                ]);
            }

        } else {
            $request->validate($marca->rules(), $marca->feedback());

            $image = $request->file('imagem');
            $imagem_urn = $image->store('imagens', 'public');
            $marca->update([
                'nome' => $request->nome,
                'imagem' => $imagem_urn,
            ]);
        }

        //dd($request->file('imagem'));


        return response()->json($marca, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $marca = $this->marca->find($id);
        if($marca === null) {
            return response()->json(['erro' => 'registro não encontrado'], 404);
        }
        $marca->delete();
        $msg = ['msg' => 'A marca '."'".$marca->nome."'".' foi deletada com sucesso'];
        return response()->json($msg, 200);
    }
}
