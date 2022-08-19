<?php

namespace Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Task;
use User;

class TaskPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param  \User  $user
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \User  $user
     * @param  \Task  $task
     * @return mixed
     */
    public function view(User $user, Task $task)
    {
        return $user->tasks->firstWhere('id', $task->id);
    }

    /**
     * Determine wh her the user can create models.
     *
     * @param  \User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \User  $user
     * @param  \Task  $task
     * @return mixed
     */
    public function update(User $user, Task $task)
    {
        return true;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \User  $user
     * @param  \Task  $task
     * @return mixed
     */
    public function delete(User $user, Task $task)
    {
        //
    }

    /**
     * Determine whether the user can restore the model.
     *
     * @param  \User  $user
     * @param  \Task  $task
     * @return mixed
     */
    public function restore(User $user, Task $task)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     *
     * @param  \User  $user
     * @param  \Task  $task
     * @return mixed
     */
    public function forceDelete(User $user, Task $task)
    {
        //
    }
}
