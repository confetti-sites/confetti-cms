@switch($block['data']['level'])
    @case(1)
        <h1 id="{{ $data['id'] }}" class="my-3 text-5xl font-extrabold ">{!! $block['data']['text'] !!}</h1>
        @break
    @case(2)
        <h2 id="{{ $data['id'] }}" class="my-3 text-4xl font-bold ">{!! $block['data']['text'] !!}</h2>
        @break
    @case(3)
        <h3 id="{{ $data['id'] }}" class="my-3 text-3xl font-semibold ">{!! $block['data']['text'] !!}</h3>
        @break
    @case(4)
        <h4 id="{{ $data['id'] }}" class="mt-3 text-2xl font-medium ">{!! $block['data']['text'] !!}</h4>
        @break
    @case(5)
        <h5 id="{{ $data['id'] }}" class="mt-3 text-xl font-normal ">{!! $block['data']['text'] !!}</h5>
        @break
    @case(6)
        <h6 id="{{ $data['id'] }}" class="mt-3 text-lg font-light ">{!! $block['data']['text'] !!}</h6>
        @break
@endswitch