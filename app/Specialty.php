<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Specialty extends Model
{

  //relacion muchos a muchos con especialidad
  //$specialty->users
    public function users()
    {
      return $this->belongsToMany(User::class)->withTimesTamps();
    }
}
