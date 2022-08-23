<?php

namespace Modules\TaskManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Repeat extends Model
{
    use HasFactory;

    protected $table;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config()->get('taskmanager.table_prefix').'repeat';
    }

    protected $fillable = [
        'task_id',
        'type',
        'period'
    ];

    protected $casts = [
        'period' => 'array'
    ];

    protected static function newFactory()
    {
        return \Modules\TaskManager\Database\factories\RepeatFactory::new();
    }
}
