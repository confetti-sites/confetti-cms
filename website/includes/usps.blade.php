@php($usps = newRoot(new \model\homepage\usps))
<div class="md:bg-gray-50">
    <div class="js-edit:{{ $usps->getId() }} container flex flex-col items-center justify-center py-8">
        <div class="px-4 pt-8 pb-8 md:flex md:items-center">
            <div class="grid grid-cols-1 gap-4 md:grid-cols-3">
                @foreach($usps->list('usp')->columns(['title', 'content'])->sortable()->get() as $usp)
                    <div class="js-edit:{{ $usp->getId() }} bg-white dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden p-4">
                        <h3 class="flex text-lg font-medium text-blue-600 text-center">
                            {{ $usp->text('title')->max(50)->bar(['b', 'i', 'u']) }}
                        </h3>
                        <p class="mt-1 text-base text-gray-500 dark:text-white font-body">
                            @include('pkg.confetti-cms.content.website.index', ['model' => $usp->content('content')])
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
