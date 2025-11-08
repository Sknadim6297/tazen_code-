<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use App\Models\Rate;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProfessionalAjaxController extends Controller
{
    /**
     * Return rates and enabled dates for a professional and optional sub-service
     */
    public function getRatesAndAvailability(Request $request)
    {
        $request->validate([
            'professional_id' => 'required|integer|exists:professionals,id',
            'professional_service_id' => 'nullable|integer',
            'sub_service_id' => 'nullable|integer',
        ]);

        $professionalId = (int) $request->input('professional_id');
        $professionalServiceId = $request->input('professional_service_id');
        $subServiceId = $request->input('sub_service_id');

        // Build rates query
        $ratesQuery = Rate::where('professional_id', $professionalId);
        if (!empty($subServiceId)) {
            $ratesQuery->where('sub_service_id', $subServiceId);
        } elseif (!empty($professionalServiceId)) {
            $ratesQuery->where('professional_service_id', $professionalServiceId);
        }

        $rates = $ratesQuery
            ->orderBy('final_rate')
            ->get(['session_type', 'num_sessions', 'final_rate']);

        // Compute enabled dates from availability across current and future months
        $enabledDates = [];
        $today = Carbon::today();
        $availabilityItems = Availability::with('availabilitySlots')
            ->where('professional_id', $professionalId)
            ->get();

        // Map weekday names to Carbon day numbers
        $weekdayMap = [
            'mon' => Carbon::MONDAY,
            'tue' => Carbon::TUESDAY,
            'wed' => Carbon::WEDNESDAY,
            'thu' => Carbon::THURSDAY,
            'fri' => Carbon::FRIDAY,
            'sat' => Carbon::SATURDAY,
            'sun' => Carbon::SUNDAY,
        ];

        foreach ($availabilityItems as $availability) {
            if (!$availability->month) {
                continue;
            }
            $year = (int) substr($availability->month, 0, 4);
            $monthNum = (int) substr($availability->month, 5, 2);

            $startDate = Carbon::create($year, $monthNum, 1);
            $endDate = $startDate->copy()->endOfMonth();

            // Skip months entirely in the past
            if ($endDate->lt($today)) {
                continue;
            }

            $availableWeekdays = $availability->availabilitySlots
                ->pluck('weekday')
                ->unique()
                ->toArray();

            if (empty($availableWeekdays)) {
                continue;
            }

            $current = $startDate->copy();
            while ($current->lte($endDate)) {
                if ($current->lt($today)) {
                    $current->addDay();
                    continue;
                }

                foreach ($availableWeekdays as $weekday) {
                    if (isset($weekdayMap[$weekday]) && $weekdayMap[$weekday] === $current->dayOfWeek) {
                        $enabledDates[] = $current->format('Y-m-d');
                        break;
                    }
                }

                $current->addDay();
            }
        }

        // Unique and sort dates
        $enabledDates = array_values(array_unique($enabledDates));
        sort($enabledDates);

        return response()->json([
            'success' => true,
            'rates' => $rates,
            'enabled_dates' => $enabledDates,
        ]);
    }
}
