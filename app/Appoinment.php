<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Appoinment extends Model
{
  protected $fillable =[
    'description',
    'specialty_id',
    'doctor_id',
    'patient_id',
    'scheduled_date',
    'scheduled_time',
    'type'
  ];


  //n citas a 1 cita
  public function specialty()
  {
    return $this->belongsTo(Specialty::class);
  }

  //n citas y 1 doctor
  public function doctor()
  {
    return $this->belongsTo(User::class);
  }

  //n citas y 1 pacientes
  public function patient()
  {
    return $this->belongsTo(User::class);
  }
  // 1- 1
  //citas y citas canceladas
  public function cancellation()
  {
    return $this->hasOne(CancelledAppointment::class);
  }

  //accesor
  public function getScheduledTime12Attribute(){
    return (new Carbon($this->scheduled_time))
    ->format('g:i A');
  }
}
