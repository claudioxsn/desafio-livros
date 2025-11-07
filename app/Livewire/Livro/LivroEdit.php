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

    protected $rules = [
        'Titulo' => ['required', 'string', 'max:40'],
        'Editora' => ['required', 'string', 'max:40'],
        'Edicao' => ['required', 'integer', 'min:1'],
        'AnoPublicacao' => ['required', 'digits:4', 'integer'],
        'Valor' => ['required', 'numeric', 'min:0'],
        'CodAu' => ['required', 'array', 'min:1'],
        'CodAu.*' => ['integer'],
        'codAs' => ['required', 'array', 'min:1'],
        'codAs.*' => ['integer'],
    ];

    protected $messages = [
        'Titulo.required'       => 'O campo Título é obrigatório.',
        'Titulo.string'         => 'O campo Título deve conter texto.',
        'Titulo.max'            => 'O campo Título deve ter no máximo 40 caracteres.',

        'Editora.required'      => 'O campo Editora é obrigatório.',
        'Editora.string'        => 'O campo Editora deve conter texto.',
        'Editora.max'           => 'O campo Editora deve ter no máximo 40 caracteres.',

        'Edicao.required'       => 'O campo Edição é obrigatório.',
        'Edicao.integer'        => 'O campo Edição deve ser um número inteiro.',
        'Edicao.min'            => 'O campo Edição deve ser no mínimo 1.',

        'AnoPublicacao.required' => 'O campo Ano de Publicação é obrigatório.',
        'AnoPublicacao.integer'  => 'O campo Ano de Publicação deve ser um número inteiro.',
        'AnoPublicacao.between'  => 'O Ano de Publicação deve estar entre 1900 e o ano atual.',

        'Valor.required'        => 'O campo Valor é obrigatório.',
        'Valor.numeric'         => 'O campo Valor deve ser numérico.',
        'Valor.min'             => 'O campo Valor não pode ser negativo.',

        'CodAu.required'  => 'Selecione ao menos um autor.',
        'CodAu.array'     => 'O campo de autores deve ser uma lista.',
        'CodAu.min'       => 'Selecione pelo menos um autor.',
        'CodAu.*.exists'  => 'Um ou mais autores selecionados são inválidos.',

        'codAs.required'  => 'Selecione ao menos um assunto.',
        'codAs.array'     => 'O campo de assuntos deve ser uma lista.',
        'codAs.min'       => 'Selecione pelo menos um assunto.',
        'codAs.*.exists'  => 'Um ou mais assuntos selecionados são inválidos.',
    ];

    public function mount(LivroService $livroService, $Codl)
    {
        $livro = $livroService->findById($Codl);

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
        $livro = $livroService->findById($this->Codl);

        if (!$livro) {
            return redirect()->route('livro.index')->with(['error' => 'Livro não encontrado']);
        }

        $livroService->update($this->Codl, [
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
        $autores = $autorService->listAll();
        $assuntos = $assuntoService->listAll();
        return view('livewire.livro.livro-edit', compact('autores', 'assuntos'));
    }
}
