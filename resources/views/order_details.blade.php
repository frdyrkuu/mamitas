<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    {{-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> --}}
    <script src="{{ asset('jquery/jquery.js') }}"></script>
    <script src="{{asset('html2canvas.min.js')}}"></script>
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    @vite('resources/css/app.css')
    <title>Dashboard</title>
    <style>
        /* Print styles */
        @media print {
            body * {
                visibility: hidden;
            }
            
            #receipt, #receipt * {
                visibility: visible;
            }
            @page {
            size: 80mm auto; /* Let the height adjust automatically */
            margin: 0; /* Optional: Adjust margins if needed */
        }
        }
        #receipt{
            font-family: 'Courier New', monospace;
        }
    </style>
</head>
<body class="w-full h-screen">
    <div id="coverup" class="hidden w-full bg-main h-screen absolute z-50 opacity-60"></div>
    <div id="success_popup" class="hidden bg-white w-1/4 px-7 py-11 rounded-lg absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50">
        <img src="{{asset('images/success.png')}}" alt="" class="block mx-auto w-[20%] h-auto">
        <p class="text-3xl text-green-500 font-medium text-center mb-4">Payment successful!</p>
    </div>
    <div id="receipt" class="invisible w-[80mm] px-5 py-5 bg-white absolute top-0 left-1/2 transform -translate-x-1/2">
        <img src="{{asset('images/receipt-logo.png')}}" alt="" class="block mx-auto pt-3 pb-8 w-[70%]">
        <p class="text-center text-lg font-semibold">MAMATID</p>
        <p class="text-center">MAMITA'S MAMATID #31 JP RIZAL ST.</p>
        <p class="text-center mb-7">MAMATID, CABUYAO CITY LAGUNA PHILIPPINES</p>
        <div class="w-full">
            <p class="text-xs font-medium mb-2">{{ $time }}</p>
            @php
                // Define an array of food prices, where the key is the food name and the value is the price
                $foodPrices = $prices;
                $pay = 0;
                $total = 0;
                $subTotal = 0; // Initialize $subTotal
                $tax = 0;
            @endphp
            @foreach ($foods as $food)
            @php
                // Get the price from the $foodPrices array based on the food name
                $price = $foodPrices[$food->food_name] ?? 0; // Default to 0 if the price is not found
                $total = $price * $food->count;
                $pay += $total;
                $subTotal += $total; // Accumulate the subtotal
            @endphp
                <div class="w-full flex gap-2 text-xs mb-2">
                    <p class="w-[10%]">{{ $food->count }}</p>
                    <p class="w-[40%]">{{ $food->food_name }}</p>
                    <p class="w-1/4">@ &#8369;{{ $price = $foodPrices[$food->food_name] ?? 0; }}.00</p>
                    <p class="w-1/4 text-right">&#8369; {{$total}}.00</p>
                </div>
            @endforeach
            @php
                $tax = $subTotal * 0.12; // Calculate tax based on subtotal
                $totalDue = $subTotal - $tax; // Total due includes tax
            @endphp
            <div class="w-full flex justify-between mb-1">
                <p class="text-md">TOTAL DUE</p>
                <p class="text-xl font-semibold">PHP {{$pay}}.00</p>
            </div>
            <div class="w-full flex justify-between mb-1 text-sm">
                <p>VATable Sales</p>
                <p>{{$totalDue}}</p>
            </div>
            <div class="w-full flex justify-between mb-1 text-sm">
                <p>VAT Amount</p>
                <p>{{$tax}}</p>
            </div>
            <div class="w-full flex justify-between mb-1 text-sm">
                <p>Zero-Rated Sales</p>
                <p>0.00</p>
            </div>
            <div class="w-full flex justify-between mb-1 text-sm">
                <p>VAT-Exempt Sales</p>
                <p>0.00</p>
            </div>
            <p class="text-xs">Cust Name:_______________________</p>
            <p class="text-xs">Address:_________________________</p>
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
    <div class="w-full flex h-full">
        {{-- navigations --}}
        <div class="w-[6%] py-6 bg-white relative">
            <div class="flex w-2/3 mx-auto flex-col items-center justify-center py-4 mb-3">
                <img src="{{asset('images/logo-transparent.png')}}" alt="">
            </div>
            <div href="{{route('dashboard')}}" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{asset('images/products-new.png')}}" alt="Home Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">Home</p>
            </div>
            <div href="{{route('cashier')}}" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4 rounded-xl bg-[#f5a7a4]">
                <img src="{{asset('images/cashier-red.png')}}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#e5231a]">Cashier</p>
            </div>
            <div href="{{route('history')}}" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{asset('images/history-new.png')}}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">History</p>
            </div>
            <div href="{{route('inventory')}}" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{asset('images/inv-new.png')}}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">Inventory</p>
            </div>
            <div href="{{route('orders')}}" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{asset('images/order-new.png')}}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">Orders</p>
            </div>
            <div href="{{route('office.login')}}" target="__blank" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{asset('images/backoffice-new.png')}}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">Office</p>
            </div>
        </div>
        {{-- POS --}}
        <div class="w-[95%] p-4 bg-[#f2f2f2]">
            <div class="w-full h-fit bg-white rounded-xl py-3 px-5 mb-6">
                <p class="text-lg font-medium">Order <span class="text-main">#1-{{$ticket}}</span></p>
                <p class="text-sm text-[#565857]">{{ $time }}</p>
            </div>
            <div class="w-full flex gap-6 h-fit">
                <div class="w-[60%]">
                    <div class="w-full py-3 px-5 mb-3 bg-white rounded-xl">
                        <div class="w-full border-b pb-3">
                            <p class="font-semibold">Ordered Items</p>
                        </div>
                        <div class="w-full border-b h-[220px]">
                            <div class="py-3">
                                @php
                                // Define an array of food prices, where the key is the food name and the value is the price
                                $foodPrices = $prices;
                                $pay = 0;
                                $total = 0;
                                $tax = 0;
                                @endphp
                                @foreach ($foods as $food)
                                    @php
                                        // Get the price from the $foodPrices array based on the food name
                                        $price = $foodPrices[$food->food_name] ?? 0; // Default to 0 if the price is not found
                                        $total = $price * $food->count;
                                        $pay += $total;
                                        $tax = $pay * 0.12;
                                        $subTotal = $pay - $tax;
                                    @endphp
                                    <div class="w-full flex">
                                        <div class="w-[58%]">
                                            <p>{{ $food->food_name }}</p>
                                        </div>
                                        <div class="w-[15.33%]">
                                            <p>per pc</p>
                                        </div>
                                        <div class="w-[13.33%] text-right">
                                            <p>&#8369;{{ $price = $foodPrices[$food->food_name] ?? 0; }}.00 x {{ $food->count }}</p>
                                        </div>
                                        <div class="w-[13.33%] text-right">
                                            <p>&#8369; {{$total}}.00</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="flex justify-end">
                            <div class="w-[30%] p-3">
                                <div class="w-full">
                                    <select name="" id="discount_select" class="w-full outline-none px-3 py-1 border border-black rounded-xl">
                                        <option value="">Select discount</option>
                                        <option value="senior_citizen">Senior Citizen</option>
                                        <option value="pwd">PWD</option>
                                    </select>
                                </div>
                                <div class="w-full flex justify-between">
                                    <p>Discount</p>
                                    <p id="discount"></p>
                                </div>
                                <div class="w-full flex justify-between">
                                    <p class="text-lg font-medium">Total</p>
                                    <p id="total" class="text-lg font-medium">&#8369; {{$pay}}.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="w-[40%] bg-white rounded-xl px-5 py-4">
                    <form id="paymentForm" action="{{route('sale')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="w-full py-6 flex items-center justify-center bg-[#3c463f] mb-4 rounded-lg">
                            <input id="cash" type="text" name="cash" class="bg-[#3c463f] w-full text-5xl text-center text-white outline-none appearance-none bg-none">
                        </div>
                        <div class="w-full h-[250px] grid grid-cols-3 grid-rows-4 gap-2 mb-9">
                            <button type="button" class="rounded-md border-2 shadow-md calc-btn" data-val="1">1</button>
                            <button type="button" class="rounded-md border-2 shadow-md calc-btn" data-val="2">2</button>
                            <button type="button" class="rounded-md border-2 shadow-md calc-btn" data-val="3">3</button>
                            <button type="button" class="rounded-md border-2 shadow-md calc-btn" data-val="4">4</button>
                            <button type="button" class="rounded-md border-2 shadow-md calc-btn" data-val="5">5</button>
                            <button type="button" class="rounded-md border-2 shadow-md calc-btn" data-val="6">6</button>
                            <button type="button" class="rounded-md border-2 shadow-md calc-btn" data-val="7">7</button>
                            <button type="button" class="rounded-md border-2 shadow-md calc-btn" data-val="8">8</button>
                            <button type="button" class="rounded-md border-2 shadow-md calc-btn" data-val="9">9</button>
                            <button type="button" class="rounded-md border-2 shadow-md col-span-2 calc-btn" data-val="0">0</button>
                            <button type="button" class="rounded-md border-2 shadow-md calc-btn" data-val="del">DEL</button>
                        </div>
                        <input type="hidden" name="sub_total" value="{{$subTotal}}">
                        <input type="hidden" name="tax" value="{{$tax}}">
                        <input id="payInput" type="hidden" name="pay" value="{{$pay}}">
                        <input type="hidden" name="ticket" value="{{$ticket}}">
                        <input type="hidden" name="customer" value="{{$customer}}">
                        <button id="submitButton" type="submit" class="w-full py-2 rounded-xl text-lg text-white mb-1" disabled>Pay</button>
                        <script>
                            $(document).ready(function() {
                                var pay = {{$pay}};
                                var new_total = pay;  // Initialize new_total with the initial pay value
                                
                                // Handle discount selection
                                $('#discount_select').on('change', function() {
                                    var discount_type = $(this).val();
                                    console.log(discount_type);
                        
                                    if (discount_type == 'senior_citizen' || discount_type == 'pwd') {
                                        $('#discount').text('20%');
                                        new_total = pay - (pay * 0.20);  // Update new_total value
                                        $('#total').text(new_total);
                                        $('#payInput').val(new_total)
                                    } else {
                                        new_total = pay;  // Reset to original pay if no discount is applied
                                    }
                                });
                        
                                // Handle calculator button clicks
                                var submit = document.getElementById('submitButton');
                        
                                if (submit.disabled) {
                                    submit.classList.remove('bg-proceed');
                                    submit.classList.add('bg-gray-500');
                                }
                        
                                document.querySelectorAll('.calc-btn').forEach(button => {
                                    button.addEventListener('click', () => {
                                        const value = button.getAttribute('data-val');
                                        var cash_disp = document.getElementById('cash');
                        
                                        if (value === "del") {
                                            // Remove the last character from the input value
                                            cash_disp.value = cash_disp.value.slice(0, -1);
                                        } else {
                                            // Concatenate the new value to the existing value of the input element
                                            cash_disp.value += value;
                                        }
                        
                                        // Get the current value of the input field
                                        var cash = cash_disp.value;
                                        console.log(cash);
                        
                                        if (cash === '') { // Check if cash input is empty
                                            submit.disabled = true; // Disable submit button
                                            submit.classList.remove('bg-main');
                                            submit.classList.add('bg-gray-500');
                                            return; // Exit function early if cash input is empty
                                        }
                        
                                        var cashVal = parseInt(cash, 10);
                                        if (isNaN(cashVal)) {
                                            console.log("Please enter a valid number.");
                                            submit.disabled = true;
                                            submit.classList.remove('bg-main');
                                            submit.classList.add('bg-gray-500');
                                        } else if (cashVal < new_total) {
                                            console.log("The entered cash is less than the total.");
                                            submit.classList.remove('bg-main');
                                            submit.classList.add('bg-gray-500');
                                            submit.disabled = true;
                                        } else {
                                            console.log("The entered cash is greater than or equal to the total.");
                                            submit.disabled = false;
                                            submit.classList.remove('bg-gray-500');
                                            submit.classList.add('bg-main');
                                        }
                                    });
                                });

                                $('#cash').on('keyup', function(){
                                    cash_value = $(this).val()
                                    console.log(cash_value)

                                    var cash_amount = cash_value

                                    if (cash === '') { // Check if cash input is empty
                                        submit.disabled = true; // Disable submit button
                                        submit.classList.remove('bg-main');
                                        submit.classList.add('bg-gray-500');
                                        return; // Exit function early if cash input is empty
                                    }

                                    var cashVal = parseInt(cash_amount, 10);
                                        if (isNaN(cashVal)) {
                                            console.log("Please enter a valid number.");
                                            submit.disabled = true;
                                            submit.classList.remove('bg-main');
                                            submit.classList.add('bg-gray-500');
                                        } else if (cashVal < new_total) {
                                            console.log("The entered cash is less than the total.");
                                            submit.classList.remove('bg-main');
                                            submit.classList.add('bg-gray-500');
                                            submit.disabled = true;
                                        } else {
                                            console.log("The entered cash is greater than or equal to the total.");
                                            submit.disabled = false;
                                            submit.classList.remove('bg-gray-500');
                                            submit.classList.add('bg-main');
                                        }
                                })
                            });
                        </script>
                        
                        {{-- <div class="w-full flex gap-3">
                            <button type="button" onclick="printReceipt()" class="w-full bg-[#3d3d3d] text-white py-2 rounded-lg">Print receipt</button>
                        </div> --}}
                    </form>
                    <p class="mt-5 text-center mb-5">Quick cash payment</p>
                    <div class="w-full flex gap-3">
                        <button onclick="setAmount(20)" class="w-1/4 bg-[#3d3d3d] text-white py-1 rounded-lg">&#8369; 20.00</button>
                        <button onclick="setAmount(50)" class="w-1/4 bg-[#3d3d3d] text-white py-1 rounded-lg">&#8369; 50.00</button>
                        <button onclick="setAmount(100)" class="w-1/4 bg-[#3d3d3d] text-white py-1 rounded-lg">&#8369; 100.00</button>
                        <button onclick="setAmount(200)" class="w-1/4 bg-[#3d3d3d] text-white py-1 rounded-lg">&#8369; 200.00</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            var submit = document.getElementById('submitButton');
            submit.addEventListener('click', function(event) {
                event.preventDefault(); // Prevent the form from submitting immediately

                // Show the success popup and coverup
                document.getElementById('success_popup').classList.remove('hidden');
                document.getElementById('coverup').classList.remove('hidden');

                // Wait for 1 second before submitting the form
                setTimeout(function() {
                    document.getElementById('success_popup').classList.add('hidden');
                    document.getElementById('coverup').classList.add('hidden');
                    // Submit the form by selecting the form element and calling submit on it
                    document.getElementById('paymentForm').submit();
                }, 2000); // 1000 milliseconds = 1 second
            });
        });

        // function setAmount(amount) {
        // const cashInput = document.getElementById('cash');
        // cashInput.value = amount;

        // // Trigger the logic to enable or disable the submit button based on the new amount
        // var submit = document.getElementById('submitButton');
        // var total = {{ $pay }}; // Example total value, replace with actual total
        // var cashVal = parseInt(cashInput.value);
        
        // if (isNaN(cashVal) || cashVal < total) {
        //     console.log("The entered cash is less than the total.");
        //     submit.disabled = true;
        //     submit.classList.remove('bg-main');
        //     submit.classList.add('bg-gray-500');
        // } else {
        //     console.log("The entered cash is greater than or equal to the total.");
        //     submit.disabled = false;
        //     submit.classList.remove('bg-gray-500');
        //     submit.classList.add('bg-main');
        // }
    // }

        function printReceipt(){
            event.preventDefault(); // Prevent default form submission
            $('#receipt').removeClass('invisible')
            html2canvas(document.getElementById('receipt'), {
                scale: 2 // Increase scale for better quality
            }).then(function(canvas) {
                var link = document.createElement('a');
                link.href = canvas.toDataURL('image/jpeg');
                link.download = 'receipt.jpg';
                link.click();
                $('#receipt').addClass('invisible')
            });
        }
    </script>
</body>
</html>