<?php

namespace App\Http\Livewire\Admin\Reports;

use Livewire\Component;

use App\Models\Appointment;



class AppointmentReports extends Component
{
    public $appointmentReports;
    public function render()
    { 
        $this->appointmentReports = Appointment::all();
        return view('livewire.admin.reports.appointment-reports');
    }
}
