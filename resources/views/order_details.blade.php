<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>

    <!-- Assets -->
    <script src="{{ asset('jquery/jquery.js') }}"></script>
    <script src="{{ asset('html2canvas.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('css/fonts.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @vite('resources/css/app.css')
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        /* Print styles */
        @media print {
            body * {
                visibility: hidden;
            }

            #receipt,
            #receipt * {
                visibility: visible !important;
                display: block !important;
            }

            #receipt {
                position: absolute;
                left: 0;
                top: 0;
                width: 80mm;
            }

            @page {
                size: 80mm auto;
                margin: 0;
            }
        }

        #receipt {
            font-family: 'Courier New', monospace;
        }

        .calc-btn {
            transition: all 0.2s ease;
        }

        .calc-btn:active {
            transform: scale(0.95);
            opacity: 0.8;
        }

        .submit-enabled {
            background-color: #e5231a;
            cursor: pointer;
        }

        .submit-disabled {
            background-color: #6b7280;
            cursor: not-allowed;
        }

        .quick-cash-btn {
            transition: all 0.2s ease;
        }

        .quick-cash-btn:active {
            transform: scale(0.98);
        }
    </style>
</head>

<body class="w-full h-screen bg-gray-100">
    <!-- Overlay and Success Popup -->
    <div id="coverup" class="hidden w-full bg-black h-screen fixed z-50 opacity-60"></div>
    <div id="success_popup"
        class="hidden bg-white w-full md:w-1/4 px-7 py-11 rounded-lg fixed top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50 shadow-xl">
        <img src="{{ asset('images/success.png') }}" alt="Success" class="block mx-auto w-16 h-16">
        <p class="text-2xl md:text-3xl text-green-500 font-medium text-center mb-4">Payment successful!</p>
    </div>

    <!-- Receipt Template -->
    <div id="receipt" class="hidden w-[80mm] px-5 py-5 bg-white absolute top-0 left-1/2 transform -translate-x-1/2">
        <img src="{{ asset('images/receipt-logo.png') }}" alt="Logo" class="block mx-auto pt-3 pb-8 w-auto">
        <p class="text-center text-lg font-semibold">MAMATID</p>
        <p class="text-center">MAMITA'S MAMATID #31 JP RIZAL ST.</p>
        <p class="text-center mb-7">MAMATID, CABUYAO CITY LAGUNA PHILIPPINES</p>

        <div class="w-full">
            <p class="text-xs font-medium mb-2">{{ $time }}</p>
            @php
                $foodPrices = $prices;
                $pay = 0;
                $total = 0;
                $subTotal = 0;
                $tax = 0;
            @endphp

            @foreach ($foods as $food)
                @php
                    $price = $foodPrices[$food->food_name] ?? 0;
                    $total = $price * $food->count;
                    $pay += $total;
                    $subTotal += $total;
                @endphp
                <div class="w-full flex gap-2 text-xs mb-2">
                    <p class="w-[10%]">{{ $food->count }}</p>
                    <p class="w-[40%]">{{ $food->food_name }}</p>
                    <p class="w-1/4">@ &#8369;{{ $price }}.00</p>
                    <p class="w-1/4 text-right">&#8369; {{ $total }}.00</p>
                </div>
            @endforeach

            @php
                $tax = $subTotal * 0.12;
                $totalDue = $subTotal - $tax;
            @endphp

            <!-- Discount Section (Initially hidden) -->
            <div id="receipt_discount_section" class="hidden w-full flex justify-between mb-1 text-sm">
                <p>Discount (Senior/PWD)</p>
                <p id="receipt_discount_amount">0.00</p>
            </div>

            <div class="w-full flex justify-between mb-1">
                <p class="text-md">SUBTOTAL</p>
                <p class="text-md">PHP {{ $pay }}.00</p>
            </div>
            <div class="w-full flex justify-between mb-1 text-sm">
                <p>VATable Sales</p>
                <p>{{ number_format($totalDue, 2) }}</p>
            </div>
            <div class="w-full flex justify-between mb-1 text-sm">
                <p>VAT Amount</p>
                <p>{{ number_format($tax, 2) }}</p>
            </div>
            <div class="w-full flex justify-between mb-1 text-sm">
                <p>Zero-Rated Sales</p>
                <p>0.00</p>
            </div>
            <div class="w-full flex justify-between mb-1 text-sm">
                <p>VAT-Exempt Sales</p>
                <p>0.00</p>
            </div>
            <div class="w-full flex justify-between mb-1">
                <p class="text-md font-bold">TOTAL DUE</p>
                <p id="receipt_final_total" class="text-xl font-semibold">PHP {{ $pay }}.00</p>
            </div>
            <div class="w-full flex justify-between mb-1 text-sm">
                <p>Amount Tendered</p>
                <p id="receipt_amount_tendered">0.00</p>
            </div>
            <div class="w-full flex justify-between mb-1 text-sm">
                <p>Change</p>
                <p id="receipt_change">0.00</p>
            </div>
            <p class="text-xs">Cust Name:_______________________</p>
            <p class="text-xs">Address:_________________________</p>
        </div>
    </div>

    <!-- Main Layout -->
    <div class="w-full flex h-full">
        <!-- Navigation Sidebar -->
        <div class="w-16 md:w-20 py-6 bg-white relative shadow-md">
            <div class="flex w-2/3 mx-auto flex-col items-center justify-center py-4 mb-3">
                <img src="{{ asset('images/logo-transparent.png') }}" alt="Logo" class="w-full max-w-10">
            </div>
            <div class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{ asset('images/products-new.png') }}" alt="Home" class="w-1/3">
                <p class="text-xs text-gray-600">Home</p>
            </div>
            <div class="flex w-2/3 mx-auto flex-col items-center justify-center py-4 rounded-xl bg-red-100">
                <img src="{{ asset('images/cashier-red.png') }}" alt="Cashier" class="w-1/3">
                <p class="text-xs text-red-600">Cashier</p>
            </div>
            <div class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{ asset('images/history-new.png') }}" alt="History" class="w-1/3">
                <p class="text-xs text-gray-600">History</p>
            </div>
            <div class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{ asset('images/inv-new.png') }}" alt="Inventory" class="w-1/3">
                <p class="text-xs text-gray-600">Inventory</p>
            </div>
            <div class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{ asset('images/order-new.png') }}" alt="Orders" class="w-1/3">
                <p class="text-xs text-gray-600">Orders</p>
            </div>
            <div class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{ asset('images/backoffice-new.png') }}" alt="Office" class="w-1/3">
                <p class="text-xs text-gray-600">Office</p>
            </div>
        </div>

        <!-- POS Content -->
        <div class="flex-1 p-4 bg-gray-100 overflow-auto">
            <div class="w-full bg-white rounded-xl py-3 px-5 mb-6 shadow-sm">
                <p class="text-lg font-medium">Order <span class="text-red-600">#1-{{ $ticket }}</span></p>
                <p class="text-sm text-gray-600">{{ $time }}</p>
            </div>

            <div class="w-full flex flex-col lg:flex-row gap-6">
                <!-- Ordered Items -->
                <div class="w-full lg:w-3/5">
                    <div class="w-full p-5 mb-3 bg-white rounded-xl shadow-sm">
                        <div class="w-full border-b pb-3">
                            <p class="font-semibold">Ordered Items</p>
                        </div>

                        <div class="w-full border-b max-h-56 overflow-y-auto">
                            <div class="py-3">
                                @php
                                    $foodPrices = $prices;
                                    $pay = 0;
                                    $total = 0;
                                    $tax = 0;
                                @endphp

                                @foreach ($foods as $food)
                                    @php
                                        $price = $foodPrices[$food->food_name] ?? 0;
                                        $total = $price * $food->count;
                                        $pay += $total;
                                        $tax = $pay * 0.12;
                                        $subTotal = $pay - $tax;
                                    @endphp
                                    <div class="w-full flex py-1">
                                        <div class="w-3/5">
                                            <p>{{ $food->food_name }}</p>
                                        </div>
                                        <div class="w-1/5 text-right">
                                            <p>&#8369;{{ $price }}.00 x {{ $food->count }}</p>
                                        </div>
                                        <div class="w-1/5 text-right">
                                            <p>&#8369; {{ $total }}.00</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex justify-end mt-3">
                            <div class="w-full md:w-1/3 p-3">
                                <select id="discount_select"
                                    class="w-full outline-none px-3 py-2 border border-gray-300 rounded-xl mb-2">
                                    <option value="">Select discount</option>
                                    <option value="senior_citizen">Senior Citizen</option>
                                    <option value="pwd">PWD</option>
                                </select>

                                <div class="w-full flex justify-between mb-1">
                                    <p>Discount</p>
                                    <p id="discount">0%</p>
                                </div>
                                <div class="w-full flex justify-between">
                                    <p class="text-lg font-medium">Total</p>
                                    <p id="total" class="text-lg font-medium">&#8369; {{ $pay }}.00</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Payment Section -->
                <div class="w-full lg:w-2/5 bg-white rounded-xl p-5 shadow-sm">
                    <form id="paymentForm" action="{{ route('sale') }}" method="POST">
                        @csrf
                        <div class="w-full py-6 flex items-center justify-center bg-gray-800 mb-4 rounded-lg">
                            <input id="cash" type="text" name="cash"
                                class="bg-gray-800 w-full text-3xl md:text-5xl text-center text-white outline-none appearance-none bg-none"
                                placeholder="0.00">
                        </div>

                        <!-- Calculator -->
                        <div class="w-full grid grid-cols-3 gap-2 mb-6">
                            <button type="button" class="calc-btn py-3 rounded-md border border-gray-300 shadow-sm"
                                data-val="1">1</button>
                            <button type="button" class="calc-btn py-3 rounded-md border border-gray-300 shadow-sm"
                                data-val="2">2</button>
                            <button type="button" class="calc-btn py-3 rounded-md border border-gray-300 shadow-sm"
                                data-val="3">3</button>
                            <button type="button" class="calc-btn py-3 rounded-md border border-gray-300 shadow-sm"
                                data-val="4">4</button>
                            <button type="button" class="calc-btn py-3 rounded-md border border-gray-300 shadow-sm"
                                data-val="5">5</button>
                            <button type="button" class="calc-btn py-3 rounded-md border border-gray-300 shadow-sm"
                                data-val="6">6</button>
                            <button type="button" class="calc-btn py-3 rounded-md border border-gray-300 shadow-sm"
                                data-val="7">7</button>
                            <button type="button" class="calc-btn py-3 rounded-md border border-gray-300 shadow-sm"
                                data-val="8">8</button>
                            <button type="button" class="calc-btn py-3 rounded-md border border-gray-300 shadow-sm"
                                data-val="9">9</button>
                            <button type="button"
                                class="calc-btn py-3 rounded-md border border-gray-300 shadow-sm col-span-2"
                                data-val="0">0</button>
                            <button type="button" class="calc-btn py-3 rounded-md border border-gray-300 shadow-sm"
                                data-val="del">DEL</button>
                        </div>

                        <input type="hidden" name="sub_total" value="{{ $subTotal }}">
                        <input type="hidden" name="tax" value="{{ $tax }}">
                        <input id="payInput" type="hidden" name="pay" value="{{ $pay }}">
                        <input type="hidden" name="ticket" value="{{ $ticket }}">
                        <input type="hidden" name="customer" value="{{ $customer }}">

                        <!-- Action Buttons -->
                        <button id="submitButton" type="submit"
                            class="w-full py-3 rounded-xl text-lg text-white mb-2 submit-disabled" disabled>
                            Pay
                        </button>

                        <div class="grid grid-cols-2 gap-2 mb-2">
                            <button type="button" onclick="printReceipt()"
                                class="py-2 bg-gray-700 text-white rounded-lg">
                                Print Receipt
                            </button>
                            <button type="button" onclick="directPrint()"
                                class="py-2 bg-gray-700 text-white rounded-lg">
                                Direct Print
                            </button>
                        </div>

                        <button type="button" onclick="handleGcashPayment()"
                            class="w-full py-2 bg-blue-600 text-white rounded-lg mb-4">
                            GCash Payment
                        </button>

                        <!-- Quick Cash -->
                        <p class="text-center mb-3 text-gray-600">Quick cash payment</p>
                        <div class="grid grid-cols-4 gap-2">
                            <button type="button" onclick="setAmount(20)"
                                class="quick-cash-btn py-1 bg-gray-700 text-white rounded-lg">
                                &#8369; 20
                            </button>
                            <button type="button" onclick="setAmount(50)"
                                class="quick-cash-btn py-1 bg-gray-700 text-white rounded-lg">
                                &#8369; 50
                            </button>
                            <button type="button" onclick="setAmount(100)"
                                class="quick-cash-btn py-1 bg-gray-700 text-white rounded-lg">
                                &#8369; 100
                            </button>
                            <button type="button" onclick="setAmount(200)"
                                class="quick-cash-btn py-1 bg-gray-700 text-white rounded-lg">
                                &#8369; 200
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Constants and variables
            const pay = {{ $pay }};
            let new_total = pay;
            const submitButton = $('#submitButton');
            const cashInput = $('#cash');
            const discountSelect = $('#discount_select');
            const totalDisplay = $('#total');
            const payInput = $('#payInput');
            const receipt = $('#receipt');
            const coverup = $('#coverup');
            const successPopup = $('#success_popup');

            // Initialize
            updateSubmitButtonState();

            // Event handlers
            discountSelect.on('change', handleDiscountChange);
            $(document).on('click', '.calc-btn', handleCalculatorButton);
            cashInput.on('input', handleCashInput);
            submitButton.on('click', handlePaymentSubmission);

            // Global functions
            window.setAmount = function(amount) {
                cashInput.val(amount).trigger('input');
            }

            window.printReceipt = function() {
                updateReceiptValues();
                receipt.removeClass('hidden');

                setTimeout(() => {
                    html2canvas(receipt[0], {
                        scale: 2,
                        useCORS: true
                    }).then(canvas => {
                        const link = document.createElement('a');
                        link.href = canvas.toDataURL('image/jpeg', 1.0);
                        link.download = 'receipt.jpg';
                        link.click();
                        receipt.addClass('hidden');
                    });
                }, 200);
            }

            window.directPrint = function() {
                updateReceiptValues();
                receipt.removeClass('hidden');
                window.print();
                setTimeout(() => receipt.addClass('hidden'), 100);
            }

            window.handleGcashPayment = async function() {
                const discountData = $('#receipt').data('discount');
                const totalAmount = discountData ? discountData.total : pay;

                // First confirmation dialog
                const {
                    isConfirmed
                } = await Swal.fire({
                    title: 'GCash Payment',
                    html: `
            <div class="text-left">
                <p class="text-lg font-semibold mb-2">Total Amount: ₱${totalAmount.toFixed(2)}</p>
                <p class="mb-4">Has the customer completed the GCash payment?</p>
            </div>
        `,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, payment sent',
                    cancelButtonText: 'No, cancel',
                    confirmButtonColor: '#00a859',
                });

                if (!isConfirmed) return;

                // Transaction details input
                const {
                    value: gcashData
                } = await Swal.fire({
                    title: 'Enter Transaction Details',
                    html: `
            <div class="text-left">
                <p class="mb-2">Amount: ₱${totalAmount.toFixed(2)}</p>
                <input 
                    id="gcashReference" 
                    class="swal2-input mb-2" 
                    placeholder="GCash Reference Number"
                    required
                >
                <input 
                    id="gcashSender" 
                    class="swal2-input" 
                    placeholder="Sender Name (Optional)"
                >
            </div>
        `,
                    focusConfirm: false,
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel',
                    preConfirm: () => {
                        const reference = document.getElementById('gcashReference').value;
                        if (!reference) {
                            Swal.showValidationMessage('Reference number is required');
                            return false;
                        }
                        return {
                            reference: reference,
                            sender: document.getElementById('gcashSender').value || null
                        }
                    }
                });

                if (gcashData) {
                    try {
                        // Get CSRF token - alternative methods if meta tag not found
                        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content ||
                            document.head.querySelector('meta[name="csrf-token"]')?.content ||
                            window.Laravel?.csrfToken;

                        if (!csrfToken) {
                            throw new Error('CSRF token not found');
                        }

                        // Send data to Laravel backend
                        const response = await fetch('/gcash-transactions', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                reference_number: gcashData.reference,
                                sender_name: gcashData.sender,
                                amount: totalAmount,
                                // Add ticket_number if you have it
                                // ticket_number: 'YOUR_TICKET_NUMBER'
                            })
                        });

                        if (!response.ok) {
                            const errorData = await response.json();
                            throw new Error(errorData.message || 'Failed to save transaction');
                        }

                        // Set the cash input to the exact amount
                        $('#cash').val(totalAmount.toFixed(2)).trigger('input');

                        // Add hidden fields for GCash data
                        updateOrCreateHiddenField('gcash_reference', gcashData.reference);
                        updateOrCreateHiddenField('gcash_sender', gcashData.sender);
                        updateOrCreateHiddenField('payment_method', 'gcash');

                        await Swal.fire({
                            title: 'GCash Payment Recorded',
                            html: `
                    <div class="text-left">
                        <p class="mb-1">Amount: ₱${totalAmount.toFixed(2)}</p>
                        <p class="mb-1">Reference: ${gcashData.reference}</p>
                        ${gcashData.sender ? `<p>Sender: ${gcashData.sender}</p>` : ''}
                    </div>
                `,
                            icon: 'success',
                            confirmButtonColor: '#00a859',
                        });

                    } catch (error) {
                        Swal.fire({
                            title: 'Error',
                            text: error.message,
                            icon: 'error'
                        });
                        console.error('Error:', error);
                    }
                }
            }

            function updateOrCreateHiddenField(name, value) {
                let field = $(`input[name="${name}"]`);
                if (field.length) {
                    field.val(value);
                } else {
                    $('<input>').attr({
                        type: 'hidden',
                        name: name,
                        value: value
                    }).appendTo('#paymentForm');
                }
            }

            // Helper functions
            function handleDiscountChange() {
                const discount_type = $(this).val();
                let discount_percent = 0;
                let discount_amount = 0;

                if (discount_type === 'senior_citizen' || discount_type === 'pwd') {
                    discount_percent = 20;
                    discount_amount = pay * 0.20;
                    new_total = pay - discount_amount;

                    // Show discount on UI
                    $('#discount').text(`${discount_percent}% (₱${discount_amount.toFixed(2)})`);
                    totalDisplay.text(`₱ ${new_total.toFixed(2)}`);

                    // Store discount info for receipt
                    receipt.data('discount', {
                        type: discount_type,
                        amount: discount_amount,
                        total: new_total
                    });
                } else {
                    // No discount selected
                    $('#discount').text('0%');
                    totalDisplay.text(`₱ ${pay.toFixed(2)}`);
                    new_total = pay;
                    receipt.data('discount', null);
                }

                updateSubmitButtonState();
            }

            function handleCalculatorButton() {
                const value = $(this).data('val');
                let currentValue = cashInput.val() || '';

                if (value === 'del') {
                    cashInput.val(currentValue.slice(0, -1));
                } else {
                    cashInput.val(currentValue + value);
                }

                cashInput.trigger('input');
            }

            function handleCashInput() {
                updateSubmitButtonState();
                updateReceiptValues();
            }

            function updateSubmitButtonState() {
                const cashAmount = parseFloat(cashInput.val()) || 0;

                if (cashAmount >= new_total && cashInput.val() !== '') {
                    submitButton.prop('disabled', false)
                        .removeClass('submit-disabled')
                        .addClass('submit-enabled');
                } else {
                    submitButton.prop('disabled', true)
                        .removeClass('submit-enabled')
                        .addClass('submit-disabled');
                }
            }

            function updateReceiptValues() {
                const cashAmount = parseFloat(cashInput.val()) || 0;
                const discountData = receipt.data('discount');

                if (discountData) {
                    // Show discount on receipt
                    $('#receipt_discount_section').removeClass('hidden');
                    $('#receipt_discount_amount').text(`₱ ${discountData.amount.toFixed(2)}`);
                    $('#receipt_final_total').text(`₱ ${discountData.total.toFixed(2)}`);

                    // Calculate change based on discounted total
                    const change = Math.max(0, cashAmount - discountData.total);
                    $('#receipt_change').text(`₱ ${change.toFixed(2)}`);
                } else {
                    // No discount
                    $('#receipt_discount_section').addClass('hidden');
                    $('#receipt_final_total').text(`₱ ${pay.toFixed(2)}`);

                    // Calculate change based on original total
                    const change = Math.max(0, cashAmount - pay);
                    $('#receipt_change').text(`₱ ${change.toFixed(2)}`);
                }

                $('#receipt_amount_tendered').text(`₱ ${cashAmount.toFixed(2)}`);
            }

            async function handlePaymentSubmission(event) {
                event.preventDefault();

                updateReceiptValues();
                coverup.removeClass('hidden');
                successPopup.removeClass('hidden');

                try {
                    receipt.removeClass('hidden');
                    await new Promise(resolve => setTimeout(resolve, 200));

                    const canvas = await html2canvas(receipt[0], {
                        scale: 2,
                        useCORS: true
                    });

                    const link = document.createElement('a');
                    link.href = canvas.toDataURL('image/jpeg', 1.0);
                    link.download = `receipt-{{ $ticket }}.jpg`;
                    link.click();

                    receipt.addClass('hidden');
                    await new Promise(resolve => setTimeout(resolve, 1000));

                    document.getElementById('paymentForm').submit();
                } catch (error) {
                    console.error('Error:', error);
                    document.getElementById('paymentForm').submit();
                }
            }
        });
    </script>
</body>

</html>
