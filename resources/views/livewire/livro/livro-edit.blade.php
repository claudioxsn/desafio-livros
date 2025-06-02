 <div class="container mt-5 card-container">
     <div class="card shadow-lg">
         <div class="card-header text-center bg-primary text-white">
             <h4>Edição de Livro</h4>
         </div>
         <div class="card-body">
             <form wire:submit.prevent="salvar">
                 <div class="row">
                     <div class="mb-3 col-md-6">
                         <label for="Titulo" class="form-label">Título</label>
                         <input type="text" class="form-control" id="Titulo" wire:model="Titulo">
                     </div>

                     <div class="mb-3 col-md-6">
                         <label for="Editora" class="form-label">Editora</label>
                         <input type="text" class="form-control" id="Editora" wire:model="Editora">
                     </div>

                     <div class="mb-3 col-md-6">
                         <label for="edicao" class="form-label">Edição</label>
                         <input type="number" class="form-control" id="edicao" wire:model="Edicao">
                     </div>

                     <div class="mb-3 col-md-3">
                         <label for="anoPublicacao" class="form-label">Ano de Publicação</label>
                         <input type="number" class="form-control" id="anoPublicacao" wire:model="AnoPublicacao">
                     </div>

                     <div class="mb-3 col-md-3">
                         <label for="valor" class="form-label">Valor</label>
                         <input type="number" step="0.01" class="form-control" id="valor" wire:model="Valor">
                     </div>
                     <div class="mb-3 col-md-6">
                         <label for="CodAu" class="form-label">Autores</label>
                         <select class="form-select" id="CodAu" wire:model="CodAu" multiple>
                             @foreach ($autores as $autor)
                                 <option value="{{ $autor->CodAu }}">{{ $autor->Nome }}</option>
                             @endforeach
                         </select>
                     </div>

                     <div class="mb-3 col-md-6">
                         <label for="codAs" class="form-label">Assuntos</label>
                         <select class="form-select" id="codAs" wire:model="codAs" multiple>
                             @foreach ($assuntos as $assunto)
                                 <option value="{{ $assunto->codAs }}">{{ $assunto->Descricao }}</option>
                             @endforeach
                         </select>
                     </div>
                 </div>
                 <button type="submit" class="btn btn-primary">Salvar</button>
             </form>
         </div>
     </div>
 </div>
