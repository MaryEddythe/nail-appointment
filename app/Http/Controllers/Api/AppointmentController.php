<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AppointmentController extends Controller
{
    public function index()
    {
        $appointments = Appointment::all();
        return response()->json($appointments);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'required|string|max:20',
            'start_time' => 'required|date',
            'service_id' => 'required|exists:services,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $service = \App\Models\Service::find($request->service_id);
        
        $appointment = Appointment::create([
            'customer_name' => $request->customer_name,
            'customer_email' => $request->customer_email,
            'customer_phone' => $request->customer_phone,
            'start_time' => $request->start_time,
            'end_time' => \Carbon\Carbon::parse($request->start_time)->addMinutes($service->duration),
            'service_id' => $request->service_id,
        ]);

        return response()->json($appointment, 201);
    }

    public function availableSlots(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'date' => 'required|date',
            'service_id' => 'required|exists:services,id',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $service = \App\Models\Service::find($request->service_id);
        $date = \Carbon\Carbon::parse($request->date);
        
        // Business hours (example: 9 AM to 5 PM)
        $startTime = $date->copy()->setHour(9)->setMinute(0);
        $endTime = $date->copy()->setHour(17)->setMinute(0);
        
        // Existing appointments for the day
        $bookedAppointments = Appointment::whereDate('start_time', $date)
            ->get()
            ->map(function ($appointment) {
                return [
                    'start' => \Carbon\Carbon::parse($appointment->start_time),
                    'end' => \Carbon\Carbon::parse($appointment->end_time),
                ];
            });
        
        // Generate available slots
        $slots = [];
        $currentSlot = $startTime->copy();
        
        while ($currentSlot->addMinutes($service->duration)->lte($endTime)) {
            $slotEnd = $currentSlot->copy()->addMinutes($service->duration);
            
            $isAvailable = true;
            foreach ($bookedAppointments as $appointment) {
                if ($currentSlot->between($appointment['start'], $appointment['end']) || 
                    $slotEnd->between($appointment['start'], $appointment['end']) ||
                    ($currentSlot->lt($appointment['start']) && $slotEnd->gt($appointment['end']))) {
                    $isAvailable = false;
                    break;
                }
            }
            
            if ($isAvailable) {
                $slots[] = $currentSlot->format('Y-m-d H:i:s');
            }
            
            $currentSlot = $currentSlot->copy()->addMinutes(15); // 15-minute intervals between slots
        }
        
        return response()->json($slots);
    }
}
