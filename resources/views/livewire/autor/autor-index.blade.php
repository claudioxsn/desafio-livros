<div>
    <div class="container mt-5">
        <!-- Mensagens de Sucesso e Erro -->
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

        <!-- Seção de Busca -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <input class="form-control me-2" type="search" name="busca" placeholder="Buscar por nome"
                aria-label="Buscar" wire:model.lazy='search'>
            <button class="btn btn-outline-primary" type="submit">
                <i class="bi bi-search"></i> Buscar
            </button>
        </div>

        {{-- Tabela de Autores --}}
        <div class="card">
            <div class="shadow rounded-4">
                <!-- Cabeçalho da Tabela -->
                <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                    <h5 class="mb-0">Autores</h5>
                    <a href="{{ route('autor.create') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-plus-circle"></i> Novo Autor
                    </a>
                </div>
                <div class="card-body p-0">
                    <!-- Tabela -->
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Cod</th>
                                <th>Nome</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($autores as $autor)
                                <tr>
                                    <td>{{ $autor->CodAu }}</td>
                                    <td>{{ $autor->Nome }}</td>
                                    <td>
                                        <a href="{{ route('autor.edit', ['CodAu' => $autor->CodAu]) }}"
                                            class="btn btn-info btn-sm">Editar</a>
                                        <!-- Botão de Exclusão -->
                                        <button class="btn btn-danger btn-sm" wire:click="delete({{ $autor->CodAu }})"
                                            onclick="return confirm('Tem certeza que deseja excluir este autor?')">
                                            Excluir
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- Paginação -->
                    <div class="d-flex justify-content-center">
                        {{ $autores->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
