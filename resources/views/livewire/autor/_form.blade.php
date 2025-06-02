<div class="mb-3">
    <label for="Nome" class="form-label">Nome do Autor</label>
    <input type="text" class="form-control" id="Nome" name="Nome" placeholder="Digite o nome do autor"
        wire:model='Nome' >
    @error('Nome')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
