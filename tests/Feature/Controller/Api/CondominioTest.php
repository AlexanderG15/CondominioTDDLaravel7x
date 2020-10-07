<?php

namespace Tests\Feature\Controller\Api;

use Faker\Factory;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\RefreshDatabase;

/**
 * @internal
 * @coversNothing
 */
class CondominioTest extends TestCase
{
    use RefreshDatabase;

    public function testCanReturnACollectionOfPaginatedCondominios()
    {
        $condominio = $this->createCondominio();
        $condominio2 = $this->createCondominio();
        $condominio3 = $this->createCondominio();

        $response = $this->json('get', '/api/condominio');
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                '*' => ['id', 'nome', 'email', 'created_at', 'updated_at']
            ]
        ]);

        // Log::debug($response->getContent());
    }

    public function testCanCreateACondominio()
    {
        // given a situation - user is authenticated
        // when - post request create a condominio
        $faker = Factory::create();

        $response = $this->json('post', '/api/condominio', [
            'nome' => $name = $faker->name(),
            'email' => $email = $faker->email,
        ])->assertJson([
            'created_at' => true,
        ]);

        // then - condominio exists
        $response->assertStatus(201);

        $this->assertDatabaseHas('condominios', [
            'nome' => $name,
            'email' => $email,
        ]);
    }

    public function testCanReturnACondominio()
    {
        // given
        $condominio = $this->createCondominio();

        // when
        $response = $this->json('get', '/api/condominio/'.$condominio->id);

        // then
        $response->assertStatus(200)->assertExactJson([
            'id' => $condominio->id,
            'nome' => $condominio->nome,
            'email' => $condominio->email,
            'created_at' => $condominio->created_at,
            'updated_at' => $condominio->updated_at,
        ]);
    }

    public function testWillFailsWithA404IfCondominioIsNotFound()
    {
        $response = $this->json('get', '/api/condominio/-1');
        $response->assertStatus(404);
    }

    public function testWillFailWithA404IfCondominioWeWantToUpdateIsNotFound()
    {
        $response = $this->json('put', '/api/condominio/-2');
        $response->assertStatus(404);
    }

    public function testCanUpdateACondominio()
    {

        $this->withoutExceptionHandling();
        $condominio = $this->createCondominio();

        $response = $this->json('put', '/api/condominio/'.$condominio->id, [
            'nome' => $condominio->nome.'_updated',
            'email' => $condominio->email.'_updated',
        ]);

        $response->assertStatus(200)
            ->assertExactJson([
                'id' => $condominio->id,
                'nome' => $condominio->nome.'_updated',
                'email' => $condominio->email.'_updated',
                'created_at' => $condominio->created_at,
                'updated_at' => $condominio->updated_at
            ]);

        $this->assertDatabaseHas('condominios', [
            'id' => $condominio->id,
                'nome' => $condominio->nome.'_updated',
                'email' => $condominio->email.'_updated',
                'created_at' => $condominio->created_at,
                'updated_at' => $condominio->updated_at
        ]);
    }

    public function testWillFailWithA404IfCondominioWeWantToDeleteIsNotFound()
    {
        $response = $this->json('delete', '/api/condominio/-2');
        $response->assertStatus(404);
    }

    public function testCanDeleteACondominio()
    {
        $condominio = $this->createCondominio();
        $response = $this->json('delete', '/api/condominio/'.$condominio->id);

        $response->assertStatus(204)->assertSee(null);

        $this->assertDatabaseMissing('condominios', ['id' => $condominio->id]);
    }
}
