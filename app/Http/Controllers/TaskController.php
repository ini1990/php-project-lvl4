<?php

namespace App\Http\Controllers;

use App\Task;
use App\Label;
use App\User;
use App\TaskStatus;
use Illuminate\Http\Request;
use Spatie\QueryBuilder\QueryBuilder;
use Spatie\QueryBuilder\AllowedFilter;

class TaskController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name', 'id');
        $taskStatuses = TaskStatus::pluck('name', 'id');

        $tasks = QueryBuilder::for(Task::class)
        ->with(['status', 'labels', 'assignee', 'creator'])
        ->allowedFilters(
            AllowedFilter::exact('status_id'),
            AllowedFilter::exact('created_by_id'),
            AllowedFilter::exact('assigned_to_id'),
            AllowedFilter::exact('labels.id')
        )->get();

        return view('task.index', compact('tasks', 'labels', 'taskStatuses', 'users'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $taskStatuses = TaskStatus::pluck('name', 'id');
        $defaultStatus = $taskStatuses->search('new');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name');
        return view('task.create', compact('users', 'taskStatuses', 'defaultStatus', 'labels'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $labelIds = collect($request->input('labels'))
        ->map(fn ($name) => Label::firstOrCreate(compact('name'))->id);
        $validatedData = $request->validate([
            'name' => 'required',
            'status_id' => 'required',
            'description' => '',
            'assigned_to_id' => ''
        ]);

        Task::create($validatedData + ['created_by_id' => \Auth::id()])
        ->labels()->attach($labelIds);
        flash()->success(__('flashes.task.store'));
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $taskStatuses = TaskStatus::pluck('name', 'id');
        $defaultStatus = $taskStatuses->firstWhere('name', 'new');
        $users = User::pluck('name', 'id');
        $labels = Label::pluck('name');
        return view('task.edit', compact('task', 'users', 'taskStatuses', 'defaultStatus', 'labels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $this->validate($request, [
            'name' => 'required|max:255',
            'status_id' => 'required|max:255',
            'assigned_to_id' => 'max:255'
        ]);
        $labelIds = collect($request->input('labels'))
        ->map(fn ($name) => Label::firstOrCreate(compact('name'))->id);
        $task->fill($request->all())
        ->save();
        $task->labels()->sync($labelIds);
        flash()->success(__('flashes.task.update'));
        return redirect()->route('tasks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        \Gate::authorize('delete-task', $task);
        $task->labels()->detach();
        $task->delete();
        flash()->success(__('flashes.task.destroy'));

        return redirect()->route('tasks.index');
    }
}
