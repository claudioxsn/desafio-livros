 <div class="container mt-5 card-container">
     <div class="card shadow-lg">
         <div class="card-header text-center bg-primary text-white">
             <h4>Cadastro de Assunto</h4>
         </div>
         <div class="card-body">
             <form wire:submit.prevent='store'>
                 @include('livewire.assunto._form')

                 <button type="submit" class="btn btn-primary">Cadastrar</button>
             </form>
         </div>
     </div>
 </div>
