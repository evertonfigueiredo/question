<div class="row padding-1 p-1">
    <div class="col-md-12">
        
        <div class="form-group mb-2 mb20">
            <label for="name" class="form-label">{{ __('Nome') }}</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $categoria?->name) }}" id="name" placeholder="Nome">
            {!! $errors->first('name', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="padrao" class="form-label">{{ __('Padrao') }}</label>
            <input type="text" name="padrao" class="form-control @error('padrao') is-invalid @enderror" value="{{ old('padrao', $categoria?->padrao) }}" id="padrao" placeholder="Resposta padrão para a categoria.">
            {!! $errors->first('padrao', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>
        <div class="form-group mb-2 mb20">
            <label for="resposta" class="form-label">{{ __('Resposta') }}</label>
            <input type="text" name="resposta" class="form-control @error('resposta') is-invalid @enderror" value="{{ old('resposta', $categoria?->resposta) }}" id="resposta" placeholder="Resposta positiva para a categoria.">
            {!! $errors->first('resposta', '<div class="invalid-feedback" role="alert"><strong>:message</strong></div>') !!}
        </div>

    </div>
    <div class="col-md-12 mt20 mt-2">
        <button type="submit" class="btn btn-primary">{{ __('Adicionar') }}</button>
    </div>
</div>