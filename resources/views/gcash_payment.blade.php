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
                <form action="{{route('gcash')}}" method="POST">
                <p class="text-lg font-medium">GCash Transaction</span></p>
                <p class="text-sm text-[#565857]">{{ $time }}</p>
            </div>
            <div class="w-full flex gap-6 h-fit">
                <div class="w-[60%] flex flex-col gap-3">
                    <div class="w-full py-3 px-5 mb-3 bg-white rounded-xl">
                        <div class="w-full border-b pb-3 mb-9">
                            <p class="font-semibold">Transaction Details</p>
                        </div>
                        <div class="w-full">
                            <div class="py-3">
                                <input id="tn" type="text" autocomplete="off" name="transaction_number" class="text-center outline-none w-full rounded-lg py-6 text-5xl font-bold uppercase bg-blue-500 text-white">
                                <p class="text-lg text-center">Transaction Number</p>
                            </div>
                        </div>
                    </div>
                    <div class="w-full py-3 px-5 bg-white">
                        <p class="text-center font-medium mb-2">Transaction Charges</p>
                        <table class="w-full text-center border border-black text-xs">
                            <tr class="">
                                <th class="py-1 border-r border-black text-sm">Amount</th>
                                <th class="border-r border-black text-sm">Charge</th>
                                <th class="border-r border-black text-sm">Amount</th>
                                <th class="text-sm">Charge</th>
                            </tr>
                            <tr class="w-full text-center border border-black">
                                <td class="py-1 border-r border-black">1-500</td>
                                <td class="border-r border-black">10</td>
                                <td class="border-r border-black">5001-5500</td>
                                <td>110</td>
                            </tr>
                            <tr class="w-full text-center border border-black">
                                <td class="py-1 border-r border-black">501-1000</td>
                                <td class="border-r border-black">20</td>
                                <td class="border-r border-black">5601-6000</td>
                                <td>120</td>
                            </tr>
                            <tr class="w-full text-center border border-black">
                                <td class="py-1 border-r border-black">1001-1500</td>
                                <td class="border-r border-black">30</td>
                                <td class="border-r border-black">6001-6500</td>
                                <td>130</td>
                            </tr>
                            <tr class="w-full text-center border border-black">
                                <td class="py-1 border-r border-black">1501-2000</td>
                                <td class="border-r border-black">40</td>
                                <td class="border-r border-black">6501-7000</td>
                                <td>140</td>
                            </tr>
                            <tr class="w-full text-center border border-black">
                                <td class="py-1 border-r border-black">2001-2500</td>
                                <td class="border-r border-black">50</td>
                                <td class="border-r border-black">7001-7500</td>
                                <td>150</td>
                            </tr>
                            <tr class="w-full text-center border border-black">
                                <td class="py-1 border-r border-black">2501-3000</td>
                                <td class="border-r border-black">60</td>
                                <td class="border-r border-black">7501-8000</td>
                                <td>160</td>
                            </tr>
                            <tr class="w-full text-center border border-black">
                                <td class="py-1 border-r border-black">3001-3500</td>
                                <td class="border-r border-black">70</td>
                                <td class="border-r border-black">8001-8500</td>
                                <td>170</td>
                            </tr>
                            <tr class="w-full text-center border border-black">
                                <td class="py-1 border-r border-black">3501-4000</td>
                                <td class="border-r border-black">80</td>
                                <td class="border-r border-black">8501-9000</td>
                                <td>180</td>
                            </tr>
                            <tr class="w-full text-center border border-black">
                                <td class="py-1 border-r border-black">4001-4500</td>
                                <td class="border-r border-black">90</td>
                                <td class="border-r border-black">9001-9500</td>
                                <td>190</td>
                            </tr>
                            <tr class="w-full text-center border border-black">
                                <td class="py-1 border-r border-black">4501-5000</td>
                                <td class="border-r border-black">100</td>
                                <td class="border-r border-black">9501-10000</td>
                                <td>200</td>
                            </tr>
                        </table>
                    </div>
                </div>
                <div class="w-[40%] bg-white rounded-xl px-5 py-4">
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
                        {{-- <input type="hidden" name="sub_total" value="{{$subTotal}}">
                        <input type="hidden" name="tax" value="{{$tax}}">
                        <input type="hidden" name="pay" value="{{$pay}}">
                        <input type="hidden" name="ticket" value="{{$ticket}}">
                        <input type="hidden" name="customer" value="{{$customer}}"> --}}
                        <button id="submit" type="submit" name="btn" value="cash-in" class="w-full py-2 rounded-xl text-lg text-white mb-4" disabled>Cash In</button>
                        <button id="submit1" type="submit" name="btn" value="cash-out" class="w-full py-2 rounded-xl text-lg text-white mb-4" disabled>Cash Out</button>
                        <input type="hidden" name="time" value="{{$time}}">
                        <script>
                            $(document).ready(function() {
                                var submit = document.getElementById('submit');
                                var submit1 = document.getElementById('submit1');
                                var tn = document.getElementById('tn');
                                var cash_disp = document.getElementById('cash');

                                function updateSubmitButtonState() {
                                    if (tn.value === '' || cash_disp.value === '') {
                                        submit.disabled = true;
                                        submit.classList.remove('bg-main');
                                        submit.classList.add('bg-gray-500');
                                        submit1.disabled = true;
                                        submit1.classList.remove('bg-main');
                                        submit1.classList.add('bg-gray-500');
                                    } else {
                                        submit.disabled = false;
                                        submit.classList.remove('bg-gray-500');
                                        submit.classList.add('bg-main');
                                        submit1.disabled = false;
                                        submit1.classList.remove('bg-gray-500');
                                        submit1.classList.add('bg-main');
                                    }
                                }

                                // Initial check
                                updateSubmitButtonState();

                                if (submit.disabled === true) {
                                    submit.classList.remove('bg-proceed');
                                    submit.classList.add('bg-gray-500');
                                    submit1.classList.remove('bg-proceed');
                                    submit1.classList.add('bg-gray-500');
                                }

                                document.querySelectorAll('.calc-btn').forEach(button => {
                                    button.addEventListener('click', () => {
                                        const value = button.getAttribute('data-val');

                                        if (value === "del") {
                                            // Remove the last character from the input value
                                            cash_disp.value = cash_disp.value.slice(0, -1);
                                        } else {
                                            // Concatenate the new value to the existing value of the input element
                                            cash_disp.value += value;
                                        }

                                        // Update submit button state based on the new input value
                                        updateSubmitButtonState();
                                    });
                                });

                                // Add event listener to the tn input field to update the submit button state on change
                                tn.addEventListener('input', updateSubmitButtonState);
                            });

                        </script>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
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