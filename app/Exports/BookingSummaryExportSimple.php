<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BookingSummaryExport implements FromArray, WithHeadings
{
    protected $bookings;
    
    public function __construct($bookings)
    {
        $this->bookings = $bookings;
    }

    public function array(): array
    {
        $data = [];
        
        foreach ($this->bookings as $booking) {
            $data[] = [
                $booking->id,
                $booking->customer_name,
                $booking->customer_email,
                $booking->customer_phone,
                $booking->professional ? $booking->professional->name : '',
                $booking->professional ? $booking->professional->email : '',
                $booking->professional ? $booking->professional->phone : '',
                $booking->service_name,
                $booking->session_type,
                $booking->plan_type,
                $booking->booking_date,
                $booking->time_slot,
                $booking->payment_status,
                $booking->base_amount,
                $booking->cgst_amount,
                $booking->sgst_amount,
                $booking->igst_amount,
                $booking->amount,
                $booking->payment_status,
                'Razorpay',
                $booking->paid_date,
                $booking->base_amount * 0.85,
                $booking->amount - ($booking->base_amount * 0.85),
                '',
                '',
                '',
                '',
                $booking->remarks,
                $booking->created_at ? $booking->created_at->format('Y-m-d H:i:s') : '',
                $booking->updated_at ? $booking->updated_at->format('Y-m-d H:i:s') : ''
            ];
        }
        
        return $data;
    }

    public function headings(): array
    {
        return [
            'Booking ID',
            'Customer Name',
            'Customer Email',
            'Customer Phone',
            'Professional Name',
            'Professional Email',
            'Professional Phone',
            'Service Name',
            'Session Type',
            'Plan Type',
            'Booking Date',
            'Time Slot',
            'Payment Status',
            'Base Amount',
            'CGST Amount',
            'SGST Amount',
            'IGST Amount',
            'Total Amount',
            'Payment Status',
            'Payment Method',
            'Payment Date',
            'Professional Payout',
            'Platform Revenue',
            'Address',
            'City',
            'State',
            'Pincode',
            'Remarks',
            'Created At',
            'Updated At'
        ];
    }
}
