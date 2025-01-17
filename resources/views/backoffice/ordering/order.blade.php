<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{ asset('jquery/jquery.js') }}"></script>
    @vite('resources/css/app.css')
    <title>Back Office</title>
</head>
<body class="w-full h-screen bg-[#fefefe] relative">
    <div id="overlay" class="hidden absolute bg-[#474646] w-full h-screen top-0 left-0 z-10 opacity-90"></div>
    <div id="displayDiv" class="hidden w-1/2 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 bg-white shadow-lg rounded-xl">
        <div class="w-full flex items-center bg-main rounded-tl-xl rounded-tr-xl text-white py-3 px-2">
            <p class="w-[50%] font-bold">Item name</p>
            <p class="w-[25%] font-bold">Quantity</p>
            <p class="w-[25%] font-bold">Supplier</p>
        </div>
        <div id="detailsContainer" class="w-full bg-white">
            <!-- Dynamically loaded details will appear here -->
        </div>
        <!-- Optional Close button to close the modal -->
        <div class="text-right p-3">
            <button id="closeModal" class="text-main">Close</button>
        </div>
    </div>
    <div id="head" class="w-full flex items-center h-[7%] bg-[#db121c] px-10">
        <p class="text-lg text-white">Orders</p>
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
                <a href="{{route('office.supplier')}}" class="w-full flex items-center justify-center h-auto py-4">
                    <img src="{{asset('images/supplier-new.png')}}" alt="" class="w-[30px] h-auto">
                </a>
            </div>
            <div class="w-full relative">
                <a href="{{route('office.ordering')}}" class="w-full flex items-center justify-center h-auto py-4 bg-[#f5a7a4]">
                    <img src="{{asset('images/order-red.png')}}" alt="" class="w-[30px] h-auto">
                </a>
            </div>
            <div class="w-full relative">
                <a href="{{route('office.logout')}}" class="w-full flex items-center justify-center h-auto py-4">
                    <img src="{{asset('images/logout-new.png')}}" alt="" class="w-[30px] h-auto">
                </a>
            </div>
        </div>
        <div id="main" class="w-[95%] bg-[#f2f2f2] p-7">
            <div class="w-full bg-white rounded-xl py-3 px-5">
                <div class="w-full flex justify-between mb-10">
                    <p class="py-1 font-medium text-[#3e413f]">List of orders</p>
                    <a href="{{route('office.new_order')}}" class=" text-main">New order</a>
                </div>
                <div class="flex text-md text-[#8e8f8e] border-b pb-2">
                    <p class="w-1/6">Batch Number</p>
                    <p class="w-1/6">Number of products</p>
                    <p class="w-1/6">Total of items ordered</p>
                    <p class="w-1/6">Order Date</p>
                    <p class="w-1/6">Delivery Date</p>
                    <p class="w-1/6 text-center">Actions</p>
                </div>
                @foreach ($summaries as $summary)
                <div class="flex text-md border-b py-2 text-[#3e413f]">
                    <p id="batchNumber" class="w-1/6 py-4">{{ $summary['batch_number'] }}</p>
                    <p class="w-1/6 py-4">{{ $summary['total_rows'] }}</p>
                    <p class="w-1/6 py-4">{{ $summary['total_items'] }}</p>
                    <p class="w-1/6 py-4">{{ $summary['created_at'] }}</p>
                    @php
                        if($summary['created_at'] != $summary['updated_at']){
                            echo'<p class="w-1/6 py-4">'. $summary['updated_at'] .'</p>';
                        } else {
                            echo'<p class="w-1/6 py-4">Not yet delivered</p>';
                        }
                    @endphp
                    <button id="seeDetails" class="w-1/6 text-center text-main py-4">See details</button>
                </div>
                @endforeach
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function(){
            // Listen for click events on any #seeDetails button
            $(document).on('click', '#seeDetails', function(e) {
                e.preventDefault();
                
                let currentRow = $(this).closest('.flex');
                // Find the closest row and retrieve the necessary data
                let batchNumber = $(this).closest('.flex').find('p:first').text()

                // Perform AJAX request to get the order details
                $.ajax({
                    url: '/back-office/fetch-order-details',  // Laravel route to handle the request
                    method: 'GET',
                    data: { batch_number: batchNumber },
                    success: function(response) {
                        console.log(response)
                        let orderDetails = response.orderDetails;

                    if (orderDetails && orderDetails.length > 0) {
                        // Clear previous details
                        $('#detailsContainer').empty();

                        // Loop through the array of order details and append each item
                        orderDetails.forEach(function(item) {
                            $('#detailsContainer').append(`
                                <div id="details" class="w-full flex items-center bg-[#fefefe] py-3 px-2 border-b last:rounded-bl-xl last:rounded-br-xl">
                                    <p class="w-[50%]">${item.item}</p>
                                    <p class="w-[25%]">${item.quantity}</p>
                                    <p class="w-[25%]">${item.supplier}</p>
                                </div>
                            `);
                        });

                        // Show the overlay and modal
                        $('#overlay, #displayDiv').removeClass('hidden').show();
                    } else {
                        console.error('No order details found');
                    }
                    },
                    error: function(xhr) {
                        console.log('Error:', xhr);
                    }
                });
            });

            $('#closeModal').on('click', function(){
                $('#overlay, #displayDiv').addClass('hidden')
            })
        });


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