<?php

namespace App\Livewire\Livro;

use App\Services\AssuntoService;
use App\Services\AutorService;
use App\Services\LivroService;
use Livewire\Component;

class LivroEdit extends Component
{
    public $Titulo;
    public $Editora;
    public $Edicao;
    public $AnoPublicacao;
    public $Valor;
    public $codAs;
    public $CodAu;
    public $Codl;

    public function mount(LivroService $livroService, $Codl)
    {
        $livro = $livroService->buscarPorId($Codl);

        if (!$livro) {
            return redirect()->route('livro.index')->with(['error' => 'Livro não encontrado']);
        }

        $this->Codl = $livro->Codl;
        $this->Titulo = $livro->Titulo;
        $this->Editora = $livro->Editora;
        $this->Edicao = $livro->Edicao;
        $this->AnoPublicacao = $livro->AnoPublicacao;
        $this->Valor = $livro->Valor;


        $this->CodAu = $livro->autores->pluck('CodAu')->toArray();
        $this->codAs = $livro->assuntos->pluck('codAs')->toArray();

    }

    public function salvar(LivroService $livroService)
    {
        $livro = $livroService->buscarPorId($this->Codl);

        if (!$livro) {
            return redirect()->route('livro.index')->with(['error' => 'Livro não encontrado']);
        }

        $livroService->atualizar($this->Codl, [
            'Titulo' => $this->Titulo,
            'Editora' => $this->Editora,
            'Edicao' => $this->Edicao,
            'AnoPublicacao' => $this->AnoPublicacao,
            'Valor' => $this->Valor,
            'Livro_CodAu' => $this->CodAu,
            'Livro_codAs' => $this->codAs
        ]);

        return redirect()->route('livro.index')->with(['success' => 'Atualizado com sucesso']);
    }

    public function render(AutorService $autorService, AssuntoService $assuntoService)
    {
        $autores = $autorService->listarTodos();
        $assuntos = $assuntoService->listarTodos();
        return view('livewire.livro.livro-edit', compact('autores', 'assuntos'));
    }
}
