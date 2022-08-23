<?php

namespace Modules\TaskManager\Restrictions\Recurrencable;

use Carbon\CarbonPeriod;
use DateInterval;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Modules\TaskManager\Contracts\RecurrencableInterface;
use Modules\TaskManager\TaskBuilder;

class Monthly implements RecurrencableInterface
{

    public const TYPE_NAME = 'repeat_by_months';

    public static function className(): string
    {
        return 'Monthly';
    }

    public static function properties(): array
    {
        return [
            Carbon::JANUARY => now()->month(Carbon::JANUARY)->shortMonthName,
            Carbon::FEBRUARY => now()->month(Carbon::FEBRUARY)->shortMonthName,
            Carbon::MARCH => now()->month(Carbon::MARCH)->shortMonthName,
            Carbon::APRIL => now()->month(Carbon::APRIL)->shortMonthName,
            Carbon::MAY => now()->month(Carbon::MAY)->shortMonthName,
            Carbon::JUNE => now()->month(Carbon::JUNE)->shortMonthName,
            Carbon::JULY => now()->month(Carbon::JULY)->shortMonthName,
            Carbon::AUGUST => now()->month(Carbon::AUGUST)->shortMonthName,
            Carbon::SEPTEMBER => now()->month(Carbon::SEPTEMBER)->shortMonthName,
            Carbon::OCTOBER => now()->month(Carbon::OCTOBER)->shortMonthName,
            Carbon::NOVEMBER => now()->month(Carbon::NOVEMBER)->shortMonthName,
            Carbon::DECEMBER => now()->month(Carbon::DECEMBER)->shortMonthName
        ];
    }

    public function setRepeatBy(array $yearMonths): Collection
    {
        return collect([
            'type' => self::TYPE_NAME,
            'period' => $yearMonths
        ]);
    }

    /**
     * @param array $yearMonths
     * @param Carbon $startDate
     * @param Carbon|null $endDate
     * @return Collection
     */
    public function getRepeatBy(array $yearMonths, Carbon $startDate, Carbon $endDate = null): Collection
    {
        if (!$endDate)
            $endDate = Carbon::parse($startDate)->addYear();

        $result = collect();

        $periods = CarbonPeriod::create(
            $startDate,
            $endDate,
            new DateInterval('P1M')
        );

        foreach ($periods as $period) {
            if (in_array($period->month, $yearMonths))
                $result[] = $period;
        }

        return $result;
    }

}
