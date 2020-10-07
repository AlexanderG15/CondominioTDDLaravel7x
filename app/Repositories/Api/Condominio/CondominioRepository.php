<?php

namespace App\Repositories\Api\Condominio;

use App\Models\Condominio;
use App\Repositories\BaseRepository;

class CondominioRepository extends BaseRepository
{
    public function __construct(Condominio $condominio)
    {
        parent::__construct($condominio);
    }

    public function all()
    {
        return parent::all();
    }

    public function show(int $condominioId)
    {
        $condominioExist = Condominio::find($condominioId);

        return ($condominioExist) ? parent::show($condominioId) : false;
    }

    public function delete(int $condominioId)
    {
        $condominioExist = Condominio::find($condominioId);

        return ($condominioExist) ? parent::delete($condominioId) : false;
    }

    public function create(array $dados)
    {
        return parent::create($dados);
    }

    public function update(array $info, int $id)
    {

    }
}
