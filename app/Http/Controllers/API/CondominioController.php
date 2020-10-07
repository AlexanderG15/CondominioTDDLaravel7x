<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CondominioCollection;
use App\Http\Resources\CondominioResource;
use App\Models\Condominio;
use App\Repositories\Api\Condominio\CondominioRepository;
use Illuminate\Http\Request;

class CondominioController extends Controller
{
    protected $condominioRepository;

    public function __construct(CondominioRepository $condominioRepository)
    {
        $this->condominioRepository = $condominioRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new CondominioCollection(Condominio::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $resultado = $this->condominioRepository->create($request->all());

        return response()->json(new CondominioResource($resultado), 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $resultado = Condominio::findOrfail($id);

        return response()->json(new CondominioResource($resultado));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, int $id)
    {
        $resultado = Condominio::findOrfail($id);

        $resultado->update([
            'nome' => $request->nome,
            'email' => $request->email
        ]);
        return response()->json(new CondominioResource($resultado));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $resultado = Condominio::findOrfail($id);
        $resultado->delete();
        return response()->json(null, 204);
    }
}
