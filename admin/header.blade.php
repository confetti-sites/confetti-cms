<header class="z-10 py-4 bg-white shadow-md dark:bg-gray-800">
    <div class="container flex items-center justify-between h-full px-3 mx-auto">
        <!-- Mobile hamburger -->
        <button type="button" id="menu-toggle" class="p-1 mr-5 -ml-1 rounded-md md:hidden focus:outline-hidden focus:ring-3" aria-label="Menu">
            <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                      d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                      clip-rule="evenodd"></path>
            </svg>
        </button>
        <div class="flex justify-center lg:mr-32 text-gray-500">
            {{-- placeholder for items in the middle --}}
        </div>

        <!-- Profile menu -->
        <div class="relative">
            <button type="button" class="align-middle rounded-full focus:ring-3 focus:outline-hidden pr-3">
                <a href="/">
                    <!-- Go to website svg -->
                    <span class="md:hidden text-gray-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24"><path stroke="currentColor" d="M 5 3 C 3.9069372 3 3 3.9069372 3 5 L 3 19 C 3 20.093063 3.9069372 21 5 21 L 19 21 C 20.093063 21 21 20.093063 21 19 L 21 12 L 19 12 L 19 19 L 5 19 L 5 5 L 12 5 L 12 3 L 5 3 z M 14 3 L 14 5 L 17.585938 5 L 8.2929688 14.292969 L 9.7070312 15.707031 L 19 6.4140625 L 19 10 L 21 10 L 21 3 L 14 3 z"></path></svg>
                    </span>
                    <span class="hidden md:inline text-sm font-semibold text-gray-700">{{ $_SERVER['HTTP_HOST'] }}</span>
                </a>

            </button>
            <button type="button" class="align-middle rounded-full focus:ring-3 focus:outline-hidden pr-3">
                <img class="object-cover w-8 h-8 rounded-full"
                     src="@userPicture"
                     alt="" aria-hidden="true"/>
            </button>
            <template>
                <ul class="absolute right-0 w-56 p-2 mt-2 space-y-2 text-gray-600 bg-white border border-gray-100 rounded-md shadow-md dark:border-gray-700 dark:text-gray-300 dark:bg-gray-700"
                    aria-label="submenu">
                    <li class="flex">
                        <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                           href="#">
                            <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round"
                                 stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <span>Profile</span>
                        </a>
                    </li>
                    <li class="flex">
                        <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                           href="#">
                            <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round"
                                 stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                            <span>Settings</span>
                        </a>
                    </li>
                    <li class="flex">
                        <a class="inline-flex items-center w-full px-2 py-1 text-sm font-semibold transition-colors duration-150 rounded-md hover:bg-gray-100 hover:text-gray-800 dark:hover:bg-gray-800 dark:hover:text-gray-200"
                           href="#">
                            <svg class="w-4 h-4 mr-3" aria-hidden="true" fill="none" stroke-linecap="round"
                                 stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24"
                                 stroke="currentColor">
                                <path d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path>
                            </svg>
                            <span>Log out</span>
                        </a>
                    </li>
                </ul>
            </template>
        </div>
    </div>
</header>
