<header class="header" style="background: #2c2c2c">
    <div class="header-wrapper">
        <div class="header-logo">
            <a href="https://www.betsmove{{$domain_number}}.com" target="_blank">
                <img src="{{asset('frontend/assets/images/icons/logo.svg')}}" alt="Betsmove Logo" class="logo">
            </a>
        </div>
        <div class="header-content">
            <div class="header-auth">
                <a class="header-auth__btn_block"></a>
                <div class="header-language">
                    <img class="header-language__flag" src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b4/Flag_of_Turkey.svg/2560px-Flag_of_Turkey.svg.png" alt="">
                </div>
                <!--
                <a class="header-auth__btn sing-up" href="https://www.betsmove{{$domain_number}}.com/tr/register" target="_blank">KAYIT OL</a>
                <a class="header-auth__btn" href="https://www.betsmove{{$domain_number}}.com/tr/sports/i/#hc=d" target="_blank">GİRİŞ YAP</a>
                <div class="header-language">
                    <img class="header-language__flag" src="https://upload.wikimedia.org/wikipedia/commons/thumb/b/b4/Flag_of_Turkey.svg/2560px-Flag_of_Turkey.svg.png" alt="">
                </div>
                -->
            </div>
            <div class="header-menu">
                <a href="https://www.betsmove{{$domain_number}}.com/tr/sports/i/" target="_blank" class="header-menu__link">Spor Bahisleri</a>
                <a href="https://www.betsmove{{$domain_number}}.com/tr/live-sports/i/canli-spor/futbol/1/t%C3%BCm%C3%BC/0" target="_blank" class="header-menu__link">Canli Bahis</a>
                <a href="https://www.betsmove{{$domain_number}}.com/tr/sports/i/espor" target="_blank" class="header-menu__link">Espor</a>
                <a href="https://www.betsmove{{$domain_number}}.com/tr/casino/cat/sanal-sporlar" target="_blank" class="header-menu__link">Sanal Sporlar</a>
                <a href="https://www.betsmove{{$domain_number}}.com/tr/casino" target="_blank" class="header-menu__link">Casino</a>
                <a href="https://www.betsmove{{$domain_number}}.com/tr/live-casino" target="_blank" class="header-menu__link">Canlı Casino</a>
                <a href="https://www.betsmove{{$domain_number}}.com/tr/promotions" target="_blank" class="header-menu__link">Promosyonlar</a>
                <a href="{{route('home')}}" class="header-menu__link active active-link">Discount</a> 
                <a href="https://truelink.to/bmpiyango" class="header-menu__link">Piyango</a>
                <a href="https://betsmove.link/tv" target="_blank" class="header-menu__link">Betsmove TV</a>
                @if(session()->has('loggedInUser'))
                    <a href="{{route('user-logout')}}" class="header-menu__link">Çıkış Yap</a>
                @endif
            </div>
        </div>
    </div>
</header>
<div class="header-mobile">
    <div class="header-mobile--block">
        <img src="{{asset('frontend/assets/images/icons/burger.svg')}}" alt="Betsmove Logo" class="burger-menu openMenu">
        <img src="{{asset('frontend/assets/images/icons/logo.svg')}}" alt="Betsmove Logo" class="mobile-logo">
    </div>
    <div class="header-mobile--block">
        <div class="header-mobile__btn_block"></div>
    </div>
    <!--
    <div class="header-mobile--block">
        <button class="header-mobile__btn" onclick="location.href='https://www.betsmove{{$domain_number}}.com/tr/sports/i/#hc=d'">GİRİŞ YAP</button>
        <button class="header-mobile__btn sing-up" onclick="location.href='https://www.betsmove{{$domain_number}}.com/tr/register'">KAYIT OL</button>
    </div>
    -->
    <div class="header-mobile--overlay"></div>
    <div class="header-mobile__nav">
        <div class="header-mobile__nav-header">
            <img class="mobile-nav__close-image closeModal" src="{{asset('frontend/assets/images/icons/close.svg')}}" alt="">
            <a href="/"><img class="mobile-nav__logo" src="{{asset('frontend/assets/images/icons/logo.svg')}}" alt=""></a>
        </div>
        <div class="header-mobile__nav-content">
            <a href="https://www.betsmove{{$domain_number}}.com/tr/sports/i/" target="_blank" class="header-mobile__link">Spor Bahisleri</a>
            <a href="https://www.betsmove{{$domain_number}}.com/tr/live-sports/i/canli-spor/futbol/1/t%C3%BCm%C3%BC/0" target="_blank" class="header-mobile__link">Canli Bahis</a>
            <a href="https://www.betsmove{{$domain_number}}.com/tr/sports/i/espor" target="_blank" class="header-mobile__link">Espor</a>
            <a href="https://www.betsmove{{$domain_number}}.com/tr/casino/cat/sanal-sporlar" target="_blank" class="header-mobile__link">Sanal Sporlar</a>
            <a href="https://www.betsmove{{$domain_number}}.com/tr/casino" target="_blank" class="header-mobile__link">Casino</a>
            <a href="https://www.betsmove{{$domain_number}}.com/tr/live-casino" target="_blank" class="header-mobile__link">Canli Casino</a>
            <a href="https://www.betsmove{{$domain_number}}.com/tr/promotions" target="_blank" class="header-mobile__link">Promosyonlar</a>
            <a href="{{route('home')}}" class="header-mobile__link active">Discount</a>
            <a href="https://truelink.to/bmpiyango" class="header-mobile__link">Piyango</a>
            <a href="https://betsmove.link/tv" target="_blank" class="header-mobile__link">Betsmove TV</a>
            
            @if(session()->has('loggedInUser'))
                <a href="" class="header-menu__link">Kazandıklarım</a>
                <a href="{{route('user-logout')}}" class="header-mobile__link">Çıkış Yap</a>
            @endif
        </div>
    </div>
</div>