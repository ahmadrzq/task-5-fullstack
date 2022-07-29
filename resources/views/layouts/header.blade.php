<header class="blog-header py-3">
    <div class="row flex-nowrap justify-content-between align-items-center">
        <div class="col-4 pt-1">
        </div>
        <div class="col-4 text-center">
            <a class="blog-header-logo text-dark" href="{{ url('/') }}">The AOV Blog </a>
        </div>
        <div class="col-4 d-flex justify-content-end align-items-center">
            @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <p>Welcome, {{ auth()->user()->name }}</p>

                        <a class="btn btn-sm btn-outline-secondary" href="{{ url('dashboard') }}">Dashboard</a>

                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('logout') }}"
                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                            {{ __('Logout') }}
                        </a>

                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    @else
                        {{-- <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a> --}}
                        <a class="btn btn-sm btn-outline-secondary" href="{{ route('login') }}">Login</a>
                    @endauth
                </div>
            @endif

            {{-- <a class="btn btn-sm btn-outline-secondary" href="#">Sign up</a> --}}
        </div>
    </div>
</header>
