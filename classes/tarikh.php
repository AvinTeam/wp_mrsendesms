<?php
namespace smsclass;

class tarikh
{

    public function gregorianToPersian($year, $month, $day)
    {
        // معادله تبدیل سال میلادی به شمسی
        $gYear = $year - 621;

        // تعداد روزهای گذشته در سال میلادی
        $totalDays = ($year - 1) * 365 + floor(($year - 1) / 4);

        // محاسبه روز‌های ماه‌های میلادی
        $daysInMonth = [ 31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31 ];
        $daysPast    = 0;
        for ($i = 0; $i < $month - 1; $i++) {
            $daysPast += $daysInMonth[ $i ];
        }
        $daysPast += $day;

        $totalDays += $daysPast;

        // تاریخ شمسی
        $shYear  = $gYear;
        $shMonth = floor(($totalDays - 1) / 31) + 1;
        $shDay   = ($totalDays - 1) % 31 + 1;

        return [ $shYear, $shMonth, $shDay ];
    }

    public function persianToGregorian($year, $month, $day)
    {
        // معادله تبدیل سال شمسی به میلادی
        $gYear = $year + 621;

        // ماه و روز در سال میلادی
        $gMonth = 0;
        $gDay   = 0;

        // تعداد روزهای ماه‌های شمسی
        $daysInMonth = [ 31, 31, 31, 30, 30, 30, 31, 31, 30, 30, 30, 29 ];

        $daysPast = 0;
        for ($i = 0; $i < $month - 1; $i++) {
            $daysPast += $daysInMonth[ $i ];
        }
        $daysPast += $day;

        // محاسبه تعداد روزهای گذشته از ابتدای سال میلادی
        $totalDays = ($gYear - 1) * 365 + floor(($gYear - 1) / 4);

        // محاسبه تاریخ میلادی
        $totalDays += $daysPast;

        $gDay   = $totalDays % 365;
        $gMonth = floor($gDay / 30); // بر اساس ماه‌های میلادی معمولی
        $gDay   = $gDay % 30;

        return [ $gYear, $gMonth + 1, $gDay + 1 ];
    }

    public function tarikh($data, $type = '')
    {

        $data_array = explode(" ", $data);

        $data = $data_array[ 0 ];
        $time = (sizeof($data_array) >= 2) ? $data_array[ 1 ] : 0;

        $has_mode = (strpos($data, '-')) ? '-' : '/';

        list($y, $m, $d) = explode($has_mode, $data);

        $ch_date = (strpos($data, '-')) ? $this->gregorianToPersian($y, $m, $d, '/') : $this->persianToGregorian($y, $m, $d, '-');

        if ($type == 'time') {
            $new_date = $time;
        } elseif ($type == 'date') {
            $new_date = $ch_date;
        } else {
            $new_date = ($time === 0) ? $ch_date : $ch_date . ' ' . $time;
        }

        return $new_date;

    }

}
