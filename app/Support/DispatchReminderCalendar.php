<?php

namespace App\Support;

use Illuminate\Support\Carbon;

final class DispatchReminderCalendar
{
    /** 是否為週末（週六、週日）。 */
    public static function isHoliday(Carbon $date): bool
    {
        return $date->isWeekend();
    }

    /**
     * @param bool $remindOnHolidays 是否勾選「假日提醒」
     */
    public static function allowsRemindersToday(bool $remindOnHolidays, Carbon $date): bool
    {
        if ($remindOnHolidays) {
            return true;
        }

        return !self::isHoliday($date);
    }
}
