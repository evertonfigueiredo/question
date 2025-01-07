<div class="row padding-1 p-1">
    <div class="col-md-12">

        <div class="form-group mb-2 mb20">
            <label for="pergunta" class="form-label">{{ __('Pergunta') }}</label>
            <input type="text" name="pergunta" class="form-control @error('pergunta') is-invalid @enderror"
                value="{{ old('pergunta', $pergunta?->pergunta) }}" id="pergunta" placeholder="Pergunta">
            {!! $errors->first('pergunta', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="categoria_id" class="form-label">{{ __('Categoria') }}</label>
            <select name="categoria_id" class="form-control @error('categoria_id') is-invalid @enderror">
                <option value="">Selecione a Categoria</option>

                @foreach ($categorias as $categoria)
                    <option value="{{ $categoria->id }}"
                        {{ $pergunta->categoria_id == $categoria->id ? 'selected' : '' }}>
                        {{ $categoria->name }}
                    </option>
                @endforeach
            </select>
            {!! $errors->first('categoria_id', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

        <div class="form-group mb-2 mb20">
            <label for="tipo" class="form-label">{{ __('Tipo') }}</label>
            <select name="tipo" class="form-control @error('tipo') is-invalid @enderror">
                <option value="P" {{ old('tipo', $pergunta->tipo ?? 'P') === 'P' ? 'selected' : '' }}>Positiva</option>
                <option value="N" {{ old('tipo', $pergunta->tipo ?? 'P') === 'N' ? 'selected' : '' }}>Negativa</option>
            </select>
            {!! $errors->first('tipo', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>



    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-success">{{ __('Enviar') }}</button>
    </div>
</div>
