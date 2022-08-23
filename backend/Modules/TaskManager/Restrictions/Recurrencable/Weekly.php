<?php

namespace Modules\TaskManager\Restrictions\Recurrencable;

use Carbon\CarbonPeriod;
use DateInterval;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Modules\TaskManager\Contracts\RecurrencableInterface;
use Modules\TaskManager\TaskBuilder;

class Weekly implements RecurrencableInterface
{

    public const TYPE_NAME = 'repeat_by_days';

    public static function className(): string
    {
        return 'Weekly';
    }

    public static function properties(): array
    {
        return [
            Carbon::MONDAY => now()->weekday(Carbon::MONDAY)->shortDayName,
            Carbon::TUESDAY => now()->weekday(Carbon::TUESDAY)->shortDayName,
            Carbon::WEDNESDAY => now()->weekday(Carbon::WEDNESDAY)->shortDayName,
            Carbon::THURSDAY => now()->weekday(Carbon::THURSDAY)->shortDayName,
            Carbon::FRIDAY => now()->weekday(Carbon::FRIDAY)->shortDayName,
            Carbon::SATURDAY => now()->weekday(Carbon::SATURDAY)->shortDayName,
            Carbon::SUNDAY => now()->weekday(Carbon::SUNDAY)->shortDayName
        ];
    }

    public function setRepeatBy(array $weekDays): Collection
    {
        return collect([
            'type' => self::TYPE_NAME,
            'period' => $weekDays
        ]);
    }

    public function getRepeatBy(array $weekDays, Carbon $startDate, Carbon $endDate = null): Collection
    {

        if (!$endDate)
            $endDate = Carbon::parse($startDate)->addMonth();

        $result = collect();

        $periods = CarbonPeriod::create(
            $startDate,
            $endDate,
            new DateInterval('P1D')
        );

        foreach ($periods as $period) {
            if (in_array($period->weekday(), $weekDays))
                $result[] = $period;
        }

        return $result;
    }
}
