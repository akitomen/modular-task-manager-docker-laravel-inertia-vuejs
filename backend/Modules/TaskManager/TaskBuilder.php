<?php

namespace Modules\TaskManager;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Modules\TaskManager\Contracts\RecurrencableInterface;
use Modules\TaskManager\Entities\Task;
use Modules\TaskManager\Restrictions\Recurrencable\Monthly;
use Modules\TaskManager\Restrictions\Recurrencable\Weekly;
use Modules\TaskManager\Restrictions\Shortcuts;

class TaskBuilder
{

    protected $model;
    protected Carbon $startDate;
    protected Carbon|null $endDate = null;
    protected string $title;
    protected string $description = '';
    protected string $time;
    protected array $repeatValues = [];

    public function __construct()
    {
        $this->model = new Task;
    }

    /**
     * @param Task $model
     * @return $this
     */
    public function setModel($model): TaskBuilder
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return Carbon
     */
    public function getStartDate(): Carbon
    {
        return $this->startDate;
    }

    /**
     * @param Carbon $startDate
     * @return $this
     */
    public function setStartDate(Carbon $startDate): TaskBuilder
    {
        $this->startDate = $startDate;
        return $this;
    }

    /**
     * @return Carbon|null
     */
    public function getEndDate(): Carbon|null
    {
        return $this->endDate;
    }


    /**
     * @param Carbon $endDate
     * @return $this
     */
    public function setEndDate(Carbon $endDate): TaskBuilder
    {
        $this->endDate = $endDate;
        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title): TaskBuilder
    {
        $this->title = $title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description): TaskBuilder
    {
        $this->description = $description;
        return $this;
    }

    /**
     * @return string
     */
    public function getTime(): string
    {
        return $this->time;
    }

    /**
     * @param string $time
     */
    public function setTime(string $time): TaskBuilder
    {
        $this->time = $time;
        return $this;
    }

    /**
     * @param string $type
     * @param array $period
     * @return $this
     * @throws \Exception
     */
    public function setRepeatBy(string $type, array $period): TaskBuilder
    {
        if ($this->repeatValues)
            throw new \Exception('It is forbidden to duplicate the Repeat value!');

        $classes = config()->get('taskmanager.recurrencables');

        $this->setRepeatValues(
            $this->setRecurrencable(new $classes[$type], $period)->toArray()
        );

        return $this;
    }

    private function checkAndGetStartDate()
    {
        $startDate = $this->getStartDate();
        $endDate = $this->getEndDate();

        if ($this->repeatValues) {
            $recurrencableClass = config()->get('taskmanager.recurrencables');
            $dates = $this->getRecurrencable(
                new $recurrencableClass[$this->repeatValues['type']],
                $this->repeatValues['period'],
                $startDate,
                $endDate
            );

            $startDate = $dates->sort()->first();
        }

        return $startDate;
    }

    /**
     * @return bool
     */
    public function storeTask(): bool
    {
        $exception = DB::transaction(function() {
            $task = $this->model->create([
                'title' => $this->getTitle(),
                'description' => $this->getDescription(),
                'start_date' => $this->checkAndGetStartDate(),
                'end_date' => $this->getEndDate(),
                'time' => $this->getTime(),
            ]);


            if ($this->repeatValues)
                $task->repeat()->create($this->repeatValues);
        });

        if ($exception)
            throw $exception;

        return true;
    }

    public function getTasks()
    {
        $tasks = $this->model
            ->with(['repeat', 'completed'])
            ->get();

        return new TaskCollection($tasks);
    }

    public function completeTask()
    {
        $completed = $this->model->completed()
            ->where(config()->get('taskmanager.table_prefix').'completed.start_date', $this->getStartDate())
            ->first();
        if($completed)
            throw new \Exception('Error dublicate complete task');

        $exception = DB::transaction(function() {
            $this->model->completed()->create([
                'start_date' => $this->getStartDate(),
                'completed_at' => now()
            ]);

            if(!$this->model->end_date || $this->model->end_date > now()->endOfDay()) {
                if(!empty($this->model->repeat))
                    $this->model->update([ 'start_date' => $this->getNextStartDate() ]);
            }


        });

        if ($exception)
            throw $exception;

        return true;
    }

    public function chainEndTask()
    {
        $exception = DB::transaction(function() {
            $this->model->update([
                'end_date'=>now()
            ]);

            if(!$this->model->end_date)
                $this->model->update(['end_date'=>now()]);
        });

        if ($exception)
            throw $exception;

        return true;
    }

    private function getNextStartDate()
    {
        $recurrencableClass = config()->get('taskmanager.recurrencables');
        $dates = $this->getRecurrencable(
            new $recurrencableClass[$this->model->repeat->type],
            $this->model->repeat->period,
            $this->model->start_date->addDay(),
            $this->model->end_date
        );

        return $dates->sort()->first();
    }

    private function setRepeatValues(array $repeatValues)
    {
        $this->repeatValues = $repeatValues;
    }

    private function setRecurrencable(RecurrencableInterface $recurrencable, array $array)
    {
        return $recurrencable->setRepeatBy($array);
    }

    private function getRecurrencable(RecurrencableInterface $recurrencable, array $array, Carbon $startDate, Carbon $endDate = null)
    {
        return $recurrencable->getRepeatBy($array, $startDate, $endDate);
    }

}
