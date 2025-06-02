<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $title ?? 'Page Title' }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    @livewireStyles
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="{{ route("dashboard")}}">Sistema de Livros</a>

            <div class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="{{ route('assunto.index')}}">Assuntos</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('autor.index') }}">Autores</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('livro.index')}}">Livros</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('relatorio.livros.autor')}}">Relatório</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container mt-4 mb-5">
        {{ $slot }}
    </main>

    <footer class="bg-light text-center py-3 fixed-bottom border-top">
        <small>Teste em Laravel — {{ date('Y') }}</small>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    @livewireScripts
</body>

</html>
