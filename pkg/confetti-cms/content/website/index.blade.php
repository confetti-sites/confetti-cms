@foreach($model->get()['blocks'] ?? [] as $block)
    @include('pkg.confetti-cms.content.website.' . $block['type'], ['block' => $block])
@endforeach