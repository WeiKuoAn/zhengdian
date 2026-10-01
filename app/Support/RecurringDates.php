<?php

namespace App\Support;

use Carbon\Carbon;

class RecurringDates
{
    public const MAX_DATES = 60;

    /**
     * 依日期區間與星期（0=日 … 6=六）展開日期；超過上限時多回傳一筆供呼叫端判斷。
     *
     * @param  array<int, int|string>  $weekdays
     * @return list<string>
     */
    public static function expand(string $start, string $end, array $weekdays): array
    {
        $wanted = array_map('intval', $weekdays);
        $cursor = Carbon::parse($start)->startOfDay();
        $last = Carbon::parse($end)->startOfDay();

        $dates = [];
        while ($cursor->lte($last)) {
            if (in_array($cursor->dayOfWeek, $wanted, true)) {
                $dates[] = $cursor->format('Y-m-d');
                if (count($dates) > self::MAX_DATES) {
                    break;
                }
            }
            $cursor->addDay();
        }

        return $dates;
    }

    /**
     * @param  list<string>  $dates
     */
    public static function label(array $dates): string
    {
        return implode('、', array_map(fn ($d) => Carbon::parse($d)->format('m/d'), $dates))
            .'（共 '.count($dates).' 次）';
    }
}
