@php($usps = newRoot(new \model\homepage\usps))
<div class="md:bg-gray-50">
    <div class="js-edit:{{ $usps->getId() }} container flex flex-col items-center justify-center py-8">
        <div class="px-4 pt-8 pb-8 md:flex md:items-center">
            <div class="flex flex-col md:flex-row justify-center gap-4">
                @foreach($usps->list('usp')->columns(['title', 'content'])->sortable()->min(2)->max(3)->get() as $usp)
                    <div class="js-edit:{{ $usp->getId() }} bg-white dark:bg-gray-900 rounded-lg shadow-lg overflow-hidden p-4 md:w-64">
                        <h3 class="flex text-lg font-medium text-blue-600 text-center">
                            {{ $usp->text('title')->max(50)->bar(['b', 'i', 'u']) }}
                        </h3>
                        <p class="mt-1 text-base text-gray-500 dark:text-white font-body">
                            {{ $usp->text('content')->max(50)->bar(['b', 'i', 'u']) }}
                        </p>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
