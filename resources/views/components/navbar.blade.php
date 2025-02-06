<div class="max-w-screen-xl items-center py-5 mx-5 md:m-auto text-gray-800">
    <header style="">
        <nav class="">
            <div class="container mx-auto md:flex items-center gap-6">
                <!-- Logo -->
                <div class="flex items-center justify-between md:w-auto w-full">
                    <a href="/" class="flex items-center py-5 flex-1">
                        <span class="font-bold">WahaMarket</span>
                    </a>
                    <!-- Mobile Menu Button -->
                    <div class="md:hidden flex items-center">
                        <button class="mobile-menu-button">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                                <title>bars-3-bottom-left</title>
                                <g fill="none">
                                    <path d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25H12" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </g>
                            </svg>
                        </button>
                    </div>
                </div>
                <!-- Primary Navigation -->
                <div class="hidden md:flex md:flex-row w-full flex-col items-center justify-start md:justify-end md:space-x-1 navigation-menu pb-3 md:pb-0 navigation-menu">
                    <a class="py-2 px-3 block hover:underline" href="{{ route('product.list') }}">Товари</a>
                    <a class="py-2 px-3 block hover:underline" href="{{ route('seller.list') }}">Продавці</a>
                    <a class="py-2 px-3 block hover:underline" href="{{ route('contact-us') }}">Контакти</a>
                    <a class="py-2 px-3 block hover:underline" href="{{ route('about-us') }}">Про нас</a>

                    @auth
                        <a class="py-2 px-3 block hover:underline" href="/account">
                            <x-filament::badge :color="'info'">{{ Auth::user()->name }}</x-filament::badge>
                        </a>
                        @livewire('database-notifications')
                    @endauth
                    @guest
                        <a class="py-2 px-3 block hover:underline" href="/account/login">
                            <x-filament::button>Увійти</x-filament::button>
                        </a>
                    @endguest
                </div>
            </div>
        </nav>
    </header>

    @vite('resources/js/components/navbar.js')
</div>
