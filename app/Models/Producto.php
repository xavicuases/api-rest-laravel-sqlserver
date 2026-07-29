<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'Productos';
    protected $primaryKey = 'ProductoID';
    public $timestamps = false;
    protected $fillable = ['Nombre', 'Precio', 'Stock', 'CategoriaID'];
    
    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'CategoriaID', 'CategoriaID');
    }
}
