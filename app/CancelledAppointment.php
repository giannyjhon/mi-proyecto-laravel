<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CancelledAppointment extends Model
{
    public function cancelled_by(){
      //1 usuario cancela muchas citas
      return $this->belongsTo(User::class);
    }
}
