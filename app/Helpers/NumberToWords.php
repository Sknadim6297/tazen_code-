<?php

namespace App\Helpers;

class NumberToWords
{
    private static $ones = [
        0 => 'Zero', 1 => 'One', 2 => 'Two', 3 => 'Three', 4 => 'Four', 5 => 'Five',
        6 => 'Six', 7 => 'Seven', 8 => 'Eight', 9 => 'Nine', 10 => 'Ten',
        11 => 'Eleven', 12 => 'Twelve', 13 => 'Thirteen', 14 => 'Fourteen', 15 => 'Fifteen',
        16 => 'Sixteen', 17 => 'Seventeen', 18 => 'Eighteen', 19 => 'Nineteen'
    ];

    private static $tens = [
        2 => 'Twenty', 3 => 'Thirty', 4 => 'Forty', 5 => 'Fifty',
        6 => 'Sixty', 7 => 'Seventy', 8 => 'Eighty', 9 => 'Ninety'
    ];

    public static function convert($amount)
    {
        $amount = number_format($amount, 2, '.', '');
        $parts = explode('.', $amount);
        $rupees = (int) $parts[0];
        $paise = (int) $parts[1];

        $result = '';

        if ($rupees == 0) {
            $result = 'Zero Rupees';
        } else {
            $result = self::convertNumber($rupees) . ' Rupees';
        }

        if ($paise > 0) {
            $result .= ' and ' . self::convertNumber($paise) . ' Paise';
        }

        return $result;
    }

    private static function convertNumber($number)
    {
        if ($number == 0) {
            return '';
        }

        $result = '';

        // Handle crores
        if ($number >= 10000000) {
            $crores = intval($number / 10000000);
            $result .= self::convertHundreds($crores) . ' Crore ';
            $number = $number % 10000000;
        }

        // Handle lakhs
        if ($number >= 100000) {
            $lakhs = intval($number / 100000);
            $result .= self::convertHundreds($lakhs) . ' Lakh ';
            $number = $number % 100000;
        }

        // Handle thousands
        if ($number >= 1000) {
            $thousands = intval($number / 1000);
            $result .= self::convertHundreds($thousands) . ' Thousand ';
            $number = $number % 1000;
        }

        // Handle hundreds
        if ($number >= 100) {
            $hundreds = intval($number / 100);
            $result .= self::$ones[$hundreds] . ' Hundred ';
            $number = $number % 100;
        }

        // Handle remaining number
        if ($number > 0) {
            $result .= self::convertTens($number);
        }

        return trim($result);
    }

    private static function convertHundreds($number)
    {
        $result = '';

        if ($number >= 100) {
            $hundreds = intval($number / 100);
            $result .= self::$ones[$hundreds] . ' Hundred ';
            $number = $number % 100;
        }

        if ($number > 0) {
            $result .= self::convertTens($number);
        }

        return trim($result);
    }

    private static function convertTens($number)
    {
        if ($number < 20) {
            return self::$ones[$number];
        }

        $tens = intval($number / 10);
        $ones = $number % 10;

        $result = self::$tens[$tens];
        if ($ones > 0) {
            $result .= ' ' . self::$ones[$ones];
        }

        return $result;
    }
}
