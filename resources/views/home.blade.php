@extends('layouts.master')

@section('container')
    @if ($posts->count())
        <div class="p-4 p-md-5 mb-4 text-white rounded bg-dark">
            <div class="col-md-6">
                <h1 class="display-4 fst-italic">{{ $posts[0]->title }}</h1>
                <p class="lead my-3">{{ $posts[0]->excerpt }}</p>
                <p class="lead mb-0"><a href="/homeposts/{{ $posts[0]->slug }}" class="text-white fw-bold">Continue
                        reading...</a></p>
            </div>
        </div>

        <div class="row mb-2">
            @foreach ($posts->skip(1) as $post)
                <div class="col-md-6">
                    <div
                        class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-350 position-relative">
                        <div class="col p-4 d-flex flex-column position-static">
                            <a href="/homeposts?category={{ $post->category->slug }}"><strong
                                    class="d-inline-block mb-2 text-primary">{{ $post->category->name }}</strong></a>
                            <h3 class="mb-0">{{ $post->title }}</h3>
                            <div class="mb-1 text-muted">{{ $post->created_at->diffForHumans() }}</div>
                            <p class="card-text mb-auto">{{ $post->excerpt }}</p>
                            <a href="/homeposts/{{ $post->slug }}" class="stretched-link">Continue reading</a>
                        </div>

                        <div class="col-auto d-none d-lg-block">
                            <img class="bd-placeholder-img" width="300" height="300"
                                src="{{ asset('storage/' . $post->image) }}" role="img"
                                aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
                            <title>Placeholder</title>
                            <rect width="100%" height="100%" fill="#55595c" />
                            </img>


                            {{-- <img src="{{ asset('storage/' . $post->image) }}" style="width: 200; height:250"> --}}
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center fs-4">No posts found</p>
    @endif

    <div class="d-flex justify-content-center">
        {{ $posts->links() }}
    </div>

@endsection
