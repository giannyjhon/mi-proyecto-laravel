let $doctor, $date, $specialty, $hours;
let iRadio;
const noHoursalert = `<div class="alert alert-danger" role="alert">
<strong>Lo sentimos!</strong>No se encontro horas disponibles para
 el médico en el día seleccionado!
 </div>`;
 $(function () {
   $specialty =  $('#specialty');
   $doctor = $('#doctor');
   $date = $('#date');
   $hours = $('#hours');

   $specialty.change(()=>{
     const specialtyId = $specialty.val();
     const url = `/mi-proyecto-laravel/public/api/specialties/${specialtyId}/doctors`;
     $.getJSON(url, onDoctorLoaded);
   });

   //$specialty.change(loadHours);
   $doctor.change(loadHours);
   $date.change(loadHours);
 });

  function onDoctorLoaded(doctors) {
    let htmlOptions = '';
    doctors.forEach(doctor =>{
      htmlOptions += `<option value="${doctor.id}">${doctor.name}</option>`;
    });
    $doctor.html(htmlOptions);
    loadHours();
  }

  function loadHours(){
    const selectedDate = $date.val();
    const doctorId = $doctor.val();
    const url = `/mi-proyecto-laravel/public/api/schedule/hours?date=${selectedDate}&doctor_id=${doctorId}`;
    $.getJSON(url, displayHours);
  }

  function displayHours(data){
    if(!data.morning && !data.afternoon){
      $hours.html(noHoursalert);
      return;
    }
    let htmlHours = '';
      iRadio = 0;
    if(data.morning){
      const morning_intervals = data.morning;
      morning_intervals.forEach(interval => {
        htmlHours += getRadiointervalHtml(interval);
      });

    }

    if(data.afternoon){
      const afternoon_intervals = data.afternoon;
      afternoon_intervals.forEach(interval => {
        htmlHours += getRadiointervalHtml(interval);
      });

    }
    $hours.html(htmlHours);
  }

  function getRadiointervalHtml(interval){
    const text = `${interval.start} - ${interval.end}`;
    return `<div class="custom-control custom-radio mb-3">
  <input type="radio" id="interval${iRadio}" name="scheduled_time" class="custom-control-input" value="${interval.start}" required>
  <label class="custom-control-label" for="interval${iRadio++}">${text}</label>
</div>`;
  }
