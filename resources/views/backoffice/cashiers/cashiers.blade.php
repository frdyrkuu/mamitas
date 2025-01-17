<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{ asset('jquery/jquery.js') }}"></script>
    <script src="https://kit.fontawesome.com/5bf9be4e76.js" crossorigin="anonymous"></script>
    @vite('resources/css/app.css')
    <title>Back Office</title>
</head>
<body class="w-full h-screen bg-[#fefefe]">
    <div id="add" class="w-1/4 hidden h-auto absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-slate-50 z-10 p-4 rounded-lg shadow-lg">
        <div class="w-full flex justify-end">
            <button onclick="closeCashierModal()" class="">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="14" height="14"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
            </button>
        </div>
        <div class="w-full">
            <p class="text-center mb-2 font-medium text-lg">Add cashier</p>
            <form action="{{route('office.add_cashier')}}" method="POST" class="text-sm">
                @csrf
                <label for="" class="">Cashier name</label>
                <input type="text" name="cashier_name" class="w-full outline-none p-2 border-b-2 mb-2 mt-1 focus:bg-main">
                <label for="" class="">Password</label>
                <input type="text" name="password" class="w-full outline-none p-2 border-b-2 mt-1 mb-4 focus:bg-main">
                <button class="bg-main py-2 px-10 rounded-sm text-white font-medium text-sm float-right">Save</button>
            </form>
        </div>
    </div>
    <div id="head" class="w-full flex items-center h-[7%] bg-[#db121c] px-10">
        <p class="text-lg text-white">Items List</p>
    </div>
    <div id="body" class="w-full h-[93%] flex z-0">
        <div class="w-[5%] pt-10 bg-[#fefefe]">
            <div class="flex w-2/3 mx-auto flex-col items-center justify-center pb-4 mb-3">
                <img src="{{asset('images/logo-transparent.png')}}" alt="">
            </div>
            <div class="w-full relative">
                <button onclick="openDashboard()" class="w-full flex items-center justify-center h-auto py-4">
                    <img src="{{asset('images/chart-new.png')}}" alt="" class="w-[30px] h-auto">
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
                <a href="{{route('office.cashiers')}}" class="w-full flex items-center justify-center h-auto py-4 bg-[#f5a7a4]">
                    <img src="{{asset('images/employee-red.png')}}" alt="" class="w-[30px] h-auto">
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
        <div id="main" class="w-[95%] flex justify-evenly gap-3 bg-[#f2f2f2] z-0 p-7">
            <div class="w-1/2 bg-slate-50 shadow-md p-6 rounded-xl">
                <div class="w-full pb-1 flex gap-4 items-center justify-start">
                    <button onclick="openAddCashier()" class="px-5 bg-main font-medium text-white text-sm rounded-lg py-2">Add Cashier</button>
                    {{-- <button class="font-medium bg-gray-600 uppercase py-2 text-white w-[100px] mb-2 rounded-sm text-xs">Export</button> --}}
                </div>
                <p class="text-center font-medium mb-4 text-lg">Cashier's List</p>
                @if (session('success'))
                    <div class="w-full block mx-auto">
                        <p class="text-green-500 font-semibold text-center">{{ session('success') }}</p>
                    </div>
                @endif
                <div class="w-full flex items-center text-sm py-4 px-5 text-gray-500 border-b border-[#dadada]">
                    <p class="w-[50%]">Cashier name</p>
                    <p class="w-[50%]">Created at</p>
                </div>
                <div class="w-full">
                    @foreach ($cashiers as $cashier)
                        <div class="w-full flex items-center text-sm py-4 px-5 text-gray-700 border-b border-[#dadada]">
                            <p class="w-[50%]">{{$cashier->name}}</p>
                            <p class="w-[35%]">
                                {{
                                    $date = $cashier->created_at->format('F j, Y - g:i A');
                                }}
                            </p>
                            <a href="/back-office/remove-cashier/{{$cashier->id}}" class="w-[15%] text-main">Remove</a>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="w-1/2 bg-slate-50 shadow-md p-6 rounded-xl">
                <p class="text-center font-medium mb-4 text-lg">Pending Accounts List</p>
                <div class="w-full flex items-center text-sm py-4 px-5 text-gray-500 border-b border-[#dadada]">
                    <p class="w-[45%]">Cashier name</p>
                    <p class="w-[35%]">Created at</p>
                    <p class="w-[20%]"></p>
                </div>
                @forelse ($pendings as $pending)
                    <div class="w-full flex items-center text-sm py-4 px-5 text-gray-700 border-b border-[#dadada]">
                        <p class="w-[45%]">{{ $pending->name }}</p>
                        <p class="w-[35%]">
                            {{
                                $date = $pending->created_at->format('F j, Y - g:i A');
                            }}
                        </p>
                        <div class="w-[20%] flex justify-between">
                            <a href="{{ route('office.accept', ['name' => $pending->name]) }}" class="text-green-500">Accept</a>
                            <a href="#" class="text-main">Reject</a>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">No pending accounts found.</p>
                @endforelse

            </div>
        </div>
    </div>
    <script>
        var main = document.getElementById('main')

        function openInventoryOptions(){
            var inventoryOptions = document.getElementById('inventory_options')
            inventoryOptions.classList.toggle('hidden')
            main.classList.toggle('blur-5px')
        }

        function openDashboard(){
            var inventoryOptions = document.getElementById('dash_options')
            inventoryOptions.classList.toggle('hidden')
            main.classList.toggle('blur-5px')
        }

        function openItems(){
            var inventoryOptions = document.getElementById('items_options')
            inventoryOptions.classList.toggle('hidden')
            main.classList.toggle('blur-5px')
        }

        function openAddCashier(){
            var addModal = document.getElementById('add')
            var head = document.getElementById('head')
            var body = document.getElementById('body')
            addModal.classList.remove('hidden')
            head.style.filter = 'blur(5px)'
            body.style.filter = 'blur(5px)'
        }

        function closeCashierModal(){
            var addModal = document.getElementById('add')
            var head = document.getElementById('head')
            var body = document.getElementById('body')
            addModal.classList.add('hidden')
            head.style.filter = 'blur(0)'
            body.style.filter = 'blur(0)'
        }
    </script>
</body>
</html>