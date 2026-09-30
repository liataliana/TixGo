<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Booking;

class TicketPrintController extends Controller
{
    public function download($code)
    {
        $booking = Booking::where('booking_code', $code)->with('flight', 'user')->firstOrFail();
        $pdf = Pdf::loadView('pdf.eticket', compact('booking'));
        return $pdf->download('E-Ticket-'.$code.'.pdf');
    }
}