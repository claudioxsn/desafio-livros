<div class="mb-3">
    <label for="Descricao" class="form-label">Descrição do Assunto</label>
    <input type="text" class="form-control" id="Descricao" name="Descricao" placeholder="Digite a descrição do assunto"
        wire:model='Descricao' >
    @error('Descricao')
        <span class="text-danger">{{ $message }}</span>
    @enderror
</div>
