@extends('layouts.master')

@section('container')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 mb-3">
                <h2>{{ $post->title }}</h2>
                @if ($post->image)
                    <div style="max-height: 300px; overflow:hidden">
                        <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid"
                            alt="">
                    </div>
                @else
                    <img src="http://placeimg.com/1000/300/tech" class="img-fluid" alt="">
                @endif
                <article class="my-3 fs-5">
                    {!! $post->content !!}
                </article>
                <a href="/" class="text-decoration-none btn btn-primary">Back To News</a>
            </div>
        </div>
    </div>
@endsection
