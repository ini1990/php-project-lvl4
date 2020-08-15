<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Label;

class LabelControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->label = factory(Label::class)->create();
    }

    public function testIndex()
    {
        $response = $this->get(route('labels.index'));
        $response->assertStatus(200);
        $response->assertSeeTextInOrder(Label::pluck('name', 'id')->all());
    }

    public function testCreate()
    {
        $response = $this->get(route('labels.create'));
        $response->assertOk();
    }

    public function testEdit()
    {
        $response = $this->get(route('labels.edit', $this->label));
        $response->assertOk();
        $response->assertSee($this->label->name);
    }

    public function testStore()
    {
        $label = factory(Label::class)->make();
        $name = $label->name;
        $response = $this->post(route('labels.store'), compact('name'));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('labels', compact('name'));
    }

    public function testUpdate()
    {
        $label = factory(Label::class)->make();
        $name = $label->name;
        $response = $this->patch(route('labels.update', $this->label), compact('name'));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('labels', compact('name'));
    }

    public function testDestroy()
    {
        $response = $this->delete(route('labels.destroy', $this->label));
        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseMissing('labels', ['id' => $this->label->id, 'name' => $this->label->name]);
    }
}
