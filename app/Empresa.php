<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Trabalho;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;

class Empresa extends Model implements AuthenticatableContract, CanResetPasswordContract
{
    use Authenticatable, CanResetPassword;

    protected $fillable = ['nome', 'email', 'website', 'logo', 'senha'];
    protected $hidden = ['senha'];
    protected $dates = ['deleted_at'];

    public function trabalhos(){
        return $this->hasMany(Trabalho::class);
    }
}
