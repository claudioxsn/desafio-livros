<?php

namespace App\Livewire\Assunto;

use App\Exceptions\DatabaseException;
use App\Services\AssuntoService;
use Livewire\Component;
use Illuminate\Validation\ValidationException;

class AssuntoCreate extends Component
{
    public $Descricao;

    protected $rules = [
        'Descricao' => ['required', 'string', 'max:20'],
    ];

    protected $messages = [
        'Descricao.required' => 'O campo Descrição é obrigatório.',
        'Descricao.string'   => 'O campo Descrição deve conter texto.',
        'Descricao.max'      => 'O campo Descrição deve ter no máximo 20 caracteres.',
    ];

    public function store(AssuntoService $assuntoService)
    {
        $this->validate();

        try {
            $assuntoService->create([
                'Descricao' => $this->Descricao
            ]);

            session()->flash('success', 'Assunto cadastrado com sucesso!');
            return redirect()->route('assunto.index');
        } catch (DatabaseException $e) {
            session()->flash('error', 'Erro ao cadastrar assunto: ' . $e->getMessage());
        } catch (ValidationException $e) {
            session()->flash('error', 'Validação falhou: ' . $e->getMessage());
        } catch (\Exception $e) {
            session()->flash('error', 'Ocorreu um erro inesperado: ' . $e->getMessage());
        }
    }

    public function render()
    {
        return view('livewire.assunto.assunto-create');
    }
}
