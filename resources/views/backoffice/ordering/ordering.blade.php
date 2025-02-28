<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{ asset('jquery/jquery.js') }}"></script>
    @vite('resources/css/app.css')
    <title>Back Office</title>
</head>

<body class="w-full h-screen bg-[#fefefe]">
    <div id="head" class="w-full flex items-center h-[7%] bg-[#db121c] px-10">
        <p class="text-lg text-white">Orders</p>
    </div>
    <div id="body" class="w-full h-[93%] flex z-0">
        <div class="w-[5%] pt-10 bg-[#fefefe]">
            <div class="flex w-2/3 mx-auto flex-col items-center justify-center pb-4 mb-3">
                <img src="{{ asset('images/logo-transparent.png') }}" alt="">
            </div>
            <div class="w-full relative">
                <button onclick="openDashboard()" class="w-full flex items-center justify-center h-auto py-4">
                    <img src="{{ asset('images/chart-new.png') }}" alt="" class="w-[30px] h-auto">
                </button>
                <div id="dash_options" class="hidden w-[200px] absolute left-20 top-0 z-10 bg-slate-50 text-sm">
                    <div class="w-full flex flex-col py-2">
                        <a href="{{ route('office.dashboard') }}" class="hover:bg-[#e6e6e6] p-2">Sales summary</a>
                        <a href="{{ route('office.sales_by_item') }}" class="hover:bg-[#e6e6e6] p-2">Sales by item</a>
                        <a href="{{ route('office.sales_history') }}" class="hover:bg-[#e6e6e6] p-2">Sales history</a>
                    </div>
                </div>
            </div>
            <div class="w-full relative">
                <a href="{{ route('office.items_list') }}" class="w-full flex items-center justify-center h-auto py-4">
                    <img src="{{ asset('images/prod-new.png') }}" alt="" class="w-[30px] h-auto">
                </a>
            </div>
            <div class="w-full relative">
                <button onclick="openInventoryOptions()" class="w-full flex items-center justify-center h-auto py-4">
                    <img src="{{ asset('images/inv-new.png') }}" alt="" class="w-[30px] h-auto">
                </button>
                <div id="inventory_options"
                    class="hidden w-[200px] absolute left-20 top-0 z-10 bg-slate-50 p-3 text-sm">
                    <div class="w-full flex flex-col gap-3">
                        <a href="{{ route('office.stocks_adjustment') }}">Stocks Adjustment</a>
                        <a href="{{ route('office.inventory') }}">Inventory</a>
                    </div>
                </div>
            </div>
            {{-- <div class="w-full relative">
                <a href="{{route('qr_printing')}}" class="w-full flex items-center justify-center h-auto py-4">
                    <img src="{{asset('images/qr.png')}}" alt="" class="w-[30px] h-auto">
                </a>
            </div> --}}
            <div class="w-full relative">
                <a href="{{ route('office.cashiers') }}" class="w-full flex items-center justify-center h-auto py-4">
                    <img src="{{ asset('images/employee-new.png') }}" alt="" class="w-[30px] h-auto">
                </a>
            </div>
            <div class="w-full relative">
                <a href="{{ route('office.supplier') }}" class="w-full flex items-center justify-center h-auto py-4">
                    <img src="{{ asset('images/supplier-new.png') }}" alt="" class="w-[30px] h-auto">
                </a>
            </div>
            <div class="w-full relative">
                <a href="{{ route('office.ordering') }}"
                    class="w-full flex items-center justify-center h-auto py-4 bg-[#f5a7a4]">
                    <img src="{{ asset('images/order-red.png') }}" alt="" class="w-[30px] h-auto">
                </a>
            </div>
            <div class="w-full relative">
                <form id="logoutForm" action="{{ route('office.logout') }}" method="POST">
                    @csrf
                    <a href="#" id="logoutLink" class="w-full flex items-center justify-center h-auto py-4">
                        <img src="{{ asset('images/logout-new.png') }}" alt="Logout" class="w-[30px] h-auto">
                    </a>
                </form>
            </div>

            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <script>
                document.getElementById('logoutLink').addEventListener('click', function(e) {
                    e.preventDefault(); // Prevent the default link action

                    Swal.fire({
                        title: "Are you sure?",
                        text: "You will be logged out of the system.",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#3085d6",
                        cancelButtonColor: "#d33",
                        confirmButtonText: "Yes, log me out!"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Submit the logout form
                            document.getElementById('logoutForm').submit();
                        }
                    });
                });
            </script>
        </div>
        <div id="main" class="w-[95%] bg-[#f2f2f2] grid grid-cols-2 gap-6 grid-rows-2 p-7">
            <div class="w-full bg-white rounded-xl py-3 px-5">
                <p class="py-1 font-medium border-b-2 border-[#565857] text-[#565857]">Item to order</p>
                <div class="pt-2">
                    <input id="item_search" type="search" name="item_name" placeholder="Search for item name"
                        autocomplete="off"
                        class="w-full px-5 py-2 rounded-lg outline-none border border-[#565857] focus:border-main">
                    <p>Result:</p>
                    <div id="item_result" class="w-full h-[90px] overflow-y-auto pb-2 border-b">

                    </div>
                    <div class="w-full flex py-2">
                        <div class="w-[70%] flex flex-col gap-2">
                            <p class="w-full" id="product_name">Name</p>
                            <p class="w-full font-medium" id="name_input"></p>
                        </div>
                        <div class="w-[30%] flex flex-col gap-2">
                            <p class="w-full">Quantity</p>
                            <input id="quantity" type="number" name="quantity"
                                class="w-full px-5 py-2 border-b border-[#565857] outline-none focus:border-main">
                        </div>
                    </div>
                </div>
            </div>
            <div class="w-full col-start-2 row-span-2 bg-white rounded-xl py-3 px-5">
                <div class="flex justify-between border-b-2 border-[#565857]">
                    <p class="py-1 font-medium text-[#565857]">Batch Order # {{ $newBn }}</p>
                    <form action="{{ route('office.place_order') }}" method="POST">
                        @csrf
                        <div id="form_div">

                        </div>
                        <input type="hidden" name="batch_number" value="{{ $newBn }}">
                        <button class="text-main">
                            Complete this order
                        </button>
                    </form>
                </div>
                <div class="w-full pt-2" id="res_div">

                </div>
            </div>
            <div class="w-full bg-white rounded-xl py-3 px-5">
                <p class="py-1 font-medium border-b-2 border-[#565857] text-[#565857]">Supplier details</p>
                <div class="pt-2 mb-4">
                    <input id="supplier_search" autocomplete="off" type="search" name="supplier_name"
                        placeholder="Search for supplier name"
                        class="w-full px-5 py-2 rounded-lg outline-none border border-[#565857] focus:border-main">
                    <p>Result:</p>
                    <div id="supplier_result" class="w-full h-[70px] pb-2 border-b">

                    </div>
                    <div class="w-full flex gap-1 pt-3">
                        <p id="selected supplier">Selected supplier:</p>
                        <p class="font-medium" id="supplier_input">Supplier</p>
                    </div>
                </div>
                {{-- <form action="" method="POST"> --}}
                {{-- @csrf --}}
                <input id="item_name_submit" type="hidden" name="item_name" value="">
                <input id="supplier_name_submit" type="hidden" name="supplier_name" value="">
                <input id="item_quantity_submit" type="hidden" name="item_quantity" value="">
                {{-- <input id="batch_number" type="hidden" name="batch_number" value="{{$newBn}}"> --}}
                <button id="add_to_order" type="submit"
                    class="w-full py-2 rounded-lg border-2 border-main text-main">Confirm Order</button>
                {{-- </form> --}}
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var food_name = ''
            var supplier_name = ''
            var itemQuantity = 0
            $('#quantity').on('keyup', function() {
                itemQuantity = $(this).val()
                $('#item_quantity_submit').val(itemQuantity)
            })

            $('#item_search').on('keyup', function() {
                var item_key = $(this).val()
                product_name = $(this).val()
                // console.log(key)
                var item_url = "{{ route('office.item_search', ['key' => ':key']) }}"
                item_url = item_url.replace(':key', item_key)

                $.ajax({
                    url: item_url,
                    method: 'GET',
                    success: function(response) {
                        var itemDiv = $('#item_result');
                        itemDiv.empty(); // Clear the current contents

                        response.items.forEach(function(item) {
                            var menuButton = `
                                <button class="w-full py-2 border-b-2 hover-[#565857] item-btn" data-food-name="${item.item}">
                                    <p>${item.item}</p>
                                </button>
                            `;
                            itemDiv.append(menuButton);
                        });

                        // Use event delegation to handle click events on dynamically added buttons
                        $('#item_result').on('click', '.item-btn', function() {
                            let foodName = $(this).data('food-name');

                            if (foodName) {
                                food_name = foodName
                                $('#name_input').text(foodName);
                                $('#item_name_submit').val(foodName)
                            } else {
                                console.log('Invalid item data:', foodName);
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr, status, error);
                    }
                });
            })

            $('#supplier_search').on('keyup', function() {
                var supplier_key = $(this).val()

                // console.log(key)
                var supplier_url = "{{ route('office.supplier_search', ['key' => ':key']) }}"
                supplier_url = supplier_url.replace(':key', supplier_key)
                console.log(supplier_url)

                $.ajax({
                    url: supplier_url,
                    method: 'GET',
                    success: function(response) {
                        var supplierDiv = $('#supplier_result');
                        supplierDiv.empty(); // Clear the current contents

                        response.items.forEach(function(item) {
                            var menuButton = `
                                <button class="w-full py-2 border-b-2 hover-[#565857] supplier-btn" data-supplier-name="${item.name}">
                                    <p>${item.name}</p>
                                </button>
                            `;
                            supplierDiv.append(menuButton);
                        });

                        // Use event delegation to handle click events on dynamically added buttons
                        $('#supplier_result').on('click', '.supplier-btn', function() {
                            let supplierName = $(this).data('supplier-name');

                            if (supplierName) {
                                supplier_name = supplierName
                                $('#supplier_input').text(supplierName);
                                $('#supplier_name_submit').val(supplierName)
                            } else {
                                console.log('Invalid item data:', supplierName);
                            }
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr, status, error);
                    }
                });
            })
            $('#add_to_order').on('click', function() {
                console.log('Product Name:', food_name);
                console.log('Supplier:', supplier_name);
                console.log('Quantity:', itemQuantity);
                // Add your logic here to handle the order

                var results = $('#res_div')
                var formDiv = $('#form_div')

                results.append(`
                    <div class="w-full flex items-center text-sm py-1 border-b">
                        <p class="w-2/5" id="item_res">${food_name}</p>
                        <p class="w-2/5" id="item_supplier">${supplier_name}</p>
                        <p class="w-1/5" id="item_quantity">${itemQuantity}</p>
                    </div> 
                `)

                formDiv.append(`
                    <div>
                        <input type="hidden" name="food_name[]" value="${food_name}">
                        <input type="hidden" name="suppliername[]" value="${supplier_name}">
                        <input type="hidden" name="quantity[]" value="${itemQuantity}">
                    </div> 
                `)
            });
        })



        var main = document.getElementById('main')

        function openInventoryOptions() {
            var inventoryOptions = document.getElementById('inventory_options')
            inventoryOptions.classList.toggle('hidden')
            main.classList.toggle('blur-5px')
        }

        function openDashboard() {
            var inventoryOptions = document.getElementById('dash_options')
            inventoryOptions.classList.toggle('hidden')
            main.classList.toggle('blur-5px')
        }

        function openItems() {
            var inventoryOptions = document.getElementById('items_options')
            inventoryOptions.classList.toggle('hidden')
            main.classList.toggle('blur-5px')
        }

        function openAddCashier() {
            var addModal = document.getElementById('add')
            var head = document.getElementById('head')
            var body = document.getElementById('body')
            addModal.classList.remove('hidden')
            head.style.filter = 'blur(5px)'
            body.style.filter = 'blur(5px)'
        }

        function closeCashierModal() {
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
