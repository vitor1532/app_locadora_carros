<?php

namespace App\Http\Controllers;

use App\Models\Carro;
use App\Repositories\CarroRepository;
use Illuminate\Http\Request;

class CarroController extends Controller
{

    public function __construct(Carro $carro) {
        $this->carro = $carro;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {


        $carroRepository = new CarroRepository($this->carro);

        $carros = [];
        //-----------------------

        if($request->has('attr_modelo')) {
            $attr_modelo = $request->attr_modelo;

            $carroRepository->selectAtributosRegistrosRelacionados('modelo:marca_id,'.$attr_modelo);
        } else {
            $carroRepository->selectAtributosRegistrosRelacionados('modelo');
        }

        if($request->has('filtro')) {
            $carroRepository->filtro($request->filtro);
        }

        if($request->has('attr')) {

            $attr = $request->attr;
            $carroRepository->selectAtributos($attr);

        }

        return response()->json($carroRepository->getResult(), 200);
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
        $request->validate($this->carro->rules(), $this->carro->feedback());

        $carro = $this->carro->create([
            'modelo_id' => $request->modelo_id,
            'placa' => $request->placa,
            'disponivel' => $request->disponivel,
            'km' => $request->km
        ]);

        return response()->json($carro, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(Carro $carro)
    {
        $carro = $this->carro->with('modelo')->find($id);
        if ($carro === null) {
            return response()->json(['erro' => 'Recurso pesquisado não existe'], 404);
        }

        return response()->json($carro, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\Response
     */
    public function edit(Carro $carro)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Carro $carro)
    {
        $carro = $this->carro->find($id);

        if($carro === null) {
            return response()->json(['erro' => 'registro não encontrado'], 404);
        }

        if($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            foreach($carro->rules() as $input => $regra) {

                if(array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            $request->validate($regrasDinamicas);

        } else {
            $request->validate($carro->rules());
        }

        $carro->fill($request->all());
        $carro->save();

        return response()->json($carro, 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Carro  $carro
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Carro $carro)
    {
        $carro = $this->carro->find($id);
        if($carro === null) {
            return response()->json(['erro' => 'registro não encontrado'], 404);
        }

        $carro->delete();

        $msg = ['msg' => 'O carro '."'".$carro->placa."'".' foi deletada com sucesso'];
        return response()->json($msg, 200);
    }
}
