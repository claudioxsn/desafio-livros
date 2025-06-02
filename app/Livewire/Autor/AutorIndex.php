<?php

namespace App\Livewire\Autor;

use App\Services\AutorService;
use Livewire\Component;

class AutorIndex extends Component
{

    public $search = '';

    public function delete(AutorService $autorService, $CodAu)
    {
        $autorDeletado = $autorService->deletar($CodAu);

        if (!$autorDeletado) {
            session()->flash('error', 'Autor não encontrado ou não pode ser deletado');
        } else {
            session()->flash('success', 'Autor excluído com sucesso!');
        }

        return redirect()->route('autor.index');
    }

    public function render(AutorService $autorService)
    {
        if ($this->search) {
            $autores = $autorService->listarAutoresPorNomeComPagination($this->search);
        } else {
            $autores = $autorService->listarTodosWithPagination();
        }

        return view('livewire.autor.autor-index', compact('autores'));
    }
}
