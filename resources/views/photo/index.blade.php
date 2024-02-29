@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="d-flex align-items-center justify-content-between">
            <h2 class="fw-bold my-5 ">Photos</h2>
            @if ($user->id == auth()->id())
                <button type="button" class="btn btn-primary rounded-5" data-bs-toggle="modal" data-bs-target="#createPhoto">
                    Create Photo
                </button>
            @endif
        </div>

        <div class="row justify-content align-items-strecth">
            <x-card :photos="$photos" />
        </div>
    </div>


    <div class="modal fade" id="createPhoto" tabindex="-1" aria-labelledby="createPhotoLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('photo.store', [$user->username, $album->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="createPhotoLabel">Create Album</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="row mb-3">
                            <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                            <div class="col-md-6">
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror" name="name"
                                    value="{{ old('name') }}" autocomplete="name">

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="path" class="col-md-4 col-form-label text-md-end">{{ __('Path') }}</label>

                            <div class="col-md-6">
                                <input id="path" type="file"
                                    class="form-control @error('path') is-invalid @enderror" name="path">

                                @error('path')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="description"
                                class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>

                            <div class="col-md-6">
                                <input id="description" type="text"
                                    class="form-control @error('description') is-invalid @enderror" name="description"
                                    value="{{ old('description') }}" autocomplete="description">

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
