<?php

namespace Tests\Feature\Controller\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory;

class BlocoTest extends TestCase
{
    //use RefreshDatabase;
    public function testCanReturnACollectionOfPaginatedBlocos()
    {
        $bloco = $this->create('Bloco');
        $bloco2 = $this->create('Bloco');
        $bloco3 = $this->create('Bloco');

        $response = $this->json('get', '/api/bloco');
        $response->assertStatus(200)->assertJsonStructure([
            'data' => [
                '*' => ['id', 'numero', 'quantidade_apartamento', 'created_at', 'updated_at']
            ]
        ]);

    }

    public function testCanCreateABloco()
    {
        // given a situation - user is authenticated
        // when - post request create a bloco
        $faker = Factory::create();

        $response = $this->json('post', '/api/bloco', [
            'numero' => $name = $faker->name(),
            'quantidade_apartamento' => $quantidade_apartamento = $faker->unique()->randomDigit,
            'condominio_id' => $condominio_id = factory(\App\Models\Condominio::class)->create()->id
        ])->assertJson([
            'created_at' => true,
        ]);

        // then - bloco exists
        $response->assertStatus(201);

        $this->assertDatabaseHas('blocos', [
            'numero' => $name,
            'quantidade_apartamento' => $quantidade_apartamento,
            'condominio_id' => $condominio_id,
        ]);
    }

    public function testCanReturnABloco()
    {
        // given
        $bloco = $this->create('Bloco');

        // when
        $response = $this->json('get', '/api/bloco/'.$bloco->id);

        // then
        $response->assertStatus(200)->assertExactJson([
            'id' => $bloco->id,
            'numero' => $bloco->numero,
            'quantidade_apartamento' => $bloco->quantidade_apartamento,
            'created_at' => $bloco->created_at,
            'updated_at' => $bloco->updated_at,
        ]);
    }

    public function testWillFailsWithA404IfBlocoIsNotFound()
    {
        $response = $this->json('get', '/api/bloco/-1');
        $response->assertStatus(404);
    }

    public function testWillFailWithA404IfBlocoWeWantToUpdateIsNotFound()
    {
        $response = $this->json('put', '/api/bloco/-2');
        $response->assertStatus(404);
    }

    public function testCanUpdateABloco()
    {

        $this->withoutExceptionHandling();
        $bloco = $this->create('Bloco');

        $response = $this->json('put', '/api/bloco/'.$bloco->id, [
            'numero' => $bloco->numero.'_updated',
            'quantidade_apartamento' => $bloco->quantidade_apartamento.'_updated',
        ]);

        $response->assertStatus(200)
            ->assertExactJson([
                'id' => $bloco->id,
                'numero' => $bloco->numero.'_updated',
                'quantidade_apartamento' => $bloco->quantidade_apartamento.'_updated',
                'created_at' => $bloco->created_at,
                'updated_at' => $bloco->updated_at
            ]);

        $this->assertDatabaseHas('blocos', [
            'id' => $bloco->id,
                'numero' => $bloco->numero.'_updated',
                'quantidade_apartamento' => $bloco->quantidade_apartamento.'_updated',
                'created_at' => $bloco->created_at,
                'updated_at' => $bloco->updated_at
        ]);
    }

    public function testWillFailWithA404IfBlocoWeWantToDeleteIsNotFound()
    {
        $response = $this->json('delete', '/api/bloco/-2');
        $response->assertStatus(404);
    }

    public function testCanDeleteABloco()
    {
        $bloco = $this->create('Bloco');
        $response = $this->json('delete', '/api/bloco/'.$bloco->id);

        $response->assertStatus(204)->assertSee(null);

        $this->assertDatabaseMissing('blocos', ['id' => $bloco->id]);
    }
}
