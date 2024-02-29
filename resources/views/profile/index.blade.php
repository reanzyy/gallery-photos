@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card bg-white">
                    <div class="card-header">Profile</div>

                    <div class="card-body">
                        <div class="text-center mt-3">
                            <h4 class="card-title fw-bold mb-0">{{ '@' . $user->username }}</h4>
                            <div class="card-title fw-bold">({{ $user->name }})</div>
                            <div class="card-title"><i class="fa fa-envelope"></i>{{ $user->email }}</div>
                            @if ($user->address)
                                <div class="card-title"><i class="fa fa-envelope"></i>{{ $user->address }}</div>
                            @endif
                            <div class="text-center mt-3">
                                @if ($user->id == auth()->id())
                                    <a href="" class="btn btn-primary col-5 rounded-5">Edit Profile</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex align-items-center justify-content-between">
            <h2 class="fw-bold mt-5">Album</h2>
            @if ($user->id == auth()->id())
                <button type="button" class="btn btn-primary rounded-5" data-bs-toggle="modal"
                    data-bs-target="#createAlbum">
                    Create Album
                </button>
            @endif
        </div>

        <div class="row justify-content align-items-strecth mt-5">
            @foreach ($albums as $item)
                <div class="col-md-3 col-sm-2 mb-3">
                    <div class="card bg-white">
                        <div class="card-header bg-white d-flex align-items-center justify-content-between">
                            <div>
                                <strong>
                                    <a
                                        href="{{ route('profile.index', $user->username) }}">{{ '@' . $user->username }}</a></strong>
                                <br>
                                <small>{{ $item->created_at->diffForHumans() }}</small>
                            </div>
                            <div class="dropdown-center">
                                <button class="bg-white px-2 border-0" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-ellipsis-vertical"></i>
                                </button>

                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item"
                                            href="{{ route('photo.index', [$user->username, $item->id]) }}">Detail</a>
                                    </li>
                                    @if ($user->id == auth()->id())
                                        <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                data-bs-target="#editAlbum{{ $item->id }}">Edit</a></li>
                                        <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal"
                                                data-bs-target="#deleteAlbum{{ $item->id }}">Delete</a></li>
                                    @endif
                                </ul>
                            </div>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">{{ $item->name }}</h5>
                            <div class="ratio ratio-1x1">
                                @php
                                    $photo = $item->photos()->latest()->pluck('path')->first();
                                @endphp
                                <img src="{{ asset('images/' . $photo) }}" draggable="false"
                                    class="object-fit-cover rounded-1">
                            </div>
                            <p class="card-text mt-2">{{ $item->description }}</p>
                        </div>
                    </div>
                </div>


                <div class="modal fade" id="editAlbum{{ $item->id }}" tabindex="-1" aria-labelledby="editAlbumLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('album.update', [$item->id]) }}" method="post"
                                enctype="multipart/form-data">
                                @csrf
                                @method('put')
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="editAlbumLabel">Edit Photo</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">

                                    <div class="row mb-3">
                                        <label for="name"
                                            class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                        <div class="col-md-6">
                                            <input id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ old('name', $item->name) }}" autocomplete="name">

                                            @error('name')
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
                                                class="form-control @error('description') is-invalid @enderror"
                                                name="description" value="{{ old('description', $item->description) }}"
                                                autocomplete="description">

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

                <div class="modal fade" id="deleteAlbum{{ $item->id }}" tabindex="-1"
                    aria-labelledby="deletePhotoAlbum" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form action="{{ route('album.delete', [$item->id]) }}" method="post">
                                @csrf
                                @method('delete')
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="deletePhotoAlbum">Delete Album</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    You sure, delete this album?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button class="btn btn-primary">Yes</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

    </div>

    <div class="modal fade" id="createAlbum" tabindex="-1" aria-labelledby="createAlbumLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('album.store') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="createAlbumLabel">Create Album</h1>
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
