<?php

namespace App\Http\Controllers\API;

use App\Models\Bloco;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Bloco as ResourcesBloco;
use App\Http\Resources\BlocoResource;
use App\Http\Resources\BlocoCollection;
use App\Repositories\Api\Bloco\BlocoRepository;

class BlocoController extends Controller
{
    protected $blocoRepository;

    public function __construct(BlocoRepository $blocoRepository)
    {
        $this->blocoRepository = $blocoRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return new BlocoCollection(Bloco::paginate());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $resultado = $this->blocoRepository->create($request->all());

        return response()->json(new BlocoResource($resultado), 201);
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
        $resultado = Bloco::findOrfail($id);

        return response()->json(new BlocoResource($resultado));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $resultado = Bloco::findOrfail($id);

        $resultado->update([
            'numero' => $request->numero,
            'quantidade_apartamento' => $request->quantidade_apartamento
        ]);
        return response()->json(new BlocoResource($resultado));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $resultado = Bloco::findOrfail($id);
        $resultado->delete();
        return response()->json(null, 204);
    }
}
