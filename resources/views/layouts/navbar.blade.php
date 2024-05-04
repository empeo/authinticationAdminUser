<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        @auth
        @if(auth()->user()->role == "admin")
            <a class="navbar-brand" href="{{ route('admin.home') }}">Home</a>
        @else
        <a class="navbar-brand" href="{{ route('user.home') }}">Home</a>
        @endif
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    @if (auth()->user()->role == 'admin')
                        <li class="nav-item">
                            <a class="nav-link fs-5 active" aria-current="page" href="{{ route('users.index') }}">My Users</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-5 active" aria-current="page" href="{{ route('posts.index') }}">User's Posts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-5 active" aria-current="page" href="{{ route('posts.create') }}">Create Admin Posts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-5 active" aria-current="page" href="{{ route('admin.profile') }}">{{auth()->user()->name}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-5 active" aria-current="page" href="{{ route('admin.dashboard') }}">dashboard</a>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link fs-5 active" aria-current="page" href="{{ route('post.index') }}">My Posts</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fs-5 active" aria-current="page" href="{{ route('user.profile') }}">{{auth()->user()->name}}</a>
                        </li>
                    @endif
                    <li class="nav-item">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button class="nav-link fs-5 active" type="submit">Logout</button>
                        </form>
                    </li>
                </ul>
            </div>
        @else
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a href="{{ route('login') }}" class="nav-link fs-5">Log in</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('register') }}" class="nav-link fs-5">Register</a>
                    </li>
                </ul>
            </div>
        @endauth
    </div>
</nav>
