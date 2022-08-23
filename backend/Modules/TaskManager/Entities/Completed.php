<?php

namespace Modules\TaskManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Completed extends Model
{
    use HasFactory;

    protected $table;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config()->get('taskmanager.table_prefix').'completed';
    }

    protected $fillable = [
        'task_id',
        'start_date',
        'completed_at'
    ];

    protected $casts = [
        'start_date' => 'date',
        'completed_at' => 'datetime',
    ];

    protected static function newFactory()
    {
        return \Modules\TaskManager\Database\factories\ComplatedFactory::new();
    }
}
