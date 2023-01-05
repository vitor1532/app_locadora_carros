<?php

namespace App\Http\Controllers;

use App\Models\Modelo;
use App\Repositories\ModeloRepository;
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $modeloRepository = new ModeloRepository($this->modelo);
        $modelos = [];

        if($request->has('attr_marca')) {
            $attr_marca = $request->attr_marca;

            $modeloRepository->selectAtributosRegistrosRelacionados('marca:id,'.$attr_marca);
        } else {
            $modeloRepository->selectAtributosRegistrosRelacionados('marca');
        }

        if($request->has('filtro')) {
            $modeloRepository->filtro($request->filtro);
        }

        if($request->has('attr')) {

            $attr = $request->attr;
            $modeloRepository->selectAtributos($attr);
            //$marcas = $marcas->selectRaw($attr)->get();

        }

        return response()->json($modeloRepository->getResultPaginado(4), 200);
        //dd($request->get('attr'))

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
        $imagem_urn = $image->store('imagens/modelos', 'public');

        //$air_bag = filter_var($request->air_bag, FILTER_VALIDATE_BOOLEAN);
        //$abs = filter_var($request->air_bag, FILTER_VALIDATE_BOOLEAN);

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
        $modelo = $this->modelo->with('marca')->find($id);
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
     * @param  \App\Models\Modelo  $modelo
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, Modelo $modelo)
    {
        if($modelo === null) {
            return response()->json(['erro' => 'registro não encontrado'], 404);
        }

        if($request->method() === 'PATCH') {

            $regrasDinamicas = array();

            foreach($modelo->rules() as $input => $regra) {

                if(array_key_exists($input, $request->all())) {
                    $regrasDinamicas[$input] = $regra;
                }
            }

            if($request->file('imagem')) {
                Storage::disk('public')->delete($modelo->imagem);
            }

            $request->validate($regrasDinamicas);

            if(count($request->all()) > 1){

                foreach($request->all() as $input => $attr) {

                    switch($input) {
                        case $input:
                            $modelo->update([
                                $input => $attr
                            ]);
                    }
                }

                //checa se a imagem não é nula e insere os dados
                if($request->imagem !== null) {
                    $imagem = $request->file('imagem');
                    $imagem_urn = $imagem->store('imagens/modelos', 'public');
                    $modelo->update([
                        'imagem' => $imagem_urn,
                    ]);
                }
            } else {

                return ['msg' => 'o $request->all() retornou null'];
            }


        } else if ($request->method() === 'PUT') {

            //dd('put');
            $request->validate($modelo->rules());

            $image = $request->file('imagem');

            Storage::disk('public')->delete($modelo->imagem);
            $imagem_urn = $image->store('imagens/modelos', 'public');
            $modelo->update([
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $modelo = $this->modelo->find($id);
        if($modelo === null) {
            return response()->json(['erro' => 'registro não encontrado'], 404);
        }

        Storage::disk('public')->delete($modelo->imagem);

        $modelo->delete();
        $msg = ['msg' => 'O modelo '."'".$modelo->nome."'".' foi deletada com sucesso'];
        return response()->json($msg, 200);
    }
}
