<?php

namespace App\Repositories\Api\Bloco;

use App\Models\Bloco;
use App\Repositories\BaseRepository;

class BlocoRepository extends BaseRepository
{
    public function __construct(Bloco $Bloco)
    {
        parent::__construct($Bloco);
    }

    public function all()
    {
        return parent::all();
    }

    public function show(int $BlocoId)
    {
        $BlocoExist = Bloco::find($BlocoId);

        return ($BlocoExist) ? parent::show($BlocoId) : false;
    }

    public function delete(int $BlocoId)
    {
        $BlocoExist = Bloco::find($BlocoId);

        return ($BlocoExist) ? parent::delete($BlocoId) : false;
    }

    public function create(array $dados)
    {
        return parent::create($dados);
    }

    public function update(array $data, int $id)
    {
        $BlocoExist = Bloco::find($id);

        return ($BlocoExist) ? parent::update($data, $id) : false;
    }
}
