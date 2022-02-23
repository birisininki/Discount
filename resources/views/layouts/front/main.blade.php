@include('layouts.front.head')
@include('layouts.front.header')

<content class="content">
    <div class="container">
        <div class="layout">
            @include('layouts.front.leftblock')
            <div class="main-content">
                <div class="page-inner">
                    @include('layouts.front.games')
                    @if(session()->has('loggedInUser'))
                        <a href="{{route('user-logout')}}" class="header-menu__link" style="float:right;">Çıkış Yap</a>
                    @endif
                    @yield('content')
                </div>
            </div>
            @include('layouts.front.rightblock')
        </div>
    </div>
</content>

@include('layouts.front.footer')