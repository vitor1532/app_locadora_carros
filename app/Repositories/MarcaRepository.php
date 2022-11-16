<?php

    namespace App\Repositories;

    use Illuminate\Database\Eloquent\Model;

    class MarcaRepository {

        public function __construct(Model $model) {
            $this->model = $model;
        }
        public function selectAtributosRegistrosRelacionados($atributos) {
            $this->model = $this->model->with($atributos);
            //$marcas = $this->marca->with();
        }

        public function filtro($filtros) {
            $filtros = explode(';', $request->filtro);
            //dd($filtros);

            foreach($filtros as $key => $conditional) {

                $c = explode(':', $conditional);

                $this->model = $this->model->where($c[0], $c[1], $c[2]);
            }
        }

        public function selectAtributos($attr) {
            $this->model = $this->model->selectRaw($attr)->get();
        }

        public function getResult() {
            return $this->model->get();
        }

    }

?>
