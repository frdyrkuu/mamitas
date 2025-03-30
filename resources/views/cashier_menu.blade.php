<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Dashboard</title>
</head>

<body class="w-full h-auto bg-[#ffd962]">
    {{-- <div id="cash_management" class="bg-main rounded-md w-1/5 mx-auto hidden absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50" id="scanner">
        <form action="{{route('cash_management')}}" method="POST" class="p-4 text-sm">
            @csrf
            <select name="reason" id="" class="w-full py-2 rounded-sm text-center mb-3 outline-none">
                <option value="paid_in">Paid in</option>
                <option value="paid_out">Paid out</option>
            </select>
            <div class="w-full flex flex-col mb-4">
                <label for="">Enter amount</label>
                <input type="number" name="amount" class="outline-none py-2 rounded-sm px-2 mt-1">
            </div>
            <button class="w-full py-2 rounded-sm uppercase font-medium bg-[#fefefe]">Confirm</button>
        </form>
    </div> --}}
    {{-- Top bar --}}
    {{-- <div class="w-full flex items-center h-[8%] px-20 border-b border-bd">
        <div class="w-1/6">
            <div class="">
                <img src="{{asset('images/logo2.png')}}" alt="" class="w-1/2">
            </div>
        </div>
    </div> --}}
    {{-- main --}}
    <div id="main" class="w-full flex h-full">
        {{-- navigations --}}
        <div class="w-[6%] py-6 bg-white">
            <div class="flex w-2/3 mx-auto flex-col items-center justify-center py-4 mb-3">
                <img src="{{ asset($cms->company_logo) }}" alt="">
            </div>
            <a href="{{ route('dashboard') }}" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{ asset('images/products-new.png') }}" alt="Home Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">Home</p>
            </a>
            <a href="{{ route('cashier') }}"
                class="flex w-2/3 mx-auto flex-col items-center justify-center py-4 rounded-xl bg-[#f5a7a4]">
                <img src="{{ asset('images/cashier-red.png') }}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#e5231a]">Cashier</p>
            </a>
            <a href="{{ route('history') }}" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{ asset('images/history-new.png') }}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">History</p>
            </a>
            <a href="{{ route('orders') }}" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{ asset('images/order-new.png') }}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">Orders</p>
            </a>
            <a href="{{ route('inventory') }}" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{ asset('images/inv-new.png') }}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">Inventory</p>
            </a>
            <a href="{{ route('office.login') }}" target="__blank"
                class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{ asset('images/backoffice-new.png') }}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">Office</p>
            </a>
        </div>
        {{-- POS --}}
        <div class="w-[94%] flex flex-col bg-[#e5e5e5] p-4 gap-6">
            <div class="w-full flex justify-end items-center py-3 gap-3">
                <div class="w-1/3 flex gap-2 justify-end">
                    <p class="text-[#747171]">Shift opened:</p>
                    <p class="font-semibold">{{ $time }}</p>
                </div>
                <div class="w-1/4 flex gap-10 items-center justify-end">
                    <form action="{{ route('end-shift') }}" method="POST" class="w-full">
                        @csrf
                        <button
                            class="w-full py-2 border-2 border-main rounded-lg text-main hover:bg-main hover:text-white ease-in-out duration-100">End
                            shift</button>
                    </form>
                    <a class="px-10 text-main underline" href="{{ route('welcome') }}">Break</a>
                </div>
            </div>
            <div class="w-full flex gap-[20px]">
                <div class="w-[60%] shadow-xl bg-[#f5f5f5] rounded-xl p-4">
                    <p class="mb-2 font-semibold">Cash drawer details</p>
                    <div class="w-full flex gap-[20px] flex-wrap items-center mb-5">
                        <div class="w-[28%] rounded-lg shadow-lg py-8 bg-[#e5e5e5] border">
                            <div class="flex flex-col gap-5">
                                <p class="text-center text-5xl font-bold">&#8369;{{ $shift->starting_cash }}</p>
                                <p class="text-center text-lg">Starting Cash</p>
                            </div>
                        </div>
                        <div class="w-[28%] py-8 rounded-lg shadow-lg bg-[#e5e5e5] border">
                            <div class="flex flex-col gap-5">
                                <p class="text-center text-5xl font-bold">&#8369;{{ $shift->cash_in ?? 0 }}</p>
                                <p class="text-center text-lg">Total Pay Ins</p>
                            </div>
                        </div>
                        <div class="w-[28%] py-8 rounded-lg shadow-lg bg-[#e5e5e5] border">
                            <div class="flex flex-col gap-5">
                                <p class="text-center text-5xl font-bold">
                                    &#8369;{{ $cashInPayments - $cashOutPayments ?? 0 }}</p>
                                <p class="text-center text-lg">GCash Payments</p>
                            </div>
                        </div>
                    </div>
                    <div class="w-full flex gap-[20px] justify-wrap items-center mb-5">
                        <div class="w-[28%] rounded-lg shadow-lg py-8 bg-[#e5e5e5] border">
                            <div class="flex flex-col gap-5">
                                <p class="text-center text-5xl font-bold">&#8369;{{ $cash ?? 0 }}</p>
                                <p class="text-center text-lg">Cash Payments</p>
                            </div>
                        </div>
                        <div class="w-[28%] rounded-lg shadow-lg py-8 bg-[#e5e5e5] border hidden">
                            <div class="flex flex-col gap-5">
                                <p class="text-center text-5xl font-bold">&#8369;{{ $shift->cash_out ?? 0 }}</p>
                                <p class="text-center text-lg">Total Petty Cash</p>
                            </div>
                        </div>
                        <div class="w-[28%] rounded-lg shadow-lg py-8 bg-[#e5e5e5] border">
                            <div class="flex flex-col gap-5">
                                <p class="text-center text-5xl font-bold">
                                    &#8369;{{ $cashOutCharge + $cashInCharge ?? 0 }}</p>
                                <p class="text-center text-lg">GCash Charges</p>
                            </div>
                        </div>
                    </div>
                    <div class="w-[40%] py-10 block mx-auto">
                        <div>
                            {{-- + $shift->starting_cash --}}
                            <p class="text-center text-5xl font-bold mb-2 text-main">
                                &#8369;{{ $shift->closing_cash + $shift->cash_in - $cashOutPayments + $cashInCharge + $cashOutCharge }}.00
                            </p>
                            <p class="text-center text-lg">Expected Cash</p>
                        </div>
                    </div>
                </div>
                <div id="parent" class="w-[40%] shadow-xl bg-[#f5f5f5] rounded-xl h-[623px] flex flex-col">
                    <p class="font-semibold p-4">Today's transactions</p>
                    <div class="w-full flex py-2 bg-[#bebebe] px-4">
                        <p class="font-medium w-1/4">Time</p>
                        <p class="font-medium w-1/4 text-center">Sale #</p>
                        <p class="font-medium w-1/4 text-center">Type</p>
                        <p class="font-medium w-1/4 text-right">Total</p>
                    </div>
                    <div id="child" class="w-full h-fit flex-1 overflow-y-auto rounded-bl-xl rounded-br-xl">
                        @foreach ($sales as $sale)
                            <div class="w-full flex py-2 border-b px-4">
                                <p class="w-1/4">{{ \Carbon\Carbon::parse($sale->created_at)->format('h:i a') }}</p>
                                <p class="w-1/4 text-center">{{ $sale->ticket }}</p>
                                <p class="w-1/4 text-center">{{ $sale->type }}</p>
                                <p class="w-1/4 text-right">&#8369; {{ $sale->total }}.00</p>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
            <div id="parent" class="w-1/2 shadow-xl bg-[#f5f5f5] rounded-xl h-auto flex flex-col px-[30px] mx-auto py-[30px]">
                <p class="font-semibold p-4">Gcash Payment Transactions</p>
                <div class="w-full flex py-2 bg-[#bebebe] px-4">
                    <p class="font-medium w-1/4">Time</p>
                    <p class="font-medium w-1/4 text-center">Transaction #</p>
                    <p class="font-medium w-1/4 text-center">Type</p>
                    <p class="font-medium w-1/4 text-right">Total</p>
                </div>
                <div id="child" class="w-full h-fit flex-1 overflow-y-auto rounded-bl-xl rounded-br-xl">
                    <!-- GCash Transactions -->
                    @foreach ($gcash as $transaction)
                        <div class="w-full flex py-2 border-b px-4 hover:bg-gray-100 bg-blue-50">
                            <p class="w-1/4">{{ \Carbon\Carbon::parse($transaction->created_at)->format('h:i a') }}
                            </p>
                            <p class="w-1/4 text-center">{{ $transaction->reference_number }}</p>
                            <p class="w-1/4 text-center">GCash</p>
                            <p class="w-1/4 text-right">&#8369; {{ number_format($transaction->amount, 2) }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            {{-- <div class="w-full col-span-3 row-span-2 bg-white rounded-xl px-5 py-3">
                <div class="w-full flex items-center h-full">
                    <div class="w-1/4 flex gap-5">
                        <p class="font-semibold">Terminal #:</p>
                        <p class="text-right">{{ $shift->POS_number }}</p>
                    </div>
                    <div class="w-1/4 flex gap-5">
                        <p class="font-semibold">Cashier:</p>
                        <p class="text-right">{{ $shift->cashier }}</p>
                    </div>
                    <div class="w-1/4 flex gap-5">
                        <p class="font-semibold">Shift opened:</p>
                        <p class="text-right">{{ $time }}</p>
                    </div>
                    <div class="w-1/4 flex justify-end">
                        <form action="{{ route('end-shift') }}" method="POST" class="w-1/2">
                            @csrf
                            <button class="w-full py-2 border-2 border-main rounded-lg text-main hover:bg-main hover:text-white ease-in-out duration-100">End shift</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="w-full col-start-3 row-start-3 row-span-10 bg-white rounded-xl px-5 py-3">
                <p class="pb-2 border-b border-[#565857] font-medium text-[#565857]">Today's sales</p>
                <div class="w-full pt-2">
                    <div class="w-full flex py-2 border-b">
                        <p class="font-medium w-1/3">Time</p>
                        <p class="font-medium w-1/3 text-center">Ticket#</p>
                        <p class="font-medium w-1/3 text-right">Total</p>
                    </div>
                    @foreach ($sales as $sale)
                        <div class="w-full flex py-1 border-b">
                            <p class="w-1/3">{{ \Carbon\Carbon::parse($sale->created_at)->format('h:i a') }}</p>
                            <p class="w-1/3 text-center">{{ $sale->ticket }}</p>
                            <p class="w-1/3 text-right">&#8369; {{ $sale->total }}.00</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="w-full row-start-3 row-span-7 bg-white rounded-xl px-5 py-3">
                <p class="pb-2 border-b border-[#565857] font-medium text-[#565857]">Cash drawer</p>
                <div class="w-full grid grid-cols-2 grid-rows-2 gap-2 h-[90%] pt-4">
                    <div class="w-full flex flex-col items-center">
                        <span class="w-[120px] h-[120px] rounded-full border-4 border-main flex items-center justify-center">
                            <p class="text-lg">&#8369; {{$shift->starting_cash}}.00</p>
                        </span>
                        <p class="text-center font-medium">Starting cash</p>
                    </div>
                    <div class="w-full flex flex-col items-center">
                        <span class="w-[120px] h-[120px] rounded-full border-4 border-proceed flex items-center justify-center">
                            <p class="text-lg">&#8369; {{$cash}}.00</p>
                        </span>
                        <p class="text-center font-medium">Cash payments</p>
                    </div>
                    <div class="w-full flex flex-col items-center justify-center">
                        <div class="flex items-center gap-4">
                            <img src="{{asset('images/paid-in.png')}}" alt="">
                            <p class="text-lg">&#8369; {{$shift->cash_in === null ? '0.00' : $shift->cash_in . '.0' }}</p>
                        </div>
                        <p>Paid in</p>
                    </div>
                    <div class="w-full flex flex-col items-center justify-center">
                        <div class="flex items-center gap-4">
                            <img src="{{asset('images/paid-out.png')}}" alt="">
                            <p class="text-lg">&#8369; {{$shift->cash_out === null ? '0.00' : $shift->cash_out . '.0' }}</p>
                        </div>
                        <p>Paid out</p>
                    </div>
                </div>
            </div>
            <div class="w-full row-start-3 col-start-2 row-span-7 bg-white rounded-xl px-5 py-3">
                <p class="pb-2 border-b border-[#565857] font-medium text-[#565857]">Sales summary</p>
                <div class="w-full flex flex-col h-[90%] justify-center gap-5">
                    <div class="w-full flex items-center justify-evenly">
                        <div>
                            <span class="w-[120px] h-[120px] rounded-full border-4 border-[#565857] flex items-center justify-center">
                                <p class="text-lg">&#8369; {{$cash}}.00</p>
                            </span>
                            <p class="text-center font-medium">Gross sales</p>
                        </div>
                        <div>
                            <span class="w-[120px] h-[120px] rounded-full border-4 border-[#565857] flex items-center justify-center">
                                <p class="text-lg">&#8369; {{$net_sales}}</p>
                            </span>
                            <p class="text-center font-medium">Net sales</p>
                        </div>
                    </div>
                    <div class="w-full flex flex-col items-center justify-center">
                        <span class="w-[120px] h-[120px] rounded-full border-4 border-proceed flex items-center justify-center">
                            <p class="text-xl">&#8369; {{($shift->closing_cash + $shift->cash_in) - $shift->cash_out}}.00</p>
                        </span>
                        <p class="font-medium">Expected Cash Amount</p>
                    </div>
                </div>
            </div>
            <div class="w-full row-start-10 row-span-3 bg-white rounded-xl px-5 py-3">
                <p class="pb-2 border-b border-[#565857] font-medium text-[#565857]">Money in / Gcash (Cash-in) / Load</p>
                <div class="w-full pt-3">
                    <form action="{{route('cash_management')}}" method="POST">
                        @csrf
                        <input id="pay" type="text" name="amount" placeholder="Enter amount" class="w-full outline-none rounded-lg px-4 py-1 border border-[#565857] mb-4">
                        <input type="hidden" name="reason" value="paid_in">
                        <button type="submit" class="w-full border border-main rounded-lg py-1 text-red hover:bg-main hover:text-white ease-in-out duration-100">Pay</button>
                    </form>
                </div>
            </div>
            <div class="w-full row-start-10 row-span-3 col-start-2 bg-white rounded-xl px-5 py-3">
                <p class="pb-2 border-b border-[#565857] font-medium text-[#565857]">Money out / Gcash (Cash-out)</p>
                <div class="w-full pt-3">
                    <form action="{{route('cash_management')}}" method="POST">
                        @csrf
                        <input id="pay1" type="text" name="amount" placeholder="Enter amount" class="w-full outline-none rounded-lg px-4 py-1 border border-[#565857] mb-4">
                        <input type="hidden" name="reason" value="paid_out">
                        <button type="submit" class="w-full border border-main rounded-lg py-1 text-red hover:bg-main hover:text-white ease-in-out duration-100">Pay</button>
                    </form>
                </div>
            </div> --}}

            {{-- <div class="w-1/3 bg-[#fefefe] py-4 h-fit">
                <div class="w-full flex gap-2 items-center justify-evenly py-2 px-4 mb-2">
                    <button onclick="openCashManagement()" class="w-1/2 py-2 border-2 border-main rounded-sm text-main">Cash management</button>
                    <form action="{{ route('end-shift') }}" method="POST" class="w-1/2">
                        @csrf
                        <button class="w-full py-2 border-2 border-main rounded-sm text-main">End shift</button>
                    </form>
                </div>
                <div class="w-full py-2 border-b">
                    <div class="px-4 flex items-center justify-between text-sm">
                        <p>Shift opened: {{$shift->cashier}}</p>
                        <p>{{$shift->created_at}}</p>
                    </div>
                </div>
                <div class="w-full border-b pb-2">
                    <p class="font-semibold text-main py-4 px-4 text-xs">Cash drawer</p>
                    <div class="w-full px-4 pb-4 flex items-center justify-between">
                        <p>Starting cash</p>
                        <p>&#8369;{{$shift->starting_cash}}</p>
                    </div>
                    <div class="w-full px-4 pb-4 flex items-center justify-between">
                        <p>Cash payment</p>
                        <p>&#8369;{{$cash}}</p>
                    </div>
                    <div class="w-full px-4 pb-4 flex items-center justify-between">
                        <p>Paid in</p>
                        <p>&#8369;{{$shift->cash_in === null ? '0.0' : $shift->cash_in . '.0' }}</p>
                    </div>
                    <div class="w-full px-4 pb-4 flex items-center justify-between">
                        <p>Paid out</p>
                        <p>&#8369;{{$shift->cash_out === null ? '0.0' : $shift->cash_out . '.0' }}</p>
                    </div>
                    <p class="font-semibold text-main py-4 px-4 text-xs">Sales summary</p>
                    <div class="w-full px-4 pb-4 flex items-center justify-between">
                        <p>Gross sales</p>
                        <p>&#8369;{{$cash}}</p>
                    </div>
                    <div class="w-full px-4 pb-4 flex items-center justify-between">
                        <p>Net sales</p>
                        <p>&#8369;{{$net_sales}}</p>
                    </div>
                    <div class="w-full px-4 flex items-center justify-between font-semibold">
                        <p>Expected cash amount</p>
                        <p>&#8369;{{($shift->closing_cash + $shift->cash_in) - $shift->cash_out}}</p>
                    </div>
                </div>
                <div>
                    
                </div>
            </div> --}}
        </div>
    </div>
    <script>
        document.getElementById('pay').addEventListener('input', function(e) {
            let value = e.target.value;
            // Remove all non-digit characters
            e.target.value = value.replace(/\D/g, '');
        });

        document.getElementById('pay1').addEventListener('input', function(e) {
            let value = e.target.value;
            // Remove all non-digit characters
            e.target.value = value.replace(/\D/g, '');
        });

        function setAmount(amount) {
            event.preventDefault()
            var cash = document.getElementById('cash')
            cash.value = amount
        }

        function openCashManagement() {
            var cash_management = document.getElementById('cash_management')
            var main = document.getElementById('main')


            cash_management.classList.toggle('hidden')
            if (!cash_management.classList.contains('hidden')) {
                main.style.filter = 'blur(5px)'
            } else {
                main.style.filter = 'blur(0)'
            }
        }
    </script>
</body>

</html>
