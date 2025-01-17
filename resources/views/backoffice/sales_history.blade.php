<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/5bf9be4e76.js" crossorigin="anonymous"></script>
    @vite('resources/css/app.css')
    <title>Dashboard</title>
</head>
<body class="w-full h-screen bg-[#fefefe]">
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
    <div class="w-full flex items-center h-[7%] bg-[#db121c] px-10">
        <p class="text-lg font-medium text-white">Sales history</p>
    </div>
    {{-- main --}}
    <div id="main" class="w-full flex h-[92%] z-0">
        {{-- navigations --}}
        <div class="w-[5%] pt-10 bg-[#fefefe]">
            <div class="flex w-2/3 mx-auto flex-col items-center justify-center pb-4 mb-3">
                <img src="{{asset('images/logo-transparent.png')}}" alt="">
            </div>
            <div class="w-full relative">
                <button onclick="openDashboard()" class="w-full flex items-center justify-center h-auto py-4 bg-[#f5a7a4]">
                    <img src="{{asset('images/chart-red.png')}}" alt="" class="w-[30px] h-auto">
                </button>
                <div id="dash_options" class="hidden w-[200px] absolute left-20 top-0 z-10 bg-slate-50 text-sm">
                    <div class="w-full flex flex-col py-2">
                        <a href="{{route('office.dashboard')}}" class="hover:bg-[#e6e6e6] p-2">Sales summary</a>
                        <a href="{{route('office.sales_by_item')}}" class="hover:bg-[#e6e6e6] p-2">Sales by item</a>
                        <a href="{{route('office.sales_history')}}" class="hover:bg-[#e6e6e6] p-2">Sales history</a>
                    </div>
                </div>
            </div>
            <div class="w-full relative">
                <a href="{{route('office.items_list')}}" class="w-full flex items-center justify-center h-auto py-4">
                    <img src="{{asset('images/prod-new.png')}}" alt="" class="w-[30px] h-auto">
                </a>
            </div>
            <div class="w-full relative">
                <button onclick="openInventoryOptions()" class="w-full flex items-center justify-center h-auto py-4">
                    <img src="{{asset('images/inv-new.png')}}" alt="" class="w-[30px] h-auto">
                </button>
                <div id="inventory_options" class="hidden w-[200px] absolute left-20 top-0 z-10 bg-slate-50 p-3 text-sm">
                    <div class="w-full flex flex-col gap-3">
                        <a href="{{route('office.stocks_adjustment')}}">Stocks Adjustment</a>
                        <a href="{{route('office.inventory')}}">Inventory</a>
                    </div>
                </div>
            </div>
            {{-- <div class="w-full relative">
                <a href="{{route('qr_printing')}}" class="w-full flex items-center justify-center h-auto py-4">
                    <img src="{{asset('images/qr.png')}}" alt="" class="w-[30px] h-auto">
                </a>
            </div> --}}
            <div class="w-full relative">
                <a href="{{route('office.cashiers')}}" class="w-full flex items-center justify-center h-auto py-4">
                    <img src="{{asset('images/employee-new.png')}}" alt="" class="w-[30px] h-auto">
                </a>
            </div>
            <div class="w-full relative">
                <a href="{{route('office.supplier')}}" class="w-full flex items-center justify-center h-auto py-4">
                    <img src="{{asset('images/supplier-new.png')}}" alt="" class="w-[30px] h-auto">
                </a>
            </div>
            <div class="w-full relative">
                <a href="{{route('office.ordering')}}" class="w-full flex items-center justify-center h-auto py-4">
                    <img src="{{asset('images/order-new.png')}}" alt="" class="w-[30px] h-auto">
                </a>
            </div>
            <div class="w-full relative">
                <a href="{{route('office.logout')}}" class="w-full flex items-center justify-center h-auto py-4">
                    <img src="{{asset('images/logout-new.png')}}" alt="" class="w-[30px] h-auto">
                </a>
            </div>
        </div>
        {{-- POS --}}
        <div class="w-[95%] flex p-6 bg-[#ededed]">
            <div class="w-full block mx-auto shadow-2xl rounded-md p-4 bg-[#f4f4f4] overflow-hidden">
                <div class="mb-5">
                    <form action="{{route('office.purchased_date')}}" method="GET" class="flex gap-2 items-center">
                        <input type="date" id="date" name="date" class="px-2 py-1 border border-bd rounded-md">
                        <button class="px-10 py-1 bg-main text-white rounded-md">Filter</button>
                    </form>
                    <script>
                        // Get today's date
                        const today = new Date().toISOString().split('T')[0];
                        // Set the input value to today's date
                        document.getElementById('date').value = today;
                      </script>
                </div>
                <div class="w-full">
                    <div class="w-full flex p-2 bg-[#bebebe] uppercase font-medium">
                        <p class="w-[15%]">Ticket Number</p>
                        <p class="w-[20%]">Date</p>
                        <p class="w-[15%]">Cashier</p>
                        <p class="w-[20%]">Customer</p>
                        <p class="w-[10%]">Type</p>
                        <p class="w-[15%]">Total</p>
                        <div class="w-[5%]"></div>
                    </div>
                    @forelse ($history as $sale)
                        <div class="w-full flex border-b border-[#bebebe] p-2">
                            <p class="w-[15%]">1-{{ $sale->ticket }}</p>
                            <p class="w-[20%]">{{ $sale->created_at->format('F j, Y H:i:s') }}</p>
                            <p class="w-[15%]">{{ $sale->cashier }}</p>
                            <p class="w-[20%]">{{ $sale->customer }}</p>
                            <p class="w-[10%]">{{ $sale->type }}</p>
                            <p class="w-[15%]">&#8369; {{ $sale->total }}</p>
                            <div class="w-[5%]">
                                <button onclick="view({{ $sale->ticket }})" class="w-full py-1 bg-main rounded-md block mx-auto text-white text-sm">
                                    View
                                </button>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-gray-500 py-4">No purchases made</div>
                    @endforelse
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
            var url = "{{ route('office.history_ticket', ['ticket' => ':ticket']) }}";
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

        function openInventoryOptions(){
            var inventoryOptions = document.getElementById('inventory_options')
            inventoryOptions.classList.toggle('hidden')
        }

        function openDashboard(){
            var inventoryOptions = document.getElementById('dash_options')
            inventoryOptions.classList.toggle('hidden')
        }

        function openItems(){
            var inventoryOptions = document.getElementById('items_options')
            inventoryOptions.classList.toggle('hidden')
        }

    </script>
</body>
</html>