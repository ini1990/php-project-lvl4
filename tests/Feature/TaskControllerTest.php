<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskControllerTest extends TestCase
{
    use RefreshDatabase;

    public function setUp(): void
    {
        parent::setUp();

        $this->user = factory(\App\User::class)->create();
        $this->task = factory(\App\Task::class)->create([
            'created_by_id' => $this->user->id
        ]);
        //dd($this->task);
        $this->actingAs($this->user);
    }

    public function testIndex()
    {
        $response = $this->get(route('tasks.index'));
        $response->assertStatus(200);
    }

    public function testCreate()
    {
        $response = $this->get(route('tasks.create'));
        $response->assertStatus(200);
    }

    public function testStore()
    {
        $response = $this->post(route('tasks.store'), $this->task->getAttributes());
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('tasks', $this->task->getAttributes());
    }

    public function testShow()
    {
        $response = $this->get(route('tasks.show', $this->task->id));
        $response->assertStatus(200);
    }

    public function testUpdate()
    {
        $updatedTask = factory(\App\Task::class)->make(['created_by_id' => $this->user->id])->toArray();
        $response = $this->patch(route('tasks.update', $this->task), $updatedTask);
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseHas('tasks', $updatedTask);
    }

    public function testDestroy()
    {
        $response = $this->delete(route('tasks.destroy', $this->task));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect(route('tasks.index'));
        $this->assertDatabaseMissing('tasks', ['id', $this->task->id]);

        $anotherUser = factory(\App\User::class)->create();
        $anotherTask = factory(\App\Task::class)->create([
            'created_by_id' => $anotherUser->id
        ]);
        $response = $this->delete(route('tasks.destroy', $anotherTask));
        $response->assertStatus(403);
    }
}