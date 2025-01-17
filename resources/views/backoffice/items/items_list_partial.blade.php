@foreach ($items as $item)
    @php
    $quantity = $item->quantity;
    $cost = $item->cost * $quantity;
    $retail = $item->retail * $quantity;
    $profit = $retail - $cost;
    @endphp
    <a href="{{route('office.view_item', ['sku' => $item->sku])}}">
        <div class="w-full flex items-center text-sm py-4 px-5 text-gray-700 border-b border-[#dadada]">
            <p class="w-[50%]">{{$item->item}}</p>
            <p class="w-[10%]">{{$item->quantity}}</p>
            <p class="w-[10%]">
                @php
                    echo '&#8369;'.$cost;
                @endphp
            </p>
            <p class="w-[10%]">
                @php
                    echo '&#8369;'.$retail
                @endphp
            </p>
            <p class="w-[10%]">
                @php
                    echo '&#8369;'.$profit;
                @endphp
            </p>
        </div>
    </a>
    @endforeach
@endforeach