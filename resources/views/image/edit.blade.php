@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header text-white bg-success text-center">
                    <strong>Editar imagen</strong>
                </div>

                <div class="card-body">
                    <form id="form-img-edit" enctype="multipart/form-data" action="{{ route('image.update') }}" method="POST" accept-charset="utf-8">
                        @csrf

                        <div class="col-md-8 mx-auto w-100">
                            <img style="max-height: 600px" class="img-thumbnail p-0" src="{{ route('image.get', ['filename' => $image->image_path]) }}" alt="Imagen de {{ $image->user->nick }}">
                        </div>
                        <hr>
                        <div class="form-group row">
                            <label for="image_path" class="col-form-label col-md-3 text-right">Imagen</label>
                            <div class="col-md-7">
                                <input type="file" class="form-control {{ $errors->has('image_path') ? ' is-invalid' : '' }}" name="image_path">
                                @if ($errors->has('image_path'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('image_path') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-form-label col-md-3 text-right">Descripcion</label>
                            <div class="col-md-7">
                                <textarea class="form-control {{ $errors->has('description') ? ' is-invalid' : '' }}" name="description" required>{{ $image->description }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <input type="hidden" name="img_id" value="{{ $image->id }}">

                        <div class="col-md-7 offset-3 pl-2">
                            <button class="btn btn-primary disabled" type="submit" disabled>Editar imagen</button>
                        </div>

                    </form>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
@endsection