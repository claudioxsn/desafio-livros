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
            <input class="form-control me-2" placeholder="Buscar assunto" wire:model.live='search' aria-label="Buscar">
            <button class="btn btn-outline-primary" type="submit">Buscar</button>
        </div>

        {{-- Tabela --}}
        <div class="card">
            <div class="shadow rounded-4">
                <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white">
                    <h5 class="mb-0">Assuntos</h5>
                    <a href="{{ route('assunto.create') }}" class="btn btn-light btn-sm">
                        <i class="bi bi-plus-circle"></i> Novo Assunto
                    </a>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover">
                        <thead class="table-light">
                            <tr>
                                <th>Cod</th>
                                <th>Descrição</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assuntos as $assunto)
                                <tr>
                                    <td>{{ $assunto->codAs }}</td>
                                    <td>{{ $assunto->Descricao }}</td>
                                    <td>
                                        <a href="{{ route('assunto.edit', ['codAs' => $assunto->codAs]) }}"
                                            class="btn btn-info btn-sm">Editar</a>
                                        <button href="#" class="btn btn-danger btn-sm"
                                            wire:click='delete({{ $assunto->codAs }})'
                                            onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-center">
                        {{ $assuntos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
