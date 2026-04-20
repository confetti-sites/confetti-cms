<div class="lg:container lg:mx-auto md:flex md:items-center md:justify-center bg-white mt-4 lg:mb-10">
    <div class="container mb-8 flex flex-col items-center justify-center md:w-1/2">
        <h1 class="mt-4 ml-4 text-5xl text-gray-900 xl:text-center text-pretty">
            <span>For custom</span>&nbsp;<span class="xl:block">made websites</span>
        </h1>
        <div class="flex items-center">
            <div class="mt-8">
                <a href="/docs/text" class="inline-block border-2 border-blue-500 bg-white text-blue-600 px-6 py-3 rounded-lg">Learn More</a>
            </div>
            <div class="mt-8 ml-4">
                <a href="/waiting-list" class="inline-block border-2 border-primary bg-primary text-white px-6 py-3 rounded-lg">Get Started</a>
            </div>
        </div>
    </div>
    <text-demo class="bg-gray-50 md:bg-white px-2 pb-2 md:w-1/2 md:mr-10">
        <!-- skeleton loader -->
        <div class="font-body overflow-x-hidden py-8 md:pt-12">
            <div class="flex justify-center ">
                <div class="text-m md:text-base md:text-xl">
                    <div class="flex">
                        <span class="text-blue-500">&lt;h1&gt;</span>
                        <span class="text-black">@{{ $header-&gt;text(</span><span class="text-green-700">'title'</span><span class="text-black">)</span>
                        <span class="text-black">}}</span><span class="text-blue-500">&lt;/h1&gt;</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-4 md:mt-1 mx-4 sm:mx-auto sm:w-2/3 min-h-32">
            <div class="text-bold text-xl mt-2 mb-4 mx-2 h-4"></div>
            <div class="px-5 py-3 mx-2 text-gray-700 border-2 border-gray-400 rounded-lg bg-white font-body">&nbsp;</div>
            <p class="h-0 mx-2 mt-2 text-sm text-red-600 _error"></p>
        </div>
        <div class="font-body overflow-x-hidden py-8 md:pt-12">
            <div class="text-sm md:text-base lg:text-lg xl:text-xl">
                <div class="flex justify-center"><span class="text-black">Try it out yourself:</span></div>
            </div>
            <div class="flex mt-2 justify-center">
                <button class="mx-2 my-2 p-2 lg:p-3 text-sm lg:text-lg xl:text-xl leading-5 cursor-pointer border border-blue-500 rounded-md text-blue-500">
                    -&gt;required()
                </button>
                <button class="mx-2 my-2 p-2 lg:p-3 text-sm lg:text-lg xl:text-xl leading-5 cursor-pointer border border-blue-500 rounded-md text-blue-500">
                    -&gt;default()
                </button>
                <button class="mx-2 my-2 p-2 lg:p-3 text-sm lg:text-lg xl:text-xl leading-5 cursor-pointer border border-blue-500 rounded-md text-blue-500">
                    -&gt;bar()
                </button>
            </div>
        </div>
    </text-demo>
</div>

@pushonce('end_of_body_hero')
    <script type="module" defer>
        @php/** @see /website/public/mjs/homepage.mjs */@endphp
        import {TextDemo} from '/website/public/mjs/homepage.mjs';

        customElements.define('text-demo', TextDemo);
    </script>
@endpushonce

















