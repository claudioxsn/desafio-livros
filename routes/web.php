<?php

use App\Livewire\Assunto\AssuntoCreate;
use App\Livewire\Assunto\AssuntoEdit;
use App\Livewire\Assunto\AssuntoIndex;
use App\Livewire\Autor\AutorCreate;
use App\Livewire\Autor\AutorEdit;
use App\Livewire\Autor\AutorIndex;
use App\Livewire\Dashboard\Dashboard;
use App\Livewire\Livro\LivroCreate;
use App\Livewire\Livro\LivroEdit;
use App\Livewire\Livro\LivroIndex;
use App\Livewire\Relatorios\RelatorioLivrosPorAutor;
use Illuminate\Support\Facades\Route;

Route::get('autores/create', AutorCreate::class)->name('autor.create');
Route::get('autores', AutorIndex::class)->name('autor.index');
Route::get('autores/{CodAu}', AutorEdit::class)->name('autor.edit');

Route::get('assuntos/create', AssuntoCreate::class)->name('assunto.create');
Route::get('assuntos', AssuntoIndex::class)->name('assunto.index');
Route::get('assuntos/{codAs}', AssuntoEdit::class)->name('assunto.edit');

Route::get('livros/create', LivroCreate::class)->name('livro.create');
Route::get('livros', LivroIndex::class)->name('livro.index');
Route::get('livros/{Codl}', LivroEdit::class)->name('livro.edit');


Route::get('/relatorios', RelatorioLivrosPorAutor::class)->name('relatorio.livros.autor');

Route::get('/', Dashboard::class)->name('dashboard');