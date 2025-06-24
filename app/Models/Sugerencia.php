<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sugerencia extends Model
{
    use HasFactory;
    protected $fillable = [
        'sugerencia',
        'id_usuario_producto',
        'id_producto'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function prueba(){
        
    }
    
    
}
