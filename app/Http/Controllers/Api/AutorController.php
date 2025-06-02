<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\DatabaseException;
use App\Exceptions\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\AutorRequest;
use App\Services\AutorService;
use Illuminate\Http\Request;

/**
 * @OA\Info(
 *     version="1.0.0",
 *     title="Documentação da API",
 *     description="API do sistema de livros com autores e assuntos"
 * )
 */
class AutorController extends Controller
{
    protected $autorService;

    public function __construct(AutorService $autorService)
    {
        $this->autorService = $autorService;
    }

    /**
     * @OA\Get(
     *     path="/api/autores",
     *     summary="Listar todos os autores",
     *     tags={"Autores"},
     *     @OA\Response(response=200, description="Lista de autores"),
     *     @OA\Response(response=500, description="Erro no banco de dados")
     * )
     */
    public function index()
    {
        try {
            $autores = $this->autorService->listarTodos();
            return response()->json($autores);
        } catch (DatabaseException $e) {
            return response()->json(['error' => 'Erro no banco de dados: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/autores",
     *     summary="Cadastrar novo autor",
     *     tags={"Autores"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome"},
     *             @OA\Property(property="nome", type="string", example="José de Alencar")
     *         )
     *     ),
     *     @OA\Response(response=201, description="Autor criado"),
     *     @OA\Response(response=500, description="Erro no banco de dados")
     * )
     */
    public function store(AutorRequest $request)
    {
        try {
            $autor = $this->autorService->criar($request->all());
            return response()->json($autor, 201);
        } catch (DatabaseException $e) {
            return response()->json(['error' => 'Erro no banco de dados: ' . $e->getMessage()], 500);
        }
    }
    /**
     * @OA\Get(
     *     path="/api/autores/{id}",
     *     summary="Buscar autor por ID",
     *     tags={"Autores"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Autor encontrado"),
     *     @OA\Response(response=404, description="Autor não encontrado"),
     *     @OA\Response(response=500, description="Erro no banco de dados")
     * )
     */
    public function show(string $id)
    {
        try {
            $autor = $this->autorService->buscarPorId($id);
            return response()->json($autor);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        } catch (DatabaseException $e) {
            return response()->json(['error' => 'Erro no banco de dados: ' . $e->getMessage()], 500);
        }
    }
    /**
     * @OA\Put(
     *     path="/api/autores/{id}",
     *     summary="Atualizar autor",
     *     tags={"Autores"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"nome"},
     *             @OA\Property(property="nome", type="string", example="Machado de Assis")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Autor atualizado"),
     *     @OA\Response(response=404, description="Autor não encontrado"),
     *     @OA\Response(response=500, description="Erro no banco de dados")
     * )
     */
    public function update(AutorRequest $request, $id)
    {
        try {
            $autor = $this->autorService->atualizar($id, $request->all());
            return response()->json($autor);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Autor não encontrado'], 404);
        } catch (DatabaseException $e) {
            return response()->json(['error' => 'Erro no banco de dados: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/autores/{id}",
     *     summary="Excluir autor",
     *     tags={"Autores"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Autor deletado com sucesso"),
     *     @OA\Response(response=404, description="Autor não encontrado"),
     *     @OA\Response(response=500, description="Erro no banco de dados")
     * )
     */
    public function destroy(string $id)
    {
        try {
            $autor = $this->autorService->deletar($id);

            if (!$autor) {
                return response()->json(['error' => 'Autor não encontrado'], 404);
            }

            return response()->json(['mensagem' => 'Autor deletado com sucesso']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        } catch (DatabaseException $e) {
            return response()->json(['error' => 'Erro no banco de dados: ' . $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/autores/{id}/restore",
     *     summary="Restaurar autor deletado",
     *     tags={"Autores"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Autor restaurado com sucesso"),
     *     @OA\Response(response=500, description="Erro no banco de dados")
     * )
     */
    public function restore($id)
    {
        try {
            $this->autorService->restore($id);
            return response()->json(['mensagem' => 'Autor restaurado com sucesso']);
        } catch (DatabaseException $e) {
            return response()->json(['error' => 'Erro no banco de dados: ' . $e->getMessage()], 500);
        }
    }
}
