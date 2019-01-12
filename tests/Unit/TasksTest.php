<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TasksTest extends TestCase
{

    use WithFaker, RefreshDatabase;


    /** @test */
    public function a_user_can_create_a_task()
    {
        $this->withoutExceptionHandling();

        $attributes = [

            'title' => $word = $this->faker->word,            
            'description' => $description = $this->faker->paragraph
        ];
        
        $response = $this->json('POST', '/api/tasks', $attributes);

        \Log::info($response->getContent());
        

        $this->assertDatabaseHas('tasks', $attributes);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'title', 'description', 'created_at'
            ])
            ->assertJson([                
                'title' => $word,
                'description' => $description
            ]);


        
    }    
}