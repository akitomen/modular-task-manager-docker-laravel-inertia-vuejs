<?php

namespace Modules\TaskManager;

use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Modules\TaskManager\Contracts\RecurrencableInterface;

class TaskCollection extends Collection
{

    public function getToday()
    {
        $result = [];

        $models = $this->where('start_date', '<=', now());

        foreach ($models as $model) {

            if ($this->isRepeat($model)) {
                $repeatDate = $this->getRepeatValues($model, now()->startOfDay(), now()->addDay())->first();
                if ($repeatDate && !$this->isCompleted($model->completed, $repeatDate))
                    $result[] = $this->getValues($model, $repeatDate);

                continue;
            }

            if($model->start_date == now()->startOfDay() && !$model->completed->count())
                    $result[] = $this->getValues($model);
        }

        return $result;
    }

    public function getTomorrow()
    {
        $result = [];

        $models = $this->where('start_date', '<=', now()->addDay());

        foreach ($models as $model) {

            if ($this->isRepeat($model)) {

                $repeatDate = $this->getRepeatValues(
                    $model,
                    now()->addDay()->startOfDay(),
                    now()->addDays(2)->startOfDay()
                )->first();

                if ($repeatDate && !$this->isCompleted($model->completed, $repeatDate))
                    $result[] = $this->getValues($model, $repeatDate);

                continue;
            }

            if($model->start_date == now()->addDay()->startOfDay() && !$model->completed->count())
                    $result[] = $this->getValues($model);
        }

        return $result;
    }

    public function getNextWeek()
    {
        $result = [];

        foreach ($this as $model) {

            $startWeek = now()->addWeek()->startOfDay()->startOfWeek();
            $endWeek = now()->addWeek()->startOfDay()->endOfWeek();

            if ($this->isRepeat($model)) {

                $repeatDate = $this->getRepeatValues(
                    $model,
                    $startWeek,
                    $endWeek
                )->first();

                if ($repeatDate && !$this->isCompleted($model->completed, $repeatDate))
                    $result[] = $this->getValues($model, $repeatDate);

                continue;
            }

            if($model->start_date >= $startWeek && $model->start_date < $endWeek && !$model->completed->count())
                    $result[] = $this->getValues($model);
        }

        return $result;
    }

    public function getAfterWeek()
    {
        $result = [];

        foreach ($this as $model) {

            $startDate = now()->addWeek()->startOfDay()->endOfWeek()->addDay();

            if ($this->isRepeat($model)) {

                $repeatDate = $this->getRepeatValues(
                    $model,
                    $startDate
                )->first();

                if ($repeatDate && !$this->isCompleted($model->completed, $repeatDate))
                    $result[] = $this->getValues($model, $repeatDate);

                continue;
            }

            if($model->start_date >= $startDate && !$model->completed->count())
                    $result[] = $this->getValues($model);
        }

        return $result;
    }

    public function getMissed()
    {

        $result = [];

        foreach ($this as $model) {

            if ($this->isRepeat($model)) {

                $repeatDates = $this->getRepeatValues(
                    $model,
                    $model->start_date->startOfDay(),
                    now()->startOfDay()
                );
                foreach ($repeatDates as $repeatDate) {
                    if(!$this->isCompleted($model->completed, $repeatDate))
                        $result[] = $this->getValues($model, $repeatDate);
                }

                continue;
            }

            if($model->start_date == now()->addDay()->startOfDay() && !$model->completed->count())
                    $result[] = $this->getValues($model);
        }

        return $result;
    }

    private function isRepeat($model)
    {
        return !!$model->repeat;
    }

    private function isCompleted($completed, Carbon $date)
    {
        return !!$completed->firstWhere('start_date', $date->startOfDay());
    }

    private function getRepeatValues($model, Carbon $startDate, Carbon $endDate = null)
    {
        $recurrencableClass = config()->get('taskmanager.recurrencables');

        $repeatDates = $this->getRecurrencable(
            new $recurrencableClass[$model->repeat->type],
            $model->repeat->period,
            $model->start_date,
            $model->end_date
        );


        return $repeatDates->filter(function ($date) use ($startDate, $endDate) {
            if ($endDate)
                return $date >= $startDate && $date < $endDate;

            return $date >= $startDate;
        });


    }

    private function getValues($task, Carbon $currentStartData = null)
    {
        return [
            'id' => $task->id,
            'created_id' => $task->created_id,
            'created_name' => $task->createdModel->name,
            'title' => $task->title,
            'description' => $task->description,
            'time' => $task->time,
            'date' => $currentStartData ? $currentStartData->format('d.m.Y') : $task->start_date->format('d.m.Y'),
            'start_date' => $currentStartData ? $currentStartData->format('Y-m-d') : $task->start_date->format('Y-m-d'),
            'end_date' => $task->end_date ? $task->end_date->format('Y-m-d') : null,
            'repeat_type' => $task->repeat ? $task->repeat->type : null,
            'repeat_period' => $task->repeat ? $task->repeat->period : null,
        ];
    }

    private function getRecurrencable(RecurrencableInterface $recurrencable, array $array, Carbon $startDate, Carbon $endDate = null)
    {
        return $recurrencable->getRepeatBy($array, $startDate, $endDate);
    }

}
