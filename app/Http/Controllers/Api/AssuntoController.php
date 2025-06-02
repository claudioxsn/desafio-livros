<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\DatabaseException;
use App\Exceptions\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AssuntoRequest;
use App\Services\AssuntoService;
use Illuminate\Http\Request;

class AssuntoController extends Controller
{

    protected $assuntoService;

    public function __construct(AssuntoService $assuntoService)
    {
        $this->assuntoService = $assuntoService;
    }

    /**
     * @OA\Get(
     *     path="/api/assuntos",
     *     summary="Lista todos os assuntos",
     *     tags={"Assuntos"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de assuntos",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Assunto"))
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro no banco de dados"
     *     )
     * )
     */
    public function index()
    {
        try {
            $assuntos = $this->assuntoService->listarTodos();
            return response()->json($assuntos);
        } catch (DatabaseException $e) {
            return response()->json(['error' => 'Erro no banco de dados: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/assuntos",
     *     summary="Cria um novo assunto",
     *     tags={"Assuntos"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Assunto")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Assunto criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Assunto")
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao criar assunto"
     *     )
     * )
     */
    public function store(AssuntoRequest $request)
    {
        try {
            $assunto = $this->assuntoService->criar($request->all());
            return response()->json($assunto, 201);
        } catch (DatabaseException $e) {
            return response()->json(['error' => 'Erro ao criar assunto: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/assuntos/{id}",
     *     summary="Exibe um assunto específico",
     *     tags={"Assuntos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Detalhes do assunto",
     *         @OA\JsonContent(ref="#/components/schemas/Assunto")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Assunto não encontrado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao buscar assunto"
     *     )
     * )
     */
    public function show($id)
    {
        try {
            $assunto = $this->assuntoService->buscarPorId($id);
            return response()->json($assunto);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        } catch (DatabaseException $e) {
            return response()->json(['error' => 'Erro ao buscar assunto: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     *     path="/api/assuntos/{id}",
     *     summary="Atualiza um assunto",
     *     tags={"Assuntos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Assunto")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Assunto atualizado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Assunto")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Assunto não encontrado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao atualizar assunto"
     *     )
     * )
     */
    public function update(AssuntoRequest $request, $id)
    {
        try {
            $assunto = $this->assuntoService->atualizar($id, $request->all());
            return response()->json($assunto);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Assunto não encontrado'], 404);
        } catch (DatabaseException $e) {
            return response()->json(['error' => 'Erro ao atualizar assunto: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/assuntos/{id}",
     *     summary="Deleta um assunto",
     *     tags={"Assuntos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Assunto deletado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Assunto não encontrado"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao deletar assunto"
     *     )
     * )
     */
    public function destroy($id)
    {
        try {
            $assunto = $this->assuntoService->deletar($id);

            if (!$assunto) {
                return response()->json(['error' => 'Assunto não encontrado'], 404);
            }

            return response()->json(['mensagem' => 'Assunto deletado com sucesso']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        } catch (DatabaseException $e) {
            return response()->json(['error' => 'Erro ao deletar assunto: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/assuntos/{id}/restore",
     *     summary="Restaura um assunto deletado",
     *     tags={"Assuntos"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Assunto restaurado com sucesso"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Erro ao restaurar assunto"
     *     )
     * )
     */
    public function restore($id)
    {
        try {
            $this->assuntoService->restore($id);
            return response()->json(['mensagem' => 'Assunto restaurado com sucesso']);
        } catch (DatabaseException $e) {
            return response()->json(['error' => 'Erro ao restaurar assunto: ' . $e->getMessage()], 500);
        }
    }
}
