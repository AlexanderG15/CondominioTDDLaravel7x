<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bloco extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['numero', 'quantidade_apartamento', 'condominio_id'];
}
