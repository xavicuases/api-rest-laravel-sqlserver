<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'Categorias';
    protected $primaryKey = 'CategoriaID';
    public $timestamps = false;
    public function productos()
    {
        return $this->hasMany(Producto::class, 'CategoriaID', 'CategoriaID');
    }

}
