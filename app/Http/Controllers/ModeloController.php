<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ModeloController extends Controller
{

    public function __construct(Modelo $modelo) {
        $this->modelo = $modelo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modelo = $this->modelo->all();
        return response()->json($modelo, 200);
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
     * @param \App\Models\Modelo $modelo
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\Response
     */
    public function store(Request $request, Modelo $modelo)
    {

        $request->validate($this->modelo->rules());


        $image = $request->file('imagem');
        $imagem_urn = $image->store('imagens', 'public');

        $modelo = $this->modelo->create([
            'marca_id' => $request->marca_id,
            'nome' => $request->nome,
            'imagem' => $imagem_urn,
            'numero_portas' => $request->numero_portas,//{1,2,3,4,5}
            'lugares' => $request->lugares,
            'air_bag' => $request->air_bag,
            'abs' => $request->abs,
        ]);

        return response()->json($modelo, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  integer
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $modelo = $this->modelo->find($id);
        if($modelo === null) {
            return response()->json(['erro' => 'registro não encontrado'], 404);
        }
        return response()->json($modelo, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\Response
     */
    public function edit(Modelo $modelo)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  integer
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $modelo = $this->modelo->find($id);
        //dd($request->file('imagem'));
        //dd($request->nome);
        if($modelo === null) {
            return response()->json(['erro' => 'registro não encontrado'], 404);
        }

        if($request->method() === 'PATCH') {
            //dd('PATCH');
            $regrasDinamicas = array();

            //percorrendo todas as regras definidas no model
            foreach($modelo->rules() as $input => $regra) {

                //coletar apenas regras aplicaveis
                if(array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas);


            $image = $request->file('imagem');

            dd($request);


            /*
            if($image !== null) {
                Storage::disk('public')->delete($modelo->imagem);
                $imagem_urn = $image->store('imagens', 'public');
                $modelo->update([
                    'imagem' => $imagem_urn,
                ]);
            } else {
                $modelo->update([
                    'nome' => $request->nome,
                ]);
            }*/

        } else if ($request->method() === 'PUT') {

            //dd('put');
            $request->validate($modelo->rules());

            $image = $request->file('imagem');
            Storage::disk('public')->delete($modelo->imagem);
            $imagem_urn = $image->store('imagens', 'public');
            $modelo->update([
                'marca_id' => $request->marca_id,
                'nome' => $request->nome,
                'imagem' => $imagem_urn,
                'numero_portas' => $request->numero_portas,//{1,2,3,4,5}
                'lugares' => $request->lugares,
                'air_bag' => $request->air_bag,
                'abs' => $request->abs,
            ]);
        }

        return response()->json($modelo, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Integer
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $modelo = $this->modelo->find($id);
        if($modelo === null) {
            return response()->json(['erro' => 'registro não encontrado'], 404);
        }

        Storage::disk('public')->delete($modelo->imagem);

        $modelo->delete();
        $msg = ['msg' => 'A marca '."'".$modelo->nome."'".' foi deletada com sucesso'];
        return response()->json($msg, 200);
    }
}
