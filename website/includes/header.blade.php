<header class="lg:container lg:mx-auto z-50 bg-white/80 backdrop-blur-sm border-b border-gray-100 w-full">
    <nav class="relative">
        <div class="flex items-center justify-between px-4 py-2">
            <!-- Logo Container -->
            <div id="logo" class="flex items-center p-2">
                <a href="/" aria-label="logo" class="flex items-center space-x-4">
                    <img src="/website/public/confetti_cms_logo.png" class="h-10 w-auto" width="288" height="166" alt="">
                    <span class="text-xl" id="brand-title">Confetti CMS</span>
                </a>
            </div>
            <div></div>
            <div class="flex justify-end  md:justify-end">
                <!-- Hamburger Icon -->
                <button id="menu-toggle" type="button" aria-label="Toggle Navigation" class="text-gray-600 focus:outline-hidden md:hidden">
                    <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"/>
                    </svg>
                </button>
                <!-- Navigation Links -->
                <div class="js-menu hidden flex-col space-y-2 px-4 py-2 bg-white md:flex md:flex-row md:space-y-0 md:space-x-4 md:border-none md:py-0">
                    <a href="/" class="block md:hidden transition hover:text-primary px-4 py-2 md:py-2">Home</a>
                    <a href="/pricing" class="block relative transition hover:text-primary px-4 py-2 md:py-2">Pricing</a>
                    <a href="/docs/installation" class="block transition hover:text-primary px-4 py-2 md:py-2">Docs</a>
                    <div class="relative">
                        <button id="github-toggle"
                                type="button"
                                class="flex items-center gap-1 transition hover:text-primary px-4 py-2 md:py-2 cursor-pointer"
                        >GitHub
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>

                        <div id="github-menu" class="hidden absolute right-0 top-full z-50 mt-2 min-w-56 flex-col rounded-xl border border-gray-100 bg-white py-2 shadow-lg">
                            <a href="https://github.com/confetti-cms/community/discussions" target="_blank" class="px-4 py-2 transition hover:bg-gray-50 cursor-pointer">Community</a>
                            <a href="https://github.com/confetti-sites/office_template" target="_blank" class="px-4 py-2 transition hover:bg-gray-50 cursor-pointer">Example Repository</a>
                        </div>
                    </div>
                    @guest
                        <a href="/waiting-list" class="relative ml-auto flex h-10 w-full items-center justify-center before:absolute before:inset-0 before:rounded-full before:bg-primary before:transition-transform before:duration-300 hover:before:scale-105 active:duration-75 active:before:scale-95 px-4">
                            <span class="relative text-sm font-semibold text-white">
                                Join<span class="hidden sm:contents"> the Waitlist</span>
                            </span>
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </nav>
</header>

@pushonce('end_of_body_header')
<script>
    // Toggle menu visibility
    const menuToggle = document.getElementById('menu-toggle');
    const menu = document.getElementsByClassName('js-menu')[0];
    const logo = document.getElementById('logo');

    menuToggle.addEventListener('click', () => {
        menuToggle.classList.toggle('hidden');
        menu.classList.toggle('hidden');
        logo.classList.toggle('hidden');
    });

    // GitHub toggle
    const githubToggle = document.getElementById('github-toggle');
    const githubMenu = document.getElementById('github-menu');

    githubToggle.addEventListener('click', () => {
        githubMenu.classList.toggle('hidden');
        githubMenu.classList.toggle('flex');
    });

    document.addEventListener('click', (event) => {
        if (
            !githubToggle.contains(event.target) &&
            !githubMenu.contains(event.target)
        ) {
            githubMenu.classList.add('hidden');
            githubMenu.classList.remove('flex');
        }
    });
</script>
@endpushonce

