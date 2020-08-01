<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\TaskStatus;

class TaskStatusControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
        $this->status = TaskStatus::first();
        $this->user = factory(\App\User::class)->create();
        $this->actingAs($this->user);
    }

    public function testIndex()
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertOk();
        $response->assertSeeInOrder(__('models.taskStatus'));
        $response->assertSeeTextInOrder(TaskStatus::pluck('name')->all());
    }

    public function testCreate()
    {
        $response = $this->get(route('task_statuses.create'));
        $response->assertOk();
    }

    public function testEdit()
    {
        $response = $this->get(route('task_statuses.edit', $this->status));
        $response->assertOk();
        $response->assertSee($this->status->name);
    }

    public function testStore()
    {
        $newTaskStatus = factory(TaskStatus::class)->make();
        $name = $newTaskStatus->name;
        $response = $this->post(route('task_statuses.store'), compact('name'));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('task_statuses', compact('name'));
    }

    public function testUpdate()
    {
        $newTaskStatus = factory(TaskStatus::class)->make();
        $name = $newTaskStatus->name;
        $response = $this->patch(route('task_statuses.update', $this->status), compact('name'));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('task_statuses', compact('name'));
    }

    public function testDestroy()
    {
        $response = $this->delete(route('task_statuses.destroy', $this->status));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertSoftDeleted('task_statuses', ['id' => $this->status->id]);
    }
}
