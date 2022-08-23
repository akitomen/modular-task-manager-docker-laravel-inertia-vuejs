<?php

namespace Modules\TaskManager\Traits;

use Illuminate\Database\Eloquent\Relations\MorphMany;
use Modules\TaskManager\Entities\Task;

trait TaskManagerTrait
{
    /**
     * @return MorphMany
     */
    public function tasks(): MorphMany
    {
        return $this->morphMany(Task::class, 'createdModel', 'created_type', 'created_id');
    }
}
