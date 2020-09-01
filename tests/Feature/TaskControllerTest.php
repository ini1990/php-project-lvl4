<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Task;
use App\TaskStatus;
use App\User;
use App\Label;

class TaskControllerTest extends TestCase
{
    public function setUp(): void
    {

        parent::setUp();

        $this->withoutExceptionHandling();
        $this->user = factory(User::class)->create();
        $this->label = factory(Label::class)->create();
        $this->task = factory(Task::class)->create(['created_by_id' => $this->user->id]);
        $this->task->labels()->attach($this->label->id);
        $this->actingAs($this->user);
    }

    public function testIndex()
    {
        $response = $this->get(route('tasks.index'));
        $response->assertStatus(200);
        $response->assertSeeTextInOrder(Task::pluck('name', 'id')->all());
    }

    public function testCreate()
    {
        $response = $this->get(route('tasks.create'));
        $response->assertStatus(200);
        $response->assertSeeInOrder(User::pluck('name')->all());
        $response->assertSeeInOrder(TaskStatus::pluck('name')->all());
    }

    public function testStore()
    {
        $taskData = factory(Task::class)->make()->only('name', 'status_id', 'assigned_to_id');
        $labelData = factory(Label::class)->make()->only('name');
        $response = $this->post(route('tasks.store'), $taskData + ['labels' => $labelData]);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('tasks', $taskData);
        $this->assertDatabaseHas('labels', $labelData);

        $latestTask = Task::latest('id')->first();
        $latestLabel = Label::latest('id')->first();
        $this->assertEquals(
            $latestLabel->tasks()->first()->id,
            $latestTask->id
        );
        $this->assertDatabaseHas('label_task', [
            'task_id' => $latestTask->id,
            'label_id' => $latestLabel->id
        ]);
    }

    public function testShow()
    {
        $response = $this->get(route('tasks.show', $this->task));
        $response->assertStatus(200);
        $response->assertSeeTextInOrder($this->task->pluck('name', 'description')->all());
    }

    public function testEdit()
    {
        $response = $this->get(route('tasks.edit', $this->task));
        $response->assertOk();
        $response->assertSee($this->task->name);
    }

    public function testUpdate()
    {
        $updatedTask = factory(Task::class)->make(['created_by_id' => $this->user->id])->toArray();
        $response = $this->patch(route('tasks.update', $this->task), $updatedTask);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', $updatedTask);
        $this->assertDatabaseMissing('label_task', [
            'task_id' => $this->task->id, 'label_id' => $this->label->id
            ]);
    }

    public function testDestroy()
    {
        $response = $this->delete(route('tasks.destroy', $this->task));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));

        $this->assertDatabaseMissing('tasks', ['id' => $this->task->id]);
    }
}
