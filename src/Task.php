<?php


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @method static create(array $all)
 */
class Task extends Model
{
    use SoftDeletes;

    protected $fillable = ['title', 'description', 'status'];

    public function users()
    {
        return $this->belongsToMany(User::class, 'task_user');
    }

    public function labels(){
        return $this->belongsToMany(Label::class, 'label_task');
    }
}
