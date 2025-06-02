<?php

namespace App\Livewire\Autor;

use App\Exceptions\DatabaseException;
use App\Exceptions\ModelNotFoundException;
use App\Models\Autor;
use App\Services\AutorService;
use Livewire\Component;

class AutorEdit extends Component
{
    public $CodAu;
    public $Nome;

    public function mount(AutorService $autorService, $CodAu)
    {
        try {
            $autor = $autorService->buscarPorId($CodAu);
            $this->CodAu = $autor->CodAu;
            $this->Nome = $autor->Nome;
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Autor não encontrado');
            return redirect()->route('autor.index');
        }
    }

    protected $rules = [
        'Nome' => ['required', 'string', 'max:40'],
    ];

    protected $messages = [
        'Nome.required' => 'O campo Nome é obrigatório.',
        'Nome.string'   => 'O campo Nome deve conter texto.',
        'Nome.max'      => 'O campo Nome deve ter no máximo 40 caracteres.',
    ];

    public function update(AutorService $autorService)
    {
        $this->validate();

        try {
            $autorService->atualizar($this->CodAu, ['Nome' => $this->Nome]);

            session()->flash('success', 'Autor atualizado com sucesso!');
            return redirect()->route('autor.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao atualizar autor: ' . $e->getMessage());
            return redirect()->route('autor.index');
        }
    }

    public function render()
    {
        return view('livewire.autor.autor-edit');
    }
}
