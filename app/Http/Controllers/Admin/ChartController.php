<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Appoinment;
use App\User;
use DB;
use Carbon\Carbon;
class ChartController extends Controller
{
    public function appointments()
    {
      $monthlyCounts = Appoinment::select(DB::raw('MONTH(created_at) as month'),
      DB::raw('COUNT(1) as cantidad'))
      ->groupBy('month')->get()
      ->toArray();

      $counts = array_fill(0, 12, 0);
      foreach ($monthlyCounts as $monthlyCounts) {
        $index = $monthlyCounts['month']-1;
        $counts[$index] = $monthlyCounts['cantidad'];
      }
    //  dd($counts);
      return view('charts.appointments', compact('counts'));
    }

    public function doctors()
    {
      $now = Carbon::now();
      $end = $now->format('Y-m-d');
      $start = $now->subYear()->format('Y-m-d');
        return view('charts.doctors', compact('start','end'));
    }

    public function doctorsJson(Request $request)
    {

      $start = $request->input('start');
      $end = $request->input('end');

      $doctors = User::doctors()
      ->select('name')
      ->withCount([
        'attendedAppointments' =>function($query) use ($start, $end){
          $query->whereBetween('scheduled_date', [$start, $end]);
        },
        'cancelledAppointments' =>function($query) use ($start, $end){
          $query->whereBetween('scheduled_date', [$start, $end]);
        }
      ])
      ->orderBy('attended_Appointments_count', 'desc')
      ->take(5)//limita la consulta
      ->get();
//      dd($doctors->pluck('name'));


      $data= [];
      $data['categories'] = $doctors->pluck('name');

      $series=[];
      //Citas atendidas
      $series1['name']='Citas Atendidas';
      $series1['data']= $doctors->pluck('attended_appointments_count');
      //Citas canceladas
      $series2['name']='Citas Canceladas';
      $series2['data']= $doctors->pluck('cancelled_appointments_count');
      $series[] = $series1;
      $series[] = $series2;
      $data['series']=$series;

      return $data;
    }
}
