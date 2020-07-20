<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskStatusControllerTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed();
    }

    public function testIndex()
    {
        $response = $this->get(route('task_statuses.index'));
        $response->assertOk();
        $response->assertSee('on testing');
    }

    public function testCreate()
    {
        $user = factory(\App\User::class)->create();
        $response = $this->actingAs($user)->get(route('task_statuses.create'));
        $response->assertOk();
    }

    public function testEdit()
    {
        $taskStatus = factory(\App\TaskStatus::class)->create();
        $user = factory(\App\User::class)->create();
        $response = $this->actingAs($user)->get(route('task_statuses.edit', $taskStatus));
        $response->assertOk();
        $response->assertSee($taskStatus->name);
    }

    public function testStore()
    {
        $name = factory(\App\TaskStatus::class)->make()->name;
        $user = factory(\App\User::class)->create();
        $response = $this->actingAs($user)->post(route('task_statuses.store'), compact('name'));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('task_statuses', compact('name'));
    }

    public function testUpdate()
    {
        $taskStatus = factory(\App\TaskStatus::class)->create();
        $name = factory(\App\TaskStatus::class)->make()->name;
        $user = factory(\App\User::class)->create();
        $response = $this->actingAs($user)
        ->patch(route('task_statuses.update', $taskStatus), compact('name'));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('task_statuses', compact('name'));
    }

    public function testDestroy()
    {
        $taskStatus = factory(\App\TaskStatus::class)->create();
        $user = factory(\App\User::class)->create();
        $response = $this->actingAs($user)
        ->delete(route('task_statuses.destroy', [$taskStatus]));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertSoftDeleted('task_statuses', ['id' => $taskStatus->id]);
    }

}
