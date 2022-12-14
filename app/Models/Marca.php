<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Marca extends Model
{
    use HasFactory;
    protected $fillable = ['nome', 'imagem'];

    public function rules() {
        return  [
            'nome' => 'required|unique:marcas,nome,'.$this->id.'|min:3',
            'imagem' => 'required|mimes:png|file'
        ];
    }

    public function feedback() {

        return [
            'required' => 'O campo :attribute é obrigatório',
            'unique' => 'A marca indicada já existe',
            'imagem.mimes' => 'O arquivo deve ser uma imagem do tipo png'
        ];

    }

    public function modelos() {
        //uma marca possui muitos modelos
        return $this->hasMany('App\Models\Modelo');
    }
}
