<div>
    <div class="container mt-5">

        @if (session()->has('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session()->has('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div class="d-flex justify-content-between align-items-center mb-3">
            <input class="form-control me-2" type="search" placeholder="Buscar por titulo" wire:model.lazy='search'
                aria-label="Buscar">
            <button class="btn btn-outline-primary" type="submit">Buscar</button>
        </div>

        {{-- Tabela --}}
        <div class="card">
            <div class="shadow rounded-4">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                    <h5 class="mb-0">livros</h5>
                    <a href="{{ route('livro.create') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-plus-circle"></i> Novo livro
                    </a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Cod</th>
                                <th>Título</th>
                                <th>Edição</th>
                                <th>Publicação</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($livros as $livro)
                                <tr>
                                    <td>{{ $livro->Codl }}</td>
                                    <td>{{ $livro->Titulo }}</td>
                                    <td>{{ $livro->Edicao }}</td>
                                    <td>{{ $livro->AnoPublicacao }}</td>
                                    <td>
                                        <a href="{{ route('livro.edit', ['Codl' => $livro->Codl]) }}"
                                            class="btn btn-info btn-sm">Editar</a>
                                        <button href="#" class="btn btn-danger btn-sm"
                                            wire:click='delete({{ $livro->Codl }})'>Excluir</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    {{ $livros->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
