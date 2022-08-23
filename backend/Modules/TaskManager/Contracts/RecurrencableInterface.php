<?php

namespace Modules\TaskManager\Contracts;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Modules\TaskManager\TaskBuilder;

interface RecurrencableInterface
{

    public static function className(): string;

    public static function properties(): array;

    public function setRepeatBy(array $array): Collection;

    public function getRepeatBy(array $array, Carbon $startDate, Carbon $endDate = null): Collection;

}
