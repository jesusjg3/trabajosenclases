<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Estudiante;
use App\Models\Paralelo;

class EstudiantesTest extends TestCase
{
    use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $paralelo = Paralelo::Factory()->create(); 
        //$response = $this->get('/');
        $response = $this->postJson('/api/estudiantes',[
            'nombre' => 'Juan',
            'cedula' => '1234567890',
            'correo' => 'carlos@example.com',
            'paralelo_id' => $paralelo->id,
        ]);

        //$response->assertStatus(200);
        $response->assertStatus(201)
            ->assertJsonFragment(['mensaje' => 'estudiante creado exitosamente']);
        
        $this->assertDatabaseHas('estudiantes', [
            'cedula' => '1234567890',
            'correo' => 'carlos@example.com',
        ]);
                
    }
}
