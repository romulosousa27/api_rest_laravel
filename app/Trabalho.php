<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Empresa;

class Trabalho extends Model
{
    protected $fillable = ['titulo', 'descricao', 'local', 'remote', 'tipo', 'empresa_id'];
    protected $dates = ['deleted_at'];

    public function empresa() {
        return $this->belongsTo(Empresa::class);
    }
}
