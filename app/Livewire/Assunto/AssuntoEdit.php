<?php

namespace App\Livewire\Assunto;

use App\Exceptions\ModelNotFoundException;
use App\Services\AssuntoService;
use Livewire\Component;

class AssuntoEdit extends Component
{
    public $codAs;
    public $Descricao;

    public function mount(AssuntoService $assuntoService, $codAs)
    {
        try {
            $assunto = $assuntoService->buscarPorId($codAs);
            $this->codAs = $assunto->codAs;
            $this->Descricao = $assunto->Descricao;
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Assunto não encontrado');
            return redirect()->route('assunto.index');
        }
    }

    protected $rules = [
        'Descricao' => ['required', 'string', 'max:20'],
    ];


    protected $messages = [
        'Descricao.required' => 'O campo Descrição é obrigatório.',
        'Descricao.string'   => 'O campo Descrição deve conter texto.',
        'Descricao.max'      => 'O campo Descrição deve ter no máximo 20 caracteres.',
    ];


    public function update(AssuntoService $assuntoService)
    {
        $this->validate();

        try {
            $assuntoService->atualizar($this->codAs, ['Descricao' => $this->Descricao]);
            session()->flash('success', 'Assunto atualizado com sucesso!');
            return redirect()->route('assunto.index');
        } catch (\Exception $e) {
            session()->flash('error', 'Erro ao atualizar assunto: ' . $e->getMessage());
            return redirect()->route('assunto.index');
        }
    }

    public function render()
    {
        return view('livewire.assunto.assunto-edit');
    }
}
