<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Relatório de Livros por Autor</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #ccc; padding: 4px; }
        th { background: #eee; }
        h2 { margin-top: 30px; }
    </style>
</head>
<body>
    <h1>Relatório de Livros por Autor</h1>

    @php $autorAtual = null; @endphp

    @foreach($dados as $linha)
        @if ($autorAtual !== $linha->autor_id)
            @if (!is_null($autorAtual))
                </table>
            @endif

            <h2>Autor: {{ $linha->autor_nome }}</h2>
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Editora</th>
                        <th>Ano</th>
                        <th>Valor (R$)</th>
                        <th>Assuntos</th>
                    </tr>
                </thead>
                <tbody>

            @php $autorAtual = $linha->autor_id; @endphp
        @endif

        <tr>
            <td>{{ $linha->Titulo }}</td>
            <td>{{ $linha->Editora }}</td>
            <td>{{ $linha->AnoPublicacao }}</td>
            <td>{{ number_format($linha->Valor, 2, ',', '.') }}</td>
            <td>{{ $linha->assuntos }}</td>
        </tr>

        @if ($loop->last)
                </tbody>
            </table>
        @endif
    @endforeach

</body>
</html>
