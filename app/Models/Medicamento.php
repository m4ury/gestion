<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Medicamento extends Model
{
    protected $fillable = ['descripcion' , 'presentacion', 'unidad', 'stock_max'];

    use HasFactory;
}
