<?php

namespace App\Livewire\Autor;

use App\Exceptions\DatabaseException;
use App\Services\AutorService;
use Livewire\Component;
use Illuminate\Validation\ValidationException;

class AutorCreate extends Component
{

    public $Nome;

    protected $rules = [
        'Nome' => ['required', 'string', 'max:255']
    ];

    protected $messages = [
        'Nome.required' => 'O campo Nome é obrigatório.',
        'Nome.string'   => 'O campo Nome deve conter texto.',
        'Nome.max'      => 'O campo Nome deve ter no máximo 40 caracteres.',
    ];

    public function store(AutorService $autorService)
    {
        $this->validate();

        try {
            $autorService->criar([
                'Nome' => $this->Nome
            ]);
            session()->flash('success', 'Autor cadastrado com sucesso!');
            return redirect()->route('autor.index');
        } catch (DatabaseException $e) {
            session()->flash('error', 'Erro ao cadastrar autor: ' . $e->getMessage());
        } catch (ValidationException $e) {
            session()->flash('error', 'Validação falhou: ' . $e->getMessage());
        } catch (\Exception $e) {
            session()->flash('error', 'Ocorreu um erro inesperado: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.autor.autor-create');
    }
}
