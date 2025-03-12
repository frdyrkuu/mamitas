<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="{{ asset('jquery/jquery.js') }}"></script>
    @vite('resources/css/app.css')
    <title>Dashboard</title>
</head>

<body class="w-full h-screen relative">
    <div id="coverup" class="hidden w-full bg-main h-screen absolute z-40 opacity-30"></div>
    <div id="moneyTransactions"
        class="hidden w-1/2 p-4 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white rounded-xl z-50">
        <div class="w-full flex gap-4">
            <div class="w-full px-5 py-3">
                <p class="pb-2 border-b border-[#565857] font-medium text-[#565857]">Pay ins</p>
                <div class="w-full pt-3">
                    <form action="{{ route('cash_management') }}" method="POST">
                        @csrf
                        <input id="pay" type="text" name="amount" placeholder="Enter amount"
                            class="w-full outline-none rounded-lg px-4 py-1 border border-[#565857] mb-4">
                        <input type="hidden" name="reason" value="paid_in">
                        <button type="submit"
                            class="w-full border border-main rounded-lg py-1 text-red hover:bg-main hover:text-white ease-in-out duration-100">Proceed</button>
                    </form>
                </div>
            </div>
            <div class="w-full px-5 py-3">
                <p class="pb-2 border-b border-[#565857] font-medium text-[#565857]">Petty cash</p>
                <div class="w-full pt-3">
                    <form action="{{ route('cash_management') }}" method="POST">
                        @csrf
                        <input id="pay1" type="text" name="amount" placeholder="Enter amount"
                            class="w-full outline-none rounded-lg px-4 py-1 border border-[#565857] mb-4">
                        <input type="hidden" name="reason" value="paid_out">
                        <button type="submit"
                            class="w-full border border-main rounded-lg py-1 text-red hover:bg-main hover:text-white ease-in-out duration-100">Proceed</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div id="quantity-div"
        class="w-1/6 p-4 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-red-500 hidden">
        <p>Input quantity</p>
        <input type="number" id="quantity-input" class="w-full py-2 text-center rounded-sm outline-none border"
            value="1">
        <button id="submit-quantity" class="mt-2 px-4 py-2 bg-blue-500 text-white rounded-sm">Submit</button>
    </div>
    <div class="w-1/5 mx-auto hidden absolute bottom-0 left-0 z-50" id="scanner">
        <video class="mx-auto" id="preview" width="100%"></video><br>
    </div>
    {{-- main --}}
    <div class="w-full flex h-full">
        {{-- navigations --}}
        <div class="w-[6%] py-6 bg-white relative">
            <div class="flex w-2/3 mx-auto flex-col items-center justify-center py-4 mb-3">
                @if (isset($cms) && $cms->company_logo)
                    <img src="{{ asset($cms->company_logo) }}" alt="Company Logo">
                @else
                    <img src="{{ asset('images/cms/1737455694.jpg') }}" alt="Default Logo">
                @endif
            </div>
            <a href="{{ route('dashboard') }}"
                class="flex w-2/3 mx-auto flex-col items-center justify-center py-4 rounded-xl bg-[#f5a7a4]">
                <img src="{{ asset('images/products-red.png') }}" alt="Home Icon" class="w-1/3">
                <p class="text-xs text-[#e5231a]">Home</p>
            </a>
            <a href="{{ route('cashier') }}" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{ asset('images/cashier-new.png') }}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">Cashier</p>
            </a>
            <a href="{{ route('history') }}" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{ asset('images/history-new.png') }}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">History</p>
            </a>
            <a href="{{ route('inventory') }}" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{ asset('images/inv-new.png') }}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">Inventory</p>
            </a>
            <a href="{{ route('orders') }}" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{ asset('images/order-new.png') }}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">Orders</p>
            </a>
            <a href="{{ route('office.login') }}" target="__blank"
                class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{ asset('images/backoffice-new.png') }}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">Office</p>
            </a>
            <button onclick="toggleAlerts()"
                class="flex w-2/3 mx-auto flex-col items-center justify-center py-4 bg-[#dadada] rounded-xl absolute bottom-2 left-4">
                <img src="{{ asset('images/notifications.png') }}" alt="">
                <div
                    class="w-[30px] h-[30px] flex items-center justify-center bg-[#f5a7a4] rounded-full absolute -top-2 -right-2">
                    <p class="font-semibold text-main">
                        {{ $alerts->count() }}
                    </p>
                </div>
            </button>
            <div id="alertsDiv"
                class="w-[300px] h-[300px] overflow-y-auto hidden rounded-xl absolute bottom-7 left-24 text-xs bg-white border-2 border-main">
                @foreach ($alerts as $alert)
                    <a href="/back-office/stocks_adjustments/?opendialog={{ $alert->item }}" target="_blank">

                        @php
                            $quantity = $alert->quantity;
                        @endphp
                        <div class="w-full flex flex-col px-2 py-1 border-b">
                            <p>
                                @php
                                    if ($quantity >= 1) {
                                        echo '<p class="font-medium">Critically Low Amount</p>';
                                    } else {
                                        echo '<p class="font-medium">No stocks</p>';
                                    }
                                @endphp
                            </p>
                            <p>{{ $alert->item }} is only <span class="font-medium">{{ $alert->quantity }}</span>
                                remaining in stock.</p>
                        </div>
                    </a>
                @endforeach

            </div>
        </div>
        {{-- POS --}}
        <div class="w-[94%] flex bg-[#e4e4e4]">
            {{-- selection --}}
            <div class="w-3/4 p-6 bg-[#e4e4e4]">
                <div class="w-full flex justify-between">
                    <div class="relative w-1/4">
                        <input id="search_item" type="text" name="search" placeholder="Search item"
                            class="w-full rounded-full py-1 px-4 outline-none">
                        <img src="{{ asset('images/search.png') }}" alt=""
                            class="w-[8%] absolute right-2 top-1">
                    </div>
                    <input id="barcode" type="search" name="barcode" placeholder="Barcode"
                        class="py-1 px-4 outline-none w-[20%] mb-6 rounded-xl">
                </div>
                <div id="foods" class="w-full grid grid-cols-5 grid-rows-5 gap-4 h-[90%] overflow-y-auto">
                    @foreach ($menus as $menu)
                        <button
                            class="btn-menu menu-button flex flex-col rounded-md shadow-lg bg-[#fefefe] p-4 items-center justify-center text-sm hover:bg-green-300 hover:text-black"
                            data-food-name="{{ $menu->item }}" data-promo="{{ $menu->item_promo }}"
                            data-price="{{ $menu->retail }}" @if ($menu->quantity == 0) disabled @endif>
                            <p class="">{{ $menu->item }} {{ $menu->size }}</p>
                            @if ($menu->item_promo)
                                <p class="text-blue-500">+ {{ $menu->item_promo }}</p>
                            @endif
                            <p class="font-medium mb-2">&#8369; {{ $menu->retail }}.00</p>
                            <p class="text-xs menu-qty text-green-600 font-semibold">{{ $menu->quantity }} in stock
                            </p>
                        </button>
                    @endforeach
                    <style>
                        .btn-menu:disabled {
                            background-color: rgb(245, 147, 147);
                            /* Grey background */
                            cursor: not-allowed;
                            /* Show a disabled cursor */
                            pointer-events: none;
                            /* Prevent click interaction */

                            .menu-qty {
                                color: red;
                            }
                        }
                    </style>
                </div>
            </div>
            {{-- ticket --}}
            <div id="ticket" class="w-1/4 my-auto px-4">
                <form action="{{ route('ticket_details') }}" class="w-full h-[700px] p-4 bg-white border rounded-xl"
                    method="get">
                    @csrf
                    <div class="w-full flex justify-between py-2 border-b border-bd items-center">
                        <div class="w-1/2">
                            <input id="customer" type="text" name="customer" placeholder="Customer Name"
                                class="w-full border border-[#565857] rounded-xl outline-none py-2 px-4">
                        </div>
                        <div class="w-1/4 items-center justify-center flex flex-col">
                            <p class="text-xs text-[#565857]">Sale #:</p>
                            <p class="font-medium">{{ $ticket }}</p>
                        </div>
                        <div class="w-1/4 flex justify-end items-center">
                            <button type="button" id="clear"
                                class="w-[25px] h-[25px] rounded-full border border-black flex items-center justify-center">
                                <img src="{{ asset('images/delete.png') }}" alt="Delete Button" class="w-3/4">
                            </button>
                        </div>
                    </div>
                    <div id="orders" class="w-full h-[400px] overflow-y-auto border-b border-bd">
                    </div>
                    <div class="w-full p-2">
                        <div class="w-full">
                            <div class="w-full flex justify-between mb-4">
                                <p>Sub-total: </p>
                                <p>&#8369; <span id="total">0.00</span></p>
                            </div>
                            <div class="w-full flex justify-between mb-6">
                                <p class="text-lg font-medium">Payable Amount: </p>
                                <p class="text-lg font-medium">&#8369; <span id="payable">0.00</span></p>
                            </div>
                        </div>
                        <div class="w-full flex flex-col items-center justify-between gap-2 text-sm text-white">
                            <button type="submit" id="proceed" name="action" value="proceed"
                                class="w-full rounded-xl py-4 bg-[#565857]">
                                Order's Empty
                            </button>
                            <button type="submit" name="action" value="gcash"
                                class="w-full py-4 rounded-xl bg-blue-500 text-white font-medium">Cash In / Cash
                                Out</button>
                        </div>
                    </div>
                    <input type="hidden" name="ticket" value="{{ $ticket }}">
                </form>
            </div>
        </div>
    </div>

    <script>
        const itemsData = {
            @foreach ($menus as $menu)
                "{{ $menu->qr }}": {
                    item: "{{ $menu->item }}",
                    price: {{ $menu->retail }}
                }
                {{ !$loop->last ? ',' : '' }}
            @endforeach
        };

        let orders = [];
        let currentQuantity = 1;
        let coverup = document.getElementById('coverup')
        let moneyTrans = document.getElementById('moneyTransactions')

        function toggleAlerts() {
            let alertsDiv = document.getElementById('alertsDiv')
            alertsDiv.classList.toggle('hidden')
        }

        function updateProceedButtonState() {
            if (orders.length === 0) {
                $('#proceed').prop('disabled', true);
                $('#proceed').addClass('bg-[#565857]')
                $('#proceed').removeClass('bg-main')
            } else {
                $('#proceed').prop('disabled', false);
                $('#proceed').removeClass('bg-[#565857]')
                $('#proceed').addClass('bg-main')
            }
        }

        $(document).ready(function() {
            updateProceedButtonState();
            const customerName = $('#customer');
            const barcodeInput = $('#barcode');
            const quantityInput = $('#quantity-input');
            const quantityDiv = $('#quantity-div');
            const submitQuantityButton = $('#submit-quantity');
            const backgroundElement = document.getElementById("background");


            $("#search_item").on('keyup', function() {
                var key = $(this).val()
                var url = "{{ route('livesearch', ['key' => ':key']) }}"
                url = url.replace(':key', key)

                $.ajax({
                    url: url,
                    method: 'GET',
                    success: function(response) {
                        var foodsDiv = $('#foods');
                        foodsDiv.empty(); // Clear the current contents

                        response.menus.forEach(function(menu) {
                            var menuButton = `
                            <button class="menu-button flex flex-col rounded-md shadow-lg bg-[#fefefe] p-4 items-center justify-center text-sm hover:bg-[#f5a7a4] hover:text-black" data-food-name="${menu.item}" data-price="${menu.retail}">
                                <p class="">${menu.item}</p>
                                <p class="font-medium">&#8369; ${menu.retail}.00</p>
                            </button>
                            `;
                            foodsDiv.append(menuButton);
                        });
                    },
                    error: function(xhr, status, error) {
                        console.error(xhr, status, error);
                    }
                })
            })

            // Function to keep the input field focused
            function keepFocus() {
                setTimeout(() => {
                    barcodeInput.focus();
                }, 10);
            }

            // Initially set focus to the input field
            keepFocus();

            // Submit quantity button click handler
            submitQuantityButton.on('click', function() {
                let quantity = parseInt(quantityInput.val());
                if (!isNaN(quantity) && quantity > 0) {
                    currentQuantity = quantity;
                    quantityDiv.addClass('hidden');
                    // Call addToOrders with the specified quantity
                    addToOrders(itemName, itemPrice, quantity);
                    keepFocus();
                } else {
                    alert('Please enter a valid quantity');
                }
            });

            // Listen for the barcode input
            barcodeInput.on('keypress', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault();
                    let barcodeValue = barcodeInput.val().trim();

                    if (itemsData[barcodeValue]) {
                        let orderItem = itemsData[barcodeValue];
                        for (let i = 0; i < currentQuantity; i++) {
                            addToOrders(orderItem.item, orderItem.price);
                        }

                        updateOrdersDisplay();
                        currentQuantity = 1; // Reset the quantity to 1
                        quantityInput.val(1); // Reset the quantity input to 1
                    } else {
                        console.log('Item not found for barcode:', barcodeValue);
                    }

                    barcodeInput.val(''); // Clear the input field for the next scan
                    keepFocus(); // Ensure the input field stays focused
                }
            });

            // Toggle quantity input on specific key press (e.g., `)
        $(document).on('keydown', function(event) {
            if (event.key === '`') {
                    quantityDiv.toggleClass('hidden');
                    quantityInput.focus();
                }
            });

            $(document).on('keydown', function(event) {
                if (event.key === 'End') {
                    moneyTrans.classList.remove('hidden')
                    coverup.classList.remove('hidden')
                }
            });

            // Show scanner on F9 key press (if you have a scanner video element)
            $(document).on('keydown', function(event) {
                if (event.key === 'F9') {
                    $('#scanner').toggle('hidden');
                }
            });

            // Function to refocus barcode input when clicking outside
            // $(document).on('click', function(event) {
            //     if (!$(event.target).closest('#search').length) {
            //         keepFocus();
            //     }
            // });

            function addToOrders(itemName, itemPrice, quantity) { // Set default quantity to 1
                let found = false;

                // Ensure quantity is a positive integer
                quantity = parseInt(currentQuantity);
                if (isNaN(quantity) || quantity <= 0) {
                    quantity = 1;
                }

                for (let i = 0; i < orders.length; i++) {
                    if (orders[i].foodName === itemName) {
                        orders[i].quantity += quantity; // Increment by the specified quantity
                        orders[i].total += itemPrice * quantity; // Update total price
                        found = true;
                        break;
                    }
                }

                if (!found) {
                    orders.push({
                        foodName: itemName,
                        price: itemPrice,
                        quantity: quantity,
                        total: itemPrice * quantity
                    });
                    currentQuantity = 1;
                }
                updateProceedButtonState();
            }


            function removeFromOrders(itemName) {
                for (let i = 0; i < orders.length; i++) {
                    if (orders[i].foodName === itemName) {
                        if (orders[i].quantity > 1) {
                            orders[i].quantity--;
                            orders[i].total -= orders[i].price;
                        } else {
                            orders.splice(i, 1);
                        }
                        break;
                    }
                }
                updateProceedButtonState();
            }

            function updateOrdersDisplay() {
                var ordersContainer = $('#orders');
                var payableElement = $('#payable');
                var totalElement = $('#total');
                var total = 0;

                // Count occurrences and calculate totals
                var itemCounts = {};
                orders.forEach((order) => {
                    if (itemCounts.hasOwnProperty(order.foodName)) {
                        itemCounts[order.foodName].count++;
                        itemCounts[order.foodName].total += order.price;
                    } else {
                        itemCounts[order.foodName] = {
                            count: order.quantity,
                            price: order.price,
                            total: order.total
                        };
                    }
                });

                ordersContainer.html('');

                // Update display with item counts and totals
                Object.keys(itemCounts).forEach((itemName) => {
                    var item = itemCounts[itemName];
                    var promo = $(this).data('promo');

                    var orderDiv = $('<div></div>').addClass(
                        'w-full flex items-center text-sm py-2 overflow-x-hidden');
                    var firstDiv = $('<div></div>').addClass('w-[73%] flex flex-col justify-center');
                    var secondDiv = $('<div></div>').addClass('w-[20%] flex items-center justify-between');
                    var deleteDiv = $('<div></div>').addClass('w-[7%] flex items-center justify-center');

                    var orderedFoodElement = $('<p></p>').text(itemName).text(promo).addClass('text-xs');
                    var orderedFoodCount = $('<p></p>').text('₱' + item.price.toFixed(2) + ' x ' + item
                        .count).addClass('text-xs');
                    firstDiv.append(orderedFoodElement);
                    firstDiv.append(orderedFoodCount);

                    var priceElement = $('<p></p>').html('&#8369; ' + item.total.toFixed(2));
                    secondDiv.append(priceElement);

                    // Create inputs based on quantity
                    for (var i = 0; i < item.count; i++) {
                        var inputElement = $('<input>').attr({
                            type: 'hidden',
                            name: 'food_name[]',
                            value: itemName
                        })
                        firstDiv.append(inputElement);
                    }

                    var deleteButton = $('<button></button>').text('-').addClass(
                        'delete-button bg-red-500 text-white px-2 py-1 rounded').data('item-name',
                        itemName);
                    deleteDiv.append(deleteButton);

                    orderDiv.append(firstDiv);
                    orderDiv.append(secondDiv);
                    orderDiv.append(deleteDiv);

                    ordersContainer.append(orderDiv);

                    total += item.total;
                });

                totalElement.text(total.toFixed(2));
                payableElement.text(total.toFixed(2));
                $('#proceed').text('PAY ' + total.toFixed(2));
                updateProceedButtonState();
            }



            // Event listener for button clicks
            $('#foods').on('click', '.menu-button', function() {
                let foodName = $(this).data('food-name');
                let promo = $(this).data('promo');
                let price = parseFloat($(this).data('price'));

                if (foodName && !isNaN(price)) {

                    addToOrders(foodName, price, promo);
                    updateOrdersDisplay();
                    keepFocus(); // Ensure the input field stays focused
                } else {
                    console.log('Invalid item data:', foodName, price);
                }
            });

            // Event listener for delete button clicks
            $('#orders').on('click', '.delete-button', function() {
                let itemName = $(this).data('item-name');
                removeFromOrders(itemName);
                updateOrdersDisplay();
            });

            // Trigger barcode scanning automatically
            keepFocus();

            $('#clear').on('click', function(event) {
                event.preventDefault();
                orders = [];
                updateOrdersDisplay();
            });
        });
    </script>

</body>

</html>
