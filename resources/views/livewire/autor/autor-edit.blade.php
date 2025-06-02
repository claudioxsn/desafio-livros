 <div class="container mt-5 card-container">
     <div class="card shadow-lg">
         <div class="card-header text-center bg-primary text-white">
             <h4>Edição de Autor</h4>
         </div>
         <div class="card-body">
             <form wire:submit.prevent='update'>
                 @include('livewire.autor._form')
                 <button type="submit" class="btn btn-primary">Salvar</button>
             </form>
         </div>
     </div>
 </div>
