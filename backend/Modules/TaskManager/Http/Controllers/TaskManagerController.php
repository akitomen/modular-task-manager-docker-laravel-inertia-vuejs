<?php

namespace Modules\TaskManager\Http\Controllers;

use Illuminate\Support\Carbon;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Modules\TaskManager\Entities\Task;
use Modules\TaskManager\Http\Requests\StoreRequest;
use Modules\TaskManager\Http\Requests\UpdateRequest;
use Modules\TaskManager\Restrictions\Shortcuts;
use Modules\TaskManager\TaskBuilder;

class TaskManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Inertia\Response|\Inertia\ResponseFactory
     */
    public function index()
    {
        try {
            $collection = (new TaskBuilder)
                ->setModel(auth()->user()->tasks())
                ->getTasks();

            return inertia('Tasks/Index', [
                'tasks' => [
                    'today' => $collection->getToday(),
                    'tomorrow' => $collection->getTomorrow(),
                    'missed' => $collection->getMissed(),
                    'next_week' => $collection->getNextWeek(),
                    'after_week' => $collection->getAfterWeek(),
                ],
                'repeat_types' => Shortcuts::getRepeatTypes(),
                'repeats_properties' => Shortcuts::getRepeatsProperties(),
            ]);
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        try {
            $builder = (new TaskBuilder)
                ->setModel(auth()->user()->tasks())
                ->setTitle($request->validated('title'))
                ->setStartDate(Carbon::parse($request->validated('start_date')))
                ->setTime($request->validated('time'));

            if ($description = $request->validated('description'))
                $builder->setDescription($description);

            if ($endDate = $request->validated('end_date'))
                $builder->setEndDate(Carbon::parse($endDate));

            if ($request->repeat_type && $request->repeat_period)
                $builder->setRepeatBy($request->repeat_type, $request->repeat_period);

            $builder->storeTask();

            return back()->with('success', 'Success!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function completed(UpdateRequest $request, $task_id)
    {
        try {
            (new TaskBuilder)->setModel(Task::findOrFail($task_id))
                ->setStartDate(Carbon::parse($request->start_date))
                ->completeTask();
            return back()->with('success', 'Success!');
        }catch (\Exception $e){
            return back()->with('error', $e->getMessage());
        }
    }

    public function chainEnd(UpdateRequest $request, $task_id)
    {
        try {
            (new TaskBuilder)->setModel(Task::findOrFail($task_id))
                ->setStartDate(Carbon::parse($request->start_date))
                ->chainEndTask();
            return back()->with('success', 'Success!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }
}
