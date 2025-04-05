@php($model = newRoot(new \model\newsletter))

<div class="mx-auto max-w-[510px] mb-8 p-8 border-blue-500 relative overflow-hidden rounded-xl border border-opacity-20 bg-white">
    <div class="js-edit:{{ $model->getId() }}"></div>
    <div class="text-blue-500 mb-4 block text-lg font-semibold">
        {{ $model->text('description')->max(200) }}
    </div>
    <div class="mb-5 text-[30px] font-bold">
        {{ $model->newsletter->getTitle() }}
    </div>
    <div class="mt-4">
        {!! $model->form('newsletter')->embed() !!}
    </div>
</div>
