@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-md-8">
                <div class="card bg-white">
                    <div class="card-header"><strong>{{ '@' . $photo->user->username }}</strong>
                        <br>
                        <small>{{ $photo->created_at->diffForHumans() }}</small>
                    </div>

                    <div class="card-body">
                        <h5 class="card-title">{{ $photo->name }}</h5>
                        <div class=""><img src="{{ asset('images/' . $photo->path) }}" draggable="false"
                                class="img-fluid ratio ratio-1x1 rounded-1"></div>
                        <p class="card-text mt-2">{{ $photo->description }}</p>
                    </div>
                    <div class="card-footer">
                        @php
                            $userLiked = $photo->likes->contains('user_id', auth()->id());
                        @endphp
                        <button type="button" class="border-0 bg-light btn-like" data-photo-id="{{ $photo->id }}">
                            <i class="{{ $userLiked ? 'fa-solid fa-heart text-danger' : 'fa-regular fa-heart' }}"></i>
                            <span class="col-form-label">
                                {{ $photo->likes()->count() }}
                            </span>
                        </button>
                        <button class="bg-light border-0"><i
                                class="fa-regular fa-message me-1"></i>{{ $photo->comments()->count() }}</button>
                    </div>
                </div>

                <div class="card bg-white mt-3">
                    <div class="card-body">
                        <form action="{{ route('comment.store', $photo->id) }}" method="post">
                            @csrf
                            <label for="" class="col-form-label">Comment</label>
                            <textarea name="description" class="form-control" placeholder="input your comment">{{ old('description') }}</textarea>
                            <button class="btn btn-primary float-end mt-3 rounded-5 px-3">Send</button>
                        </form>
                    </div>
                </div>

                @foreach ($photo->comments as $item)
                    <div class="card bg-white mt-3">
                        <div class="card-body">
                            <a href="{{ route('profile.index', $item->user->username) }}">
                                <strong>{{ '@' . $item->user->username }}</strong>
                            </a>
                            <br>
                            <small>{{ $item->created_at->diffForHumans() }}</small>
                            <br>
                            <div class="card-text">
                                {{ $item->description }}
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
@endsection

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
