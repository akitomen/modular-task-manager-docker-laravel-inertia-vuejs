<?php


namespace Modules\TaskManager\API\V1\Controllers;

use Modules\TaskManager\Restrictions\Shortcuts;
use Modules\TaskManager\TaskBuilder;

class TaskManager
{
    public function index()
    {
        $collection = (new TaskBuilder)
            ->setModel(auth()->user()->tasks())
            ->getTasks();

        return response()->json([
            'today' => $collection->getToday(),
            'tomorrow' => $collection->getTomorrow(),
            'missed' => $collection->getMissed(),
            'next_week' => $collection->getNextWeek(),
            'after_week' => $collection->getAfterWeek(),
        ]);

    }
}
