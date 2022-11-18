<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carro extends Model
{
    use HasFactory;

    protected $fillable = ['modelo_id','placa', 'disponivel', 'km'];

    public function rules() {
        return  [
            'modelo_id' => 'exists:modelos,id',
            'placa' => 'required',
            'disponivel' => 'required',
            'km' => 'required|integer'
        ];
    }

    public function modelo() {
        //cada carro pertence a um modelo
        return $this->belongsTo('App\Models\Modelo');
    }
}
