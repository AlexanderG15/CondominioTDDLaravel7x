<?php

namespace Tests;

use App\Models\Bloco;
use App\Models\Condominio;
use App\Http\Resources\BlocoResource;
use App\Http\Resources\CondominioResource;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function createCondominio(array $att = [])
    {
        $condominio = factory(Condominio::class)->create($att);

        return new CondominioResource($condominio);
    }

    public function createBloco(array $att = [])
    {
        $Bloco = factory(Bloco::class)->create($att)->each(function ($Bloco) {
            $Bloco->save(factory(Condominio::class)->make());
        });

        return new BlocoResource($Bloco);
    }
}
