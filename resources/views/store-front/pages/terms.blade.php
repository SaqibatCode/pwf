{{-- terms.blade.php --}}
@extends('store-front.layout.layout')

@section('main-content')
    <div class="container mx-auto px-4 py-8">
        <h2 class="section-heading mb-4">Terms & Conditions</h2>
        <div class="prose">
            {!! $terms->content ?? 'No Content Available' !!}
        </div>
    </div>
@endsection
