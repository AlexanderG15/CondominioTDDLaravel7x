<?php

namespace Tests;

use App\Http\Resources\CondominioResource;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function create(string $model, array $att = [])
    {
        $condominio = factory("App\\Models\\".$model)->create($att);

        return new CondominioResource($condominio);
    }
}
