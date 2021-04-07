<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'dni', 'address', 'phone', 'role'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'pivot',
            'email_verified_at',
            'created_at',
            'updated_at'

    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

//relacion muchos a muchos con especialidad
    public function specialties()
    {
        // $user->specialties
        return $this->belongsToMany(Specialty::class)->withTimesTamps();
    }

    public function scopePatients($query)
    {
        return $query->where('role', 'patient');
    }

    public function scopeDoctors($query)
    {
      return $query->where('role', 'doctor');
    }

    public function asDoctorAppointments()
    {
      return $this->hasMany(Appoinment::class, 'doctor_id');
    }

    public function attendedAppointments()
    {
      return $this->asDoctorAppointments()->where('status', 'Atendida');
    }

    public function cancelledAppointments()
    {
      return $this->asDoctorAppointments()->where('status', 'Cancelada');
    }

    public function asPatientAppointments()
    {
      return $this->hasMany(Appoinment::class, 'patient_id');
    }
}
