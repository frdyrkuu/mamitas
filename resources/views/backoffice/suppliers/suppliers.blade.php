<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://kit.fontawesome.com/5bf9be4e76.js" crossorigin="anonymous"></script>
    @vite('resources/css/app.css')
    <title>Back Office</title>
</head>
<body class="w-full h-screen bg-[#fefefe]">
    <div id="coverup" class="hidden w-full bg-main h-screen absolute z-50 opacity-30"></div>
    <form id="filterForm">
        <div id="filterModal" class="hidden py-1 w-1/3 bg-[#f0f0f0] shadow-3xl absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 rounded-2xl">
            <div class="flex py-3 px-5 justify-between items-center">
                <p class="font-medium">Filter suppliers</p>
                <button onclick="closeFilter(event)">
                    <img src="{{asset('images/close.png')}}" alt="" class="w-3/5 block mx-auto">
                </button>
            </div>
            <div class="w-full border-y-2 border-[#c7c3c3] py-3 px-5">
                <p class="font-medium mb-3">Where</p>
                <div class="w-full flex gap-4 mb-5">
                    <div class="w-full flex flex-col gap-1">
                        <label for="">Address</label>
                        <input name="address" id="address" class="w-full py-2 px-3 rounded-xl outline-none">
                    </div>
                </div>
            </div>
            <div class="w-full flex justify-end py-3 px-4">
                <button type="button" id="applyFilterButton" class="px-8 py-2 bg-main text-white text-sm rounded-xl">Apply</button>
            </div>
        </div>
    </form>
    <div id="add" class="w-1/3 hidden h-auto absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-slate-50 z-10 p-4 rounded-xl shadow-lg">
        <div class="w-full flex justify-end">
            <button onclick="closeCashierModal()" class="">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512" width="14" height="14"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M342.6 150.6c12.5-12.5 12.5-32.8 0-45.3s-32.8-12.5-45.3 0L192 210.7 86.6 105.4c-12.5-12.5-32.8-12.5-45.3 0s-12.5 32.8 0 45.3L146.7 256 41.4 361.4c-12.5 12.5-12.5 32.8 0 45.3s32.8 12.5 45.3 0L192 301.3 297.4 406.6c12.5 12.5 32.8 12.5 45.3 0s12.5-32.8 0-45.3L237.3 256 342.6 150.6z"/></svg>
            </button>
        </div>
        <div class="w-full">
            <p class="text-center mb-2 font-medium text-lg">Add Supplier</p>
            <form action="{{route('office.add_supplier')}}" method="POST" class="text-sm">
                @csrf
                <div class="mb-4">
                    <label for="" class="">Supplier's name</label>
                    <input type="text" name="supplier_name" class="w-full outline-none p-2 border-b-2 border-[#565857] mb-2 mt-1 focus:border-main">
                </div>
                <div class="flex gap-4 items-center mb-4">
                    <div class="w-1/2">
                        <label for="" class="">Contact person</label>
                        <input type="text" name="contact_person" class="w-full outline-none p-2 border-b-2 border-[#565857] mb-2 mt-1 focus:border-main">
                    </div>
                    <div class="w-1/2">
                        <label for="" class="">Contact number</label>
                        <input type="text" name="contact_number" class="w-full outline-none p-2 border-b-2 border-[#565857] mb-2 mt-1 focus:border-main">
                    </div>
                </div>
                <div class="mb-2">
                    <label for="" class="">Supplier's address</label>
                    <input type="text" name="address" class="w-full outline-none p-2 border-b-2 border-[#565857] mb-2 mt-1 focus:border-main">
                </div>
                <button class="bg-main py-2 px-10 rounded-lg text-white font-medium text-sm float-right">Save</button>
            </form>
        </div>
    </div>
    <div id="head" class="w-full flex items-center h-[7%] bg-[#db121c] px-10">
        <p class="text-lg text-white">Suppliers List</p>
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
                <a href="{{route('office.cashiers')}}" class="w-full flex items-center justify-center h-auto py-4">
                    <img src="{{asset('images/employee-new.png')}}" alt="" class="w-[30px] h-auto">
                </a>
            </div>
            <div class="w-full relative">
                <a href="{{route('office.supplier')}}" class="w-full flex items-center justify-center h-auto py-4 bg-[#f5a7a4]">
                    <img src="{{asset('images/supplier-red.png')}}" alt="" class="w-[30px] h-auto">
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
        <div id="main" class="w-[95%] bg-[#f2f2f2] z-0 p-7">
            <div class="w-full bg-slate-50 shadow-md p-6 rounded-xl">
                <div class="w-full pb-1 flex gap-4 items-center justify-start">
                    <input id="item_search" class="w-1/4 border-2 rounded-lg outline-none px-6 py-2" type="search" name="key" placeholder="Search for supplier name">
                    <button onclick="openFilter()" class="px-10 py-3 rounded-lg text-center border border-main text-main font-medium uppercase text-xs">Filter</button>
                    <button onclick="openAddCashier()" class="px-5 bg-main font-medium uppercase text-xs py-3 text-white rounded-lg">Add Supplier</button>
                    {{-- <button class="font-medium bg-gray-600 uppercase py-2 text-white w-[100px] mb-2 rounded-sm text-xs">Export</button> --}}
                </div>
                <div class="w-full flex items-center text-sm py-4 px-5 text-gray-500 border-b border-[#dadada]">
                    <p class="w-[20%]">Supplier's name</p>
                    <p class="w-[20%]">Contact person</p>
                    <p class="w-[20%]">Contact number</p>
                    <p class="w-[20%]">Supplier's address</p>
                    <p class="w-[20%]">Created at</p>
                </div>
                <div id="supplierResults" class="w-full">
                    @foreach ($suppliers as $supplier)
                        <div class="w-full flex py-4 px-5 border-b">
                            <p class="w-1/5">{{ $supplier->name }}</p>
                            <p class="w-1/5">{{ $supplier->contact_person }}</p>
                            <p class="w-1/5">{{ $supplier->contact_number }}</p>
                            <p class="w-1/5">{{ $supplier->address }}</p>
                            <p class="w-1/5">{{ $supplier->created_at->format('F d, Y - g:i A') }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <script>
        var main = document.getElementById('main')

        $(document).ready(function(){
            $('#applyFilterButton').click(function() {
            var cover = document.getElementById('coverup')
            var modal = document.getElementById('filterModal')

            cover.classList.add('hidden')
            modal.classList.add('hidden')

                $.ajax({
                url: "{{ route('office.filter_address') }}",
                type: 'GET',
                data: $('#filterForm').serialize(),
                success: function(data) {
                    // Clear the previous results
                    $('#supplierResults').empty();

                    // Iterate over the returned suppliers and append the HTML structure
                    $.each(data, function(index, supplier) {
                        // Format the created_at date
                        var createdAt = new Date(supplier.created_at);
                        var options = { month: 'long', day: 'numeric', year: 'numeric' };
                        var formattedDate = createdAt.toLocaleDateString('en-US', options) + ' - ' +
                                        createdAt.toLocaleString('en-US', { hour: 'numeric', minute: 'numeric', hour12: true });

                        $('#supplierResults').append(
                            '<div class="w-full flex py-4 px-5 border-b">' +
                                '<p class="w-1/5">' + supplier.name + '</p>' +
                                '<p class="w-1/5">' + supplier.contact_person + '</p>' +
                                '<p class="w-1/5">' + supplier.contact_number + '</p>' +
                                '<p class="w-1/5">' + supplier.address + '</p>' +
                                '<p class="w-1/5">' + formattedDate + '</p>' +
                            '</div>'
                        );
                    });
                },
                error: function() {
                    alert('Error retrieving filtered items');
                }
            });
            });
        })


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

        function openFilter(){
            var cover = document.getElementById('coverup')
            var modal = document.getElementById('filterModal')

            cover.classList.remove('hidden')
            modal.classList.remove('hidden')
        }

        function closeFilter(event){
            event.preventDefault();
            var cover = document.getElementById('coverup')
            var modal = document.getElementById('filterModal')

            cover.classList.add('hidden')
            modal.classList.add('hidden')
        }
    </script>
</body>
</html>