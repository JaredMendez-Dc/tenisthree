<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Cliente;

class Teni extends Model
{
    /** @use HasFactory<\Database\Factories\TeniFactory> */
    use HasFactory;
    
    protected $fillable = ['model', 'marca', 'color', 'precio', 'talla', 'material', 'categoria', 'image'];

    public function clientes() : BelongsToMany
    {
        return $this->belongsToMany(Cliente::class);
    }
}
