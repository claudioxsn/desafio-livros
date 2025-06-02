<?php

namespace App\Livewire\Relatorios;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class RelatorioLivrosPorAutor extends Component
{

    public $autorSelecionado = null;
    public $autores = [];
    public $dados = [];

    public function mount()
    {
        $this->autores = DB::table('Autor')->select('CodAu', 'Nome')->orderBy('Nome')->get();
        $this->pesquisar();
    }

    public function pesquisar()
    {
        $this->dados = DB::table('vw_livros_por_autor')
            ->when($this->autorSelecionado, function ($query) {
                $query->where('autor_id', $this->autorSelecionado);
            })
            ->get();
    }

    public function gerarRelatorio()
    {
        $dados = DB::table('vw_livros_por_autor')
            ->when($this->autorSelecionado, function ($query) {
                $query->where('autor_id', $this->autorSelecionado);
            })
            ->get();

        $pdf = Pdf::loadView('livewire.relatorios.livros_por_autor', compact('dados'))
            ->setPaper('a4', 'portrait');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'relatorio_livros_por_autor.pdf');
    }

    public function render()
    {
        return view('livewire.relatorios.relatorio-livros-por-autor');
    }
}
