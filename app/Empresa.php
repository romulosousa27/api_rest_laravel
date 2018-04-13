<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use app\Trabalho;

class Empresa extends Model
{
    protected $fillable = ['nome', 'email', 'website', 'logo', 'senha'];
    protected $hidden = ['senha'];
    protected $dates = ['deleted_at'];

    public function trabalhos(){
        return $this->hasMany(Trabalho::class);
    }
}
