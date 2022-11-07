<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\User;


class Calculo extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'vf', 'a', 't','vi'];

    //Relacion uno a muchos inversa con users
    public function user(){
        return $this->belongsTo(User::class);
    }
}
/*
class Calculo extends Model
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    /*protected $fillable = [
        'user_id',
        'vf',
        'a',
        't',
        'vi'
    ];*/

    //protected $table = 'calculos';
    //protected $primaryKey = 'id';

    //Relacion uno a muchos inversa con users
   /* public function user(){
        return $this->belongsTo(User::class);
    }
}*/
