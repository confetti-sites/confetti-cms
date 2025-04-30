@php($current = extendModel($model))

<h1 class="text-3xl font-semibold text-gray-800 mb-2">{{ $current->text('title')->max(50) }}</h1>
<div class="mt-4 mb-4 text-gray-800 font-body">@include('website.includes.blocks.index', ['model' => $current->content('description')])</div>

@if ($current->tabs()->first())
    <div class="flex items-center justify-center mt-4 mb-4 space-x-4 text-xl border-b border-gray-300">
        @foreach($current->list('tab')->columns(['title'])->sortable()->max(3)->get() as $i => $os)
            <a href="#{{ $os->getId() }}" class="js-edit:{{ $os->getId() }} text-2xl text-blue-600 border-b border-blue-600">{{ $os->text('title')->max(50) }}</a>
        @endforeach
    </div>
    @foreach($current->list('tab')->columns(['title'])->sortable()->max(3)->get() as $i => $os)
        @foreach($os->list('step')->columns(['title'])->sortable()->max(10)->get() as $i => $step)
            <div class="flex relative py-10 w-full sm:items-center">
                <div class="h-full w-6 absolute inset-0 flex items-center justify-center">
                    <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
                </div>
                <div class="shrink-0 w-6 h-6 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-blue-500 text-white relative z-10 font-medium text-sm">
                    <span>{{ $i + 1 }}</span>
                </div>
                <div class="grow pl-6 flex sm:items-center items-start flex-col sm:flex-row">
                    <div class="js-edit:{{ $step->getId() }} grow sm:pl-6 mt-6 sm:mt-0 font-body">
                        <h2 class="font-semibold mb-1 text-xl">{{ $step->text('title')->max(50) }}</h2>
                        @include('website.includes.blocks.index', ['model' => $step->content('example')])
                    </div>
                </div>
            </div>
        @endforeach
    @endforeach

    @include('website.includes.blocks.index', ['model' => $current->content('second_description')])

    <div class="flex relative py-10 w-full sm:items-center">
        <div class="h-full w-6 absolute inset-0 flex items-center justify-center">
            <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
        </div>
        <div class="shrink-0 w-6 h-6 rounded-full mt-10 sm:mt-0 inline-flex items-center justify-center bg-blue-500 text-white relative z-10 font-medium text-sm">
            <span>3</span>
        </div>
        <div class="grow pl-6 flex sm:items-center items-start flex-col sm:flex-row">
            <div class="grow sm:pl-6 mt-6 sm:mt-0 font-body">
                <h2 class="font-semibold mb-1 text-xl">{{ $current->text('running_title')->max(50) }}</h2>
                @include('website.includes.blocks.index', ['model' => $current->content('example')])
            </div>
        </div>
    </div>

    @include('website.includes.blocks.index', ['model' => $current->content('third_description')])

@endif