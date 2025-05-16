@switch($block['data']['level'])
    @case(1)
        <h1 id="{{ $data['id'] }}" class="my-3 text-4xl font-extrabold font-body">{!! $block['data']['text'] !!}</h1>
        @break
    @case(2)
        <h2 id="{{ $data['id'] }}" class="my-3 text-3xl font-bold font-body">{!! $block['data']['text'] !!}</h2>
        @break
    @case(3)
        <h3 id="{{ $data['id'] }}" class="my-3 text-2xl font-semibold font-body">{!! $block['data']['text'] !!}</h3>
        @break
    @case(4)
        <h4 id="{{ $data['id'] }}" class="mt-3 text-xl font-medium font-body">{!! $block['data']['text'] !!}</h4>
        @break
    @case(5)
        <h5 id="{{ $data['id'] }}" class="mt-3 text-lg font-normal font-body">{!! $block['data']['text'] !!}</h5>
        @break
    @case(6)
        <h6 id="{{ $data['id'] }}" class="mt-3 text-lg font-light font-body">{!! $block['data']['text'] !!}</h6>
        @break
@endswitch