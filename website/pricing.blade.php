@extends('website.layouts.main')
@php($pricing = newRoot(new \model\pricing))
@section('head_title', 'Pricing')
@section('content')
    <!-- Start pricing -->
    <section class="relative mb-10 pt-20">
        <div class="relative container mx-auto">
            <div class="absolute mt-0 right-4 lg:left-40 w-32 h-32 md:w-48 md:h-48 bg-green-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 -z-10"></div>
            <div class="absolute mt-[400px] lg:mt-[500px] -left-4 lg:left-[500px] w-64 h-64 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 -z-10"></div>
            <div class="absolute mt-[600px] lg:mt-[700px] left-20 md:left-[300px] lg:left-[600px] w-64 h-64 bg-yellow-300 rounded-full mix-blend-multiply filter blur-xl opacity-70 -z-10"></div>
            <div class="relative -mx-4 flex flex-wrap">
                <div class="js-edit:{{ $pricing->getId() }} w-full px-4">
                    <div class="mx-auto max-w-[510px] text-center">
                        <h2 class="text-blue-500 mb-2 block text-lg font-semibold">Confetti comes with hosting</h2>
                        <div class="mb-4 text-3xl font-bold text-4xl md:text-[40px]">Only pay for hosting</div>
                        <p class="text-body-color text-base font-body font-bold text-balance">
                            Only pay for hosting once your site goes live. With Confetti, you don’t need any additional hosting; we manage all server resources in-house, ensuring transparent and predictable costs.
                        </p>
                    </div>
                </div>
            </div>
            <div class="-mx-4 md:mx-2 flex flex-wrap justify-center pt-8 space-y-4">
                <div class="w-full md:w-1/2 px-4 md:pt-8">
                    <div class="border-blue-500 relative overflow-hidden rounded-xl border border-opacity-20 bg-white p-8">
                        <h2 class="text-blue-500 mb-4 block text-lg font-semibold">
                            {{ $pricing->text('one_website')->default('One website') }}
                        </h2>
                        <div class="mb-4 text-4xl sm:text-5xl md:text-4xl lg:text-4xl font-bold">{{ $pricing->text('one_website_price')->default('Free') }}</div>
                        <p class="text-body-color text-base font-body font-bold">
                            @include('pkg.confetti-cms.content.website.index', ['model' => $pricing->content('one_website_description')])
                        </p>
                        <a href="/waiting-list" class="bg-primary border-primary block w-full rounded-md border mt-8 p-4 text-center text-base font-semibold text-white transition hover:bg-opacity-90">
                            Get started
                        </a>
                    </div>
                </div>
                <div class="w-full md:w-1/2 px-4 md:pt-8">
                    <div class="relative h-full rounded-xl border border-blue-500 border-opacity-20 bg-white p-8">
                        <h2 class="text-blue-500 mb-4 block text-lg font-semibold">
                            {{ $pricing->text('agency_program')->default('Agency Program') }}
                        </h2>
                        <div class="mb-4 text-4xl sm:text-5xl md:text-4xl lg:text-4xl font-bold">
                            {{ $pricing->text('agency_program_price')->default('Cheaper than AWS') }}
                        </div>
                        <p class="text-body-color text-base">
                            @include('pkg.confetti-cms.content.website.index', ['model' => $pricing->content('agency_program_description')])
                        </p>

                        <a href="{{ $pricing->form('form')->get()['share_link'] ?? null }}" target="_blank" class="bg-primary border-primary block w-full rounded-md border mt-8 p-4 text-center text-base font-semibold text-white transition hover:bg-opacity-90">
                            Join the agency program
                        </a>
                    </div>
                </div>
            </div>
            <div class="-mx-4 md:mx-20 mt-10 p-4">
                <h2 class="text-blue-500 mb-4 block text-lg font-semibold">
                    Do you have a high traffic website?
                </h2>
                <p class="text-body-color text-base font-body font-bold">Let us handle the stress for you. So you can scale your business.</p>
                <ul class="mt-3 list-disc list-inside text-gray-500 font-body">
                    <li class="text-body-color mb-1 ">Backups</li>
                    <li class="text-body-color mb-1 ">SSL-certificate</li>
                    <li class="text-body-color mb-1 ">Multiple domains</li>
                    <li class="text-body-color mb-1 ">Private network</li>
                    <li class="text-body-color mb-1 ">Test environments</li>
                    <li class="text-body-color mb-1 ">Secured with Auth0</li>
                </ul>
            </div>
        </div>
    </section>
    <!-- End pricing -->
    <!-- Newsletter -->
    @include('website.includes.newsletter')
    <!-- FAQ -->
    <section class="relative container mx-auto mb-8 pt-20 lg:pt-35 px-4 lg:px-6 bg-white dark:bg-gray-900 dark:text-white">
        <h2 class="mb-8 text-4xl tracking-tight font-extrabold md:text-center">Frequently asked questions</h2>
        <div class="grid pt-8 text-left border-t border-gray-200 md:gap-8 dark:border-gray-700 md:grid-cols-2">
            <div class="absolute -mt-[250px] -left-4 md:left-[150px] w-72 h-72 bg-blue-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob "></div>
            <div class="absolute -mt-[50px] left-20 md:left-[250px] w-72 h-72 bg-yellow-100 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000"></div>
            <div class="mb-4">
                <h3 class="flex items-center mb-4 text-lg font-medium">
                    <svg class="shrink-0 mr-2 w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                    </svg>
                    Are You Open to Partnering With Us?
                </h3>
                <p class="text-gray-500 font-body">
                    Yes, we would be delighted to partner with you. Whether your company needs assistance with technical challenges or wants to collaborate on building the fundament of new components, we’re here to help.
                </p>
            </div>
            <div class="mb-4">
                <h3 class="flex items-center mb-4 text-lg font-medium">
                    <svg class="shrink-0 mr-2 w-5 h-5 text-gray-500" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-8-3a1 1 0 00-.867.5 1 1 0 11-1.731-1A3 3 0 0113 8a3.001 3.001 0 01-2 2.83V11a1 1 0 11-2 0v-1a1 1 0 011-1 1 1 0 100-2zm0 8a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd"></path>
                    </svg>
                    Can I reuse code over multiple websites?
                </h3>
                <p class="text-gray-500 font-body">
                    You can clone micro repositories anywhere in your project. Similar to Git Submodules, but better. Or use Composer to include packages from Packagist.
                </p>
            </div>
        </div>
    </section>
@endsection

