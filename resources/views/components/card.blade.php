@props(['photos'])

@foreach ($photos as $item)
    <div class="col-md-3 col-sm-2 mb-3">
        <div class="card bg-white">
            <div class="card-header bg-white d-flex align-items-center justify-content-between">
                <div>
                    <strong>
                        <a
                            href="{{ route('profile.index', $item->user->username) }}">{{ '@' . $item->user->username }}</a></strong>
                    <br>
                    <small>{{ $item->created_at->diffForHumans() }}</small>
                </div>
                <div class="dropdown-center">
                    <button class="bg-white px-2 border-0" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa-solid fa-ellipsis-vertical"></i>
                    </button>

                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item"
                                href="{{ route('photo.detail', [$item->user->username, $item->id]) }}">Detail</a></li>
                        @if ($item->user->id == auth()->id())
                            <li><a class="dropdown-item" href="#" data-bs-toggle="modal"
                                    data-bs-target="#editPhoto{{ $item->id }}">Edit</a></li>
                            <li><a class="dropdown-item text-danger" href="#" data-bs-toggle="modal"
                                    data-bs-target="#deletePhoto{{ $item->id }}">Delete</a></li>
                        @endif
                    </ul>
                </div>
            </div>

            <div class="card-body">
                <h5 class="card-title">{{ $item->name }}</h5>
                <div class="ratio ratio-1x1">
                    <img src="{{ asset('images/' . $item->path) }}" draggable="false"
                        class="object-fit-cover rounded-1">
                </div>
                <p class="card-text mt-2">{{ $item->description }}</p>
            </div>

            <div class="card-footer">
                @php
                    $userLiked = $item->likes->contains('user_id', auth()->id());
                @endphp
                <button type="button" class="border-0 bg-light btn-like" data-photo-id="{{ $item->id }}">
                    <i class="{{ $userLiked ? 'fa-solid fa-heart text-danger' : 'fa-regular fa-heart' }}"></i>
                    <span class="col-form-label">
                        {{ $item->likes()->count() }}
                    </span>
                </button>
                <button class="bg-light border-0"><i
                        class="fa-regular fa-message me-1"></i>{{ $item->comments()->count() }}</button>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editPhoto{{ $item->id }}" tabindex="-1" aria-labelledby="editPhotoLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('photo.update', [$item->user->username, $item->id]) }}" method="post"
                    enctype="multipart/form-data">
                    @csrf
                    @method('put')
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="editPhotoLabel">Edit Photo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                    class="form-control @error('description') is-invalid @enderror" name="description"
                                    value="{{ old('description', $item->description) }}" autocomplete="description">

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="path"
                                class="col-md-4 col-form-label text-md-end">{{ __('Path') }}</label>

                            <div class="col-md-6">
                                <input id="path" type="file"
                                    class="form-control @error('path') is-invalid @enderror" name="path"
                                    value="{{ old('path') }}" autocomplete="path">

                                @error('path')
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

    <div class="modal fade" id="deletePhoto{{ $item->id }}" tabindex="-1" aria-labelledby="deletePhotoLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('photo.delete', [$item->user->username, $item->id]) }}" method="post">
                    @csrf
                    @method('delete')
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="deletePhotoLabel">Delete Photo</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        You sure, delete this photo?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button class="btn btn-primary">Yes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $('.btn-like').click(function() {
            const btn = $(this);
            const id = btn.data('photo-id');

            $.ajax({
                'type': 'POST',
                'url': '{{ route('like.store', ':id') }}'.replace(':id', id),
                'data': {
                    '_token': '{{ csrf_token() }}'
                },
                success: function(data) {
                    btn.find('.col-form-label').text(data.likes);
                    btn.find('i').toggleClass(
                        'fa-regular fa-heart fa-solid fa-heart text-danger');
                },
                error: function(e) {
                    console.log(e);
                }
            });
        });
    });
</script>
