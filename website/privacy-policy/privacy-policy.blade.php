@php($page = newRoot(new \model\privacy_policy))

@extends('website.layouts.main')
@section('head_title', 'Privacy Policy')
@section('content')
    {{-- Generated with prompt: Generate a privacy policy page with a title and a content block. --}}
    <div class="py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:mx-0">
                <h2 class="text-4xl font-semibold tracking-tight text-pretty text-gray-900 sm:text-5xl">{{ $page->text('title')->max(50)->default('Privacy Policy') }}</h2>
                <p class="mt-2 text-lg/8 text-gray-600">@include('website.includes.blocks.index', ['model' => $page->content('content')])</p>
            </div>
        </div>
    </div>
@endsection