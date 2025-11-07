<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\DatabaseException;
use App\Exceptions\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Http\Requests\LivroRequest;
use App\Services\LivroService;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Livro",
 *     title="Livro",
 *     required={"titulo", "autor_id", "assunto_id"},
 *     @OA\Property(property="titulo", type="string", example="O Senhor dos Anéis"),
 *     @OA\Property(property="autor_id", type="integer", example=1),
 *     @OA\Property(property="assunto_id", type="integer", example=3)
 * )
 */
class LivroController extends Controller
{

    protected $livroService;

    public function __construct(LivroService $livroService)
    {
        $this->livroService = $livroService;
    }


    /**
     * @OA\Get(
     *     path="/api/livros",
     *     summary="Listar todos os livros",
     *     tags={"Livros"},
     *     @OA\Response(response=200, description="Lista de livros"),
     *     @OA\Response(response=500, description="Erro no servidor")
     * )
     */
    public function index()
    {
        $livros = $this->livroService->listAll();
        return response()->json($livros);
    }

    /**
     * @OA\Post(
     *     path="/api/livros",
     *     summary="Criar um novo livro",
     *     tags={"Livros"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Livro")
     *     ),
     *     @OA\Response(response=201, description="Livro criado com sucesso"),
     *     @OA\Response(response=500, description="Erro ao criar livro")
     * )
     */
    public function store(LivroRequest $request)
    {
        try {
            $livro = $this->livroService->create($request->all());
            return response()->json($livro, 201);
        } catch (DatabaseException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Get(
     *     path="/api/livros/{id}",
     *     summary="Exibir um livro específico",
     *     tags={"Livros"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do livro",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Livro encontrado"),
     *     @OA\Response(response=404, description="Livro não encontrado")
     * )
     */
    public function show($id)
    {
        try {
            $livro = $this->livroService->findById($id);
            return response()->json($livro);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }


    /**
     * @OA\Put(
     *     path="/api/livros/{id}",
     *     summary="Atualizar um livro",
     *     tags={"Livros"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do livro",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/Livro")
     *     ),
     *     @OA\Response(response=200, description="Livro atualizado com sucesso"),
     *     @OA\Response(response=500, description="Erro ao atualizar livro")
     * )
     */
    public function update(LivroRequest $request, $id)
    {
        try {
            $livro = $this->livroService->update($id, $request->all());
            return response()->json($livro);
        } catch (DatabaseException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/livros/{id}",
     *     summary="Deletar um livro",
     *     tags={"Livros"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do livro",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Livro deletado com sucesso"),
     *     @OA\Response(response=500, description="Erro ao deletar livro")
     * )
     */
    public function destroy($id)
    {
        try {
            $this->livroService->delete($id);
            return response()->json(['message' => 'Livro deletado com sucesso']);
        } catch (DatabaseException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    /**
     * @OA\Post(
     *     path="/api/livros/{id}/restore",
     *     summary="Restaurar um livro deletado",
     *     tags={"Livros"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID do livro",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response=200, description="Livro restaurado com sucesso"),
     *     @OA\Response(response=500, description="Erro ao restaurar livro")
     * )
     */
    public function restore($id)
    {
        try {
            $this->livroService->restore($id);
            return response()->json(['message' => 'Livro restaurado com sucesso']);
        } catch (DatabaseException $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
