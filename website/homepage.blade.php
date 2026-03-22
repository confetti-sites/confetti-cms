@php(newRoot(new \model\homepage))
@section('head_title', 'Confetti CMS')
@section('head_description', 'Confetti CMS lets you build your own white-label CMS with full control over your templates.')
@extends('website.layouts.main')

@section('content')
    @include('website.includes.hero')
    @include('website.includes.usps')
{{--    -- examples of admin --}}
{{--    -- examples of different websites. Blogs / static websites --}}
    @include('website.includes.compare')
    @include('website.includes.steps')
    @include('website.includes.cta')
@endsection
