<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex">
            <select wire:model="autorSelecionado" class="form-select me-2" style="width: auto;">
                <option value="">Todos os Autores</option>
                @foreach ($autores as $autor)
                    <option value="{{ $autor->CodAu }}">{{ $autor->Nome }}</option>
                @endforeach
            </select>
            <button wire:click="pesquisar" class="btn btn-outline-primary me-2">Pesquisar</button>
            <button wire:click="gerarRelatorio" class="btn btn-success">Gerar PDF</button>
        </div>
    </div>
    <!-- Card com o Relatório -->
    <div class="card">
        <div class="card-header bg-primary text-white">
            <span>Relatório de Livros por Autor</span>
        </div>

        <div class="card-body">
            @if ($dados->isEmpty())
                <p>Nenhum livro encontrado para o filtro atual.</p>
            @else
                @php
                    $agrupado = $dados->groupBy('autor_nome');
                @endphp

                @foreach ($agrupado as $autorNome => $livros)
                    <h5>{{ $autorNome }}</h5>
                    <table class="table table-bordered mb-4">
                        <thead>
                            <tr>
                                <th>Título</th>
                                <th>Editora</th>
                                <th>Ano</th>
                                <th>Valor</th>
                                <th>Assuntos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($livros as $livro)
                                <tr>
                                    <td>{{ $livro->Titulo }}</td>
                                    <td>{{ $livro->Editora }}</td>
                                    <td>{{ $livro->AnoPublicacao }}</td>
                                    <td>R$ {{ number_format($livro->Valor, 2, ',', '.') }}</td>
                                    <td>{{ $livro->assuntos }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endforeach
            @endif
        </div>
    </div>
</div>
