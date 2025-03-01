<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <title>Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body class="w-full h-screen bg-white">
    <div class="w-2/4 mx-auto hidden absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50" id="scanner">
        <video class="mx-auto" id="preview" width="1%"></video><br>
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
        <div class="w-[6%] py-6">
            <div class="flex w-2/3 mx-auto flex-col items-center justify-center py-4 mb-3">
                <img src="{{ asset($cmsData->company_logo) }}" alt="">
            </div>
            <div href="{{route('dashboard')}}" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4 rounded-xl bg-[#f5a7a4]">
                <img src="{{asset('images/products-red.png')}}" alt="Home Icon" class="w-1/3">
                <p class="text-xs text-[#e5231a]">Home</p>
            </div>
            <div href="{{route('cashier')}}" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{asset('images/cashier-new.png')}}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">Cashier</p>
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
            <a href="{{route('office.login')}}" target="__blank" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{asset('images/backoffice-new.png')}}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">Office</p>
            </a>
        </div>
        {{-- POS --}}
        <div class="w-[95%] flex py-10 bg-[#e5e5e5]">
            <div class="w-full grid grid-cols-3 grid-rows-3">
                <div class="w-10/12 grid grid-cols-5 grid-rows-5 row-start-2 col-start-2 shadow-2xl bg-[#f2f2f2]">
                    <p class="row-start-2 col-start-2 col-span-3 text-center">Starting money</p>
                    <form action="{{route('start_shift')}}" method="POST" class="w-full row-start-3 col-start-2 col-span-3" onsubmit="return validateAmount()">
                        @csrf
                        <input type="number" name="starting_cash" id="starting_cash" class="w-full rounded-xl outline-none border border-[#bebebe] focus:border focus:border-main px-4 py-2 mb-3" required>
                        <button class="w-full bg-main py-2 uppercase text-xs rounded-xl">Start Shift</button>
                    </form>
                </div>
            </div>  
        </div>
    </div>
    <script>
        function validateAmount() {
            const amount = document.getElementById('starting_cash').value;
            if (amount < 1000) {
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid Amount',
                    text: 'Starting money must be greater than 1000'
                });
                return false;
            }
            return true;
        }

        function setAmount(amount){
            event.preventDefault()
            var cash = document.getElementById('cash')
            cash.value = amount
        }
    </script>
</body>
</html>