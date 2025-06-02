<?php

namespace App\Livewire\Livro;

use App\Exceptions\DatabaseException;
use App\Services\AssuntoService;
use App\Services\AutorService;
use App\Services\LivroService;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class LivroCreate extends Component
{
    public $Titulo;
    public $Editora;
    public $Edicao;
    public $AnoPublicacao;
    public $Valor;
    public $codAs = []; 
    public $CodAu = [];  

    protected $rules = [
        'Titulo' => ['required', 'string', 'max:255'],
        'Editora' => ['required', 'string', 'max:255'],
        'Edicao' => ['required', 'integer', 'min:1'],
        'AnoPublicacao' => ['required', 'digits:4', 'integer'],
        'Valor' => ['required', 'numeric', 'min:0'],
        'CodAu' => ['required', 'array', 'min:1'],
        'CodAu.*' => ['integer'],
        'codAs' => ['required', 'array', 'min:1'],
        'codAs.*' => ['integer'],
    ];

    public function salvar(LivroService $livroService)
    {
        $this->validate();

        try {
            $livroService->criar([
                'Titulo' => $this->Titulo,
                'Editora' => $this->Editora,
                'Edicao' => $this->Edicao,
                'AnoPublicacao' => $this->AnoPublicacao,
                'Valor' => $this->Valor,
                'Livro_CodAu' => $this->CodAu,
                'Livro_codAs' => $this->codAs,
            ]);

            session()->flash('success', 'Livro cadastrado com sucesso!');
            return redirect()->route('livro.index');
        } catch (DatabaseException $e) {
            session()->flash('error', 'Erro no banco de dados: ' . $e->getMessage());
        } catch (ValidationException $e) {
            session()->flash('error', 'Erro de validação: ' . $e->getMessage());
        } catch (\Exception $e) {
            session()->flash('error', 'Erro inesperado: ' . $e->getMessage());
        }
    }

    public function render(AutorService $autorService, AssuntoService $assuntoService)
    {
        $autores = $autorService->listarTodos();
        $assuntos = $assuntoService->listarTodos();

        return view('livewire.livro.livro-create', compact('autores', 'assuntos'));
    }
}
