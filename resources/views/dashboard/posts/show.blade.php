@extends('dashboard.layouts.master')

@section('container')
    <div class="container">
        <div class="row my-3">
            <div class="col-lg-8">
                <h2 class="mb-3">{{ $post->title }}</h2>
                <a href="/dashboard/posts" class="btn btn-success"><span data-feather="arrow-left"></span> Back to all my
                    posts</a>
                <a href="/dashboard/posts/{{ $post->slug }}/edit" class="btn btn-warning"><span
                        data-feather="edit"></span> Edit</a>
                <form action="/dashboard/posts/{{ $post->slug }}" method="POST" class="d-inline">
                    @method('delete')
                    @csrf
                    <button class="btn btn-danger border-0" onclick="return confirm('Are you sure?')"><span
                            data-feather="x-circle"></span> Delete</button>
                </form>
                @if ($post->image)
                    <div style="max-height: 300px; overflow:hidden">
                        <img src="{{ asset('storage/' . $post->image) }}" class="img-fluid mt-3"
                            alt="">
                    </div>
                @else
                    <img src="http://placeimg.com/1000/300/tech" class="img-fluid mt-3"
                        alt="">
                @endif
                <article class="my-3 fs-5">
                    {!! $post->content !!}
                </article>
            </div>
        </div>
    </div>
@endsection
