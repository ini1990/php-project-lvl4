<?php

namespace App\Http\Controllers;

use App\Task;
use App\Label;
use Illuminate\Http\Request;

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
    public function index()
    {
        $tasks = Task::all();
        return view('task.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $taskStatuses = \App\TaskStatus::pluck('name', 'id');
        $defaultStatus = $taskStatuses->search('new');
        $users = \App\User::pluck('name', 'id');
        $labels = Label::pluck('name');
        //dd($labels);
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
            'assigned_to_id' => 'max:255'
        ]);

        Task::create($validatedData + ['created_by_id' => \Auth::id()])
        ->labels()->attach($labelIds);

        flash()->success(__('flashes.task.store'));
        return redirect()->route('tasks.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return view('task.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $taskStatuses = \App\TaskStatus::pluck('name', 'id');
        $defaultStatus = $taskStatuses->firstWhere('name', 'new');
        $users = \App\User::pluck('name', 'id');
        $labels = Label::pluck('name');
        return view('task.edit', compact('task', 'users', 'taskStatuses', 'defaultStatus', 'labels'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
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
     * @param  \App\Task  $task
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
