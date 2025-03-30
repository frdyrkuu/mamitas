<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script> --}}
    <script src="{{ asset('jquery/jquery.js') }}"></script>
    @vite('resources/css/app.css')
    <title>Dashboard</title>
</head>
<body class="w-full h-screen bg-[#ffd962]">
    <div id="sale_details" class="hidden w-1/4 p-4 h-[520px] bg-white absolute top-1/2 right-0 transform -translate-y-1/2 z-10">
        <button onclick="shet()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" height="20" width="20"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M246.6 278.6c12.5-12.5 12.5-32.8 0-45.3l-128-128c-9.2-9.2-22.9-11.9-34.9-6.9s-19.8 16.6-19.8 29.6l0 256c0 12.9 7.8 24.6 19.8 29.6s25.7 2.2 34.9-6.9l128-128z"/></svg>
        </button>
        <p class="text-3xl text-center font-medium pt-7">&#8369;<span id="total_amount">0</span></p>
        <p class="text-sm text-center text-gray-500 border-b border-[#bebebe] pb-3">Total</p>
        <p class="px-2 text-sm pt-3 pb-1">Employee: <span id="employee_name">Employee</span></p>
        <p class="px-2 text-sm pt-1 pb-3 border-b border-[#bebebe]">Ticket #: <span id="ticket_number">1-1016</span></p>
        <div class="w-full px-2 pt-3 pb-1 max-h-[40%] overflow-auto border-b border-[#bebebe]">
            {{-- food loop --}}
            <div id="food_list">
            </div>
        </div>
        <div class="w-full px-2 flex items-center justify-between pt-3 pb-1 text-sm">
            <p>Cash</p>
            <p>&#8369;<span id="cash_amount">100</span></p>
        </div>
        <div class="w-full px-2 flex items-center justify-between pt-1 pb-3 text-sm border-b border-[#bebebe]">
            <p>Change</p>
            <p>&#8369;<span id="change_amount">50</span></p>
        </div>
        <div class="w-full px-2 flex items-center pt-2 justify-end text-sm text-gray-500">
            <p id="sale_time">5/8/24 10:49 AM</p>
        </div>
    </div>
    {{-- Top bar --}}
    {{-- <div class="w-full flex items-center h-[8%] px-20 border-b border-bd">
        <div class="w-1/6">
            <div class="">
                <img src="{{asset('images/logo2.png')}}" alt="" class="w-1/2">
            </div>
        </div>
    </div> --}}
    {{-- main --}}
    <div id="main" class="w-full flex h-full z-0">
        {{-- navigations --}}
        <div class="w-[6%] py-6 bg-white">
            <div class="flex w-2/3 mx-auto flex-col items-center justify-center py-4 mb-3">
                @if(isset($cms) && isset($cms->company_logo))
                <img src="{{ asset($cms->company_logo) }}" alt="Company Logo">
            @endif
            </div>
            <a href="{{route('dashboard')}}" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{asset('images/products-new.png')}}" alt="Home Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">Home</p>
            </a>
            <a href="{{route('cashier')}}" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{asset('images/cashier-new.png')}}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">Cashier</p>
            </a>
            <a href="{{route('history')}}" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4 rounded-xl bg-[#f5a7a4]">
                <img src="{{asset('images/history-red.png')}}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#e5231a]">History</p>
            </a>
            <a href="{{route('inventory')}}" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{asset('images/inv-new.png')}}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">Inventory</p>
            </a>
            <a href="{{route('orders')}}" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{asset('images/order-new.png')}}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">Orders</p>
            </a>
            <a href="{{route('office.login')}}" target="__blank" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{asset('images/backoffice-new.png')}}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">Office</p>
            </a>
        </div>
        {{-- POS --}}
        <div class="w-[94%] flex p-6 bg-[#e5e5e5]">
            <div class="w-full block mx-auto shadow-2xl rounded-xl p-4 bg-[#f4f4f4] overflow-hidden">
                <div class="mb-5">
                    <form action="{{route('purchased_date')}}" method="GET" class="flex gap-2 items-center">
                        <input type="date" id="date" name="date" class="px-2 py-1 border border-bd rounded-md">
                        <button class="px-10 py-1 bg-main rounded-md text-white">Filter</button>
                    </form>
                    <script>
                        // Get today's date
                        const today = new Date().toISOString().split('T')[0];
                        // Set the input value to today's date
                        document.getElementById('date').value = today;
                      </script>
                </div>
                <div class="w-full h-full">
                    <div class="w-full flex gap-4">
                        <div class="w-1/2 flex flex-col h-[640px]">
                            <p class="text-center font-semibold text-2xl mb-3">Cashier Transactions</p>
                            <div class="w-full flex items-center p-2 bg-[#bebebe] uppercase font-medium text-sm">
                                <p class="w-[15%] text-xs">Transaction #</p>
                                <p class="w-[20%]">Time</p>
                                <p class="w-[20%]">Customer</p>
                                <p class="w-[15%]">Type</p>
                                <p class="w-[15%]">Total</p>
                                <div class="w-[15%]"></div>
                            </div>
                            <div class="flex-1 overflow-y-auto">
                                @forelse ($history as $sale)
                                    <div class="w-full flex border-b border-[#bebebe] p-2 text-sm items-center">
                                        <p class="w-[15%]">{{ $sale->ticket }}</p>
                                        <p class="w-[20%]">{{ $sale->created_at->format('g:i A') }}</p>
                                        <p class="w-[20%]">{{ $sale->customer }}</p>
                                        <p class="w-[15%]">{{ $sale->type }}</p>
                                        <p class="w-[15%]">&#8369; {{ $sale->total }}</p>
                                        <div class="w-[15%]">
                                            @php
                                                if($sale->type != 'PETTY CASH' && $sale->type != 'PAY IN' && $sale->type != 'CASH IN' && $sale->type != 'CASH OUT'){
                                            @endphp
                                                    <button onclick="view({{ $sale->ticket }})" class="w-full py-1 bg-main rounded-lg block mx-auto text-white text-sm">
                                                        View
                                                    </button>
                                            @php
                                                }
                                            @endphp
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center text-gray-500 py-4">No purchases made</div>
                                @endforelse
                            </div>
                        </div>
                        <div class="w-1/2">
                            <p class="text-center font-semibold text-2xl mb-3">GCash Transactions</p>
                            <div class="w-full flex p-2 bg-[#bebebe] uppercase font-medium text-sm">
                                <p class="w-[25%]">Reference #</p>
                                <p class="w-[35%]">Date & Time</p>
                                <p class="w-[20%]">Transaction</p>
                                <p class="w-[20%]">Amount</p>
                            </div>
                            @forelse ($gcash as $gc)
                                <div class="w-full flex border-b border-[#bebebe] p-2 text-sm">
                                    <p class="w-[25%]">{{ $gc->transaction_number }}</p>
                                    <p class="w-[35%]">{{ $gc->created_at->format('g:i A') }}</p>
                                    <p class="w-[20%]">{{ $gc->type }}</p>
                                    <p class="w-[20%]">&#8369; {{ $gc->amount }}</p>
                                </div>
                            @empty
                                <div class="text-center text-gray-500 py-4">No transactions made</div>
                            @endforelse
                        </div>
                    </div>
                    
                </div>
            </div>  
        </div>
    </div>
    <script>
        function shet() {
            var modal = document.getElementById('sale_details');
            var main = document.getElementById('main');
            modal.classList.add('hidden');
            main.style.filter = 'blur(0)'
        }

        function view(ticket){
            var url = "{{ route('history.ticket', ['ticket' => ':ticket']) }}";
            url = url.replace(':ticket', ticket);
            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    $('#sale_details').removeClass('hidden');
                    var main = document.getElementById('main')
                    main.style.filter = 'blur(5px)'

                    // Update total amount
                    $('#total_amount').text(response.result[0].total);

                    // Update employee name
                    $('#employee_name').text(response.result[0].cashier);

                    // Update ticket number
                    $('#ticket_number').text(response.result[0].ticket);

                    // Update food items and prices
                    var foodListHtml = '';
                    $.each(response.food_prices, function(index, food_prices) {
                        var foodTotal = food_prices.quantity * food_prices.price;
                        foodListHtml += `
                        <div class="w-full flex items-center justify-between mb-2">
                            <div>
                                <p class="text-sm">${food_prices.food_name}</p>
                                <div class="flex items-center text-xs text-gray-500 gap-1">
                                    <p id="quantity">${food_prices.quantity} x</p>
                                    <p>&#8369;<span id="price">${food_prices.price}</span>.00</p>
                                </div>
                            </div>
                            <div>
                                <p class="text-sm">&#8369;<span id="food_total">${foodTotal}</span>.00</p>
                            </div>
                        </div>
                        `;
                    });

                    $('#food_list').html(foodListHtml);

                    // Update cash amount
                    $('#cash_amount').text(response.result[0].cash);

                    // Update change amount
                    $('#change_amount').text(response.result[0].change);

                    var date = new Date(response.result[0].created_at);

                    // Format the date components
                    var month = ('0' + (date.getMonth() + 1)).slice(-2); // Adding 1 because getMonth() returns 0-indexed month
                    var day = ('0' + date.getDate()).slice(-2);
                    var year = date.getFullYear();
                    var hours = ('0' + date.getHours()).slice(-2);
                    var minutes = ('0' + date.getMinutes()).slice(-2);
                    var seconds = ('0' + date.getSeconds()).slice(-2);

                    // Construct the formatted date string
                    var formattedDate = `${month}-${day}-${year} ${hours}:${minutes}:${seconds}`;

                    // Update sale time
                    $('#sale_time').text(formattedDate);

                    console.log(response)
                },
                error: function(xhr, status, error) {
                    console.error(xhr.responseText);
                }
            });
        }

    </script>
</body>
</html>