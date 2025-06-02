<?php

namespace App\Livewire\Assunto;

use App\Services\AssuntoService;
use Livewire\Component;

class AssuntoIndex extends Component
{
    public $search = '';

    public function delete(AssuntoService $assuntoService, $codAs)
    {
        $deleted = $assuntoService->deletar($codAs);

        if (!$deleted) {
            session()->flash('error', 'Assunto não encontrado ou não pode ser deletado');
        } else {
            session()->flash('success', 'Assunto excluído com sucesso!');
        }

        return redirect()->route('assunto.index');
    }

    public function render(AssuntoService $assuntoService)
    {
        if ($this->search) {
            $assuntos = $assuntoService->listarPorNomeComPagination($this->search);
        } else {
            $assuntos = $assuntoService->listarTodosWithPagination();
        }

        return view('livewire.assunto.assunto-index', compact('assuntos'));
    }
}
