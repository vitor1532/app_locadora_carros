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



    }

?>
