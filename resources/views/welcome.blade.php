@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content align-items-strecth">
            @foreach (range(0, 9) as $item)
                <div class="col-md-3 col-sm-2 mb-3">
                    <div class="card bg-white">
                        <div class="card-header bg-white"><strong>@Adrian</strong>
                            <br>
                            <small>{{ now()->diffForHumans() }}</small>
                        </div>

                        <div class="card-body">
                            <h5 class="card-title">hahaha</h5>
                            <div class="ratio ratio-1x1">
                                <img src="https://picsum.photos/200/300" draggable="false" class="object-fit-cover rounded-1">
                            </div>
                            <p class="card-text mt-2">hahaha</p>
                        </div>
                        <div class="card-footer">
                            <button class="bg-light border-0"><i class="fa-regular fa-heart fs-5 me-2"></i>1</button>
                            <button class="bg-light border-0"><i class="fa-regular fa-message fs-5 me-2"></i>1</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
