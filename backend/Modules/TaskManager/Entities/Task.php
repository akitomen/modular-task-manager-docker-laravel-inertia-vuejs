<?php

namespace Modules\TaskManager\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Task extends Model
{
    use HasFactory;

    protected $table;

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->table = config()->get('taskmanager.table_prefix').'tasks';
    }

    protected $fillable = [
        'created_id',
        'created_type',
        'title',
        'description',
        'start_date',
        'end_date',
        'time'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    protected static function newFactory()
    {
        return \Modules\TaskManager\Database\factories\TaskFactory::new();
    }

    /**
     * @return MorphTo
     */
    public function createdModel(): MorphTo
    {
        return $this->morphTo('created');
    }

    public function repeat()
    {
        return $this->hasOne(Repeat::class);
    }

public function completed()
{
    return $this->hasMany(Completed::class);
}

}
