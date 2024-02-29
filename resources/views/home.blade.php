@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content align-items-strecth">

            <x-card :photos="$photos" />

        </div>
    </div>
@endsection
