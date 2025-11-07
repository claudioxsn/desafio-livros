<?php

namespace App\Livewire\Livro;

use App\Services\LivroService;
use Livewire\Component;

class LivroIndex extends Component
{
    public $search = ''; 
    public function delete(LivroService $livroService, $Codl)
    {
        $livro = $livroService->delete($Codl);

        if (!$livro) {
            session()->flash('error', 'Livro não encontrado ou não pode ser excluído.');
        } else {
            session()->flash('success', 'Livro excluído com sucesso!');
        }

        return redirect()->route('livro.index');
    }

    public function render(LivroService $livroService)
    {
        if ($this->search) {
            $livros = $livroService->listarLivrosPorTituloComPagination($this->search);
        } else {
            $livros = $livroService->listAllWithPagination();
        }
        return view('livewire.livro.livro-index', compact('livros'));
    }
}
