<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="{{ asset('jquery/jquery.js') }}"></script>
    @vite('resources/css/app.css')
    <title>Dashboard</title>
</head>
<body class="w-full h-screen bg-[#ffd962]">
    <div id="success_popup" class="hidden bg-white w-1/4 px-7 py-11 rounded-lg absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50">
        <p class="text-3xl text-green-500 font-medium text-center mb-4">Success!</p>
        <p class="text-sm text-[#8e8f8e] text-center">Added to items to be reviewed.</p>
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
    <div id="main" class="w-full flex h-full z-0">
        {{-- navigations --}}
        <div class="w-[6%] py-6 bg-white">
            <div class="flex w-2/3 mx-auto flex-col items-center justify-center py-4 mb-3">
                <img src="{{asset('images/logo-transparent.png')}}" alt="">
            </div>
            <a href="{{route('dashboard')}}" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{asset('images/products-new.png')}}" alt="Home Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">Home</p>
            </a>
            <a href="{{route('cashier')}}" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{asset('images/cashier-new.png')}}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">Cashier</p>
            </a>
            <a href="{{route('history')}}" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{asset('images/history-new.png')}}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">History</p>
            </a>
            <a href="{{route('inventory')}}" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4 rounded-xl bg-[#f5a7a4]">
                <img src="{{asset('images/inv-red.png')}}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#e5231a]">Inventory</p>
            </a>
            <a href="{{route('orders')}}" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{asset('images/order-new.png')}}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">Orders</p>
            </a>
            <a href="{{route('office.login')}}" target="__blank" class="flex w-2/3 mx-auto flex-col items-center justify-center py-4">
                <img src="{{asset('images/backoffice-new.png')}}" alt="Cashier Icon" class="w-1/3">
                <p class="text-xs text-[#565857]">Office</p>
            </a>
        </div>
        <div class="w-[94%] flex p-6 bg-[#e5e5e5]">
            <div class="w-full bg-slate-50 shadow-md rounded-xl p-6">
                <form id="itemForm" action="{{route('to_pending')}}" class="w-full" method="POST" enctype="multipart/form-data">
                    @csrf
                    <p class="text-center font-medium text-xl">Add Item</p>
                    <p class="text-center italic text-[#a1a0a0] text-sm">Items to be reviewed by the owner</p>
                    <div class=" bg-white rounded-md p-10 mb-5">
                        <div class="w-full flex items-center justify-between gap-5 mb-10">
                            <div class="w-1/2">
                                <label for="" class="text-gray-500">Item Name</label>
                                <input type="text" name="item_name" class="w-full mt-1 px-2 py-1 outline-none border-b-2 bg-slate-50 border-[#eaeaea] focus:border-b-2 focus:border-main">
                            </div>
                            <div class="w-1/3">
                                <label for="" class="text-gray-500">Supplier</label>
                                <select name="supplier" class="w-full mt-1 p-2 border border-[#eaeaea] focus:border-main outline-none rounded-md">
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{$supplier->name}}">{{$supplier->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="w-full flex items-center justify-between gap-5 mb-10">
                            <div class="w-1/3">
                                <label for="" class="text-gray-500">Color</label>
                                <input type="text" name="color" class="w-full mt-1 px-2 py-1 outline-none border-b-2 bg-slate-50 border-[#eaeaea] focus:border-b-2 focus:border-main">
                            </div>
                            <div class="w-1/3 flex items-end">
                                <div class="w-1/2">
                                    <label for="" class="text-gray-500">Size</label>
                                    <input type="text" name="size" class="w-full mt-1 px-2 py-1 outline-none border-b-2 bg-slate-50 border-[#eaeaea] focus:border-b-2 focus:border-main">
                                </div>
                                <div class="w-1/2">
                                    <select name="size_legend" id="" class="w-full mt-1 px-2 py-2 outline-none border-b-2 bg-slate-50 border-[#eaeaea] focus:border-b-2 focus:border-main">
                                        <option value="g">Grams (g)</option>
                                        <option value="kg">Kilograms (kg)</option>
                                        <option value="ml">Milliliters (ml)</option>
                                        <option value="l">Liters (l)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="w-1/3">
                                <label for="" class="text-gray-500">Select Category</label>
                                <select name="category" id="" class="w-full mt-1 px-2 py-1 outline-none border-b-2 bg-slate-50 border-[#eaeaea] focus:border-b-2 focus:border-main">
                                    <option value="dry_goods">Dry Goods</option>
                                    <option value="wet_goods">Wet Goods</option>
                                    <option value="Limited Edition">Limited Edition</option>
                                </select>
                            </div>
                        </div>
                        <div class="w-full flex items-center justify-between gap-5">
                            <div class="w-1/2">
                                <label for="" class="text-gray-500">Product unit</label>
                                <select name="product_unit" class="w-full mt-1 px-2 py-1 outline-none border-b-2 bg-slate-50 border-[#eaeaea] focus:border-b-2 focus:border-main">
                                    <option value="pc">Per pc</option>
                                    <option value="kg">Per kg</option>
                                    <option value="pack">Per pack</option>
                                    <option value="sack">Per sack</option>
                                    <option value="box">Per box</option>
                                    <option value="case">Per case</option>
                                    <option value="gallon">Per gallon</option>
                                </select>
                            </div>
                            <div class="w-1/2">
                                <label for="" class="text-gray-500">Barcode</label>
                                <input type="text" name="barcode" class="w-full mt-1 px-2 py-1 outline-none border-b-2 bg-slate-50 border-[#eaeaea] focus:border-b-2 focus:border-main" autofocus="false">
                            </div>
                        </div>
                    </div>
                    <div class=" bg-white rounded-md p-10">
                        <div class="w-full flex items-center justify-between gap-16 mb-10">
                            <div class="w-1/2">
                                <label for="" class="text-gray-500">Purchase Cost</label>
                                <input type="number" name="cost" step="any" class="w-full mt-1 px-2 py-1 outline-none border-b-2 bg-slate-50 border-[#eaeaea] focus:border-b-2 focus:border-main">
                            </div>
                            <div class="w-1/2">
                                <label for="" class="text-gray-500">Retail Value</label>
                                <input type="number" name="retail" class="w-full mt-1 px-2 py-1 outline-none border-b-2 bg-slate-50 border-[#eaeaea] focus:border-b-2 focus:border-main">
                            </div>
                        </div>
                        <div class="w-ful flex gap-16">
                            <div class="w-1/2">
                                <label for="" class="text-gray-500">Item Image</label>
                                <input type="file" name="item_image" class="mt-1">
                            </div>
                            <div class="w-1/2 flex gap-5 items-center justify-end">
                                <button type="button" id="submitButton" class="w-[200px] bg-white border-2 border-main hover:bg-main hover:border-2 hover:border-main ease-in-out duration-100 rounded-md py-2 shadow-md font-medium text-xs text-main hover:text-white">Add Item</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('submitButton').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Show the success popup
            document.getElementById('success_popup').classList.remove('hidden');
            document.getElementById('main').style.filter = 'blur(5px)'

            // Hide the popup after 2 seconds and submit the form
            setTimeout(function() {
                document.getElementById('success_popup').classList.add('hidden');
                document.getElementById('itemForm').submit(); // Submit the form
            }, 1000); // Adjust the delay as needed
        });

        $(document).ready(function(){
            $('#item_search').on('keyup', function(){
    var key = $(this).val();
    var url = '{{route("item_search", ["key" => ":key"])}}';
    url = url.replace(':key', key);
    // console.log(url)

    $.ajax({
        url: url,
        method: 'GET',
        success: function(response){
            var itemDiv = $('#search_result');
            itemDiv.empty(); // Clear the current contents

            response.menus.forEach(function(menu) {
                var quantityClass = '';
                var quantityText = '';

                if (menu.quantity >= 100) {
                    quantityClass = 'text-green-500 font-medium';
                    quantityText = 'High amount';
                } else if (menu.quantity >= 50) {
                    quantityClass = 'text-blue-500 font-medium';
                    quantityText = 'Good amount';
                } else if (menu.quantity >= 20) {
                    quantityClass = 'text-orange-500 font-medium';
                    quantityText = 'Low amount';
                } else if (menu.quantity >= 1) {
                    quantityClass = 'text-red-500 font-medium';
                    quantityText = 'Critically low amount';
                } else if (menu.quantity == 0) {
                    quantityClass = 'text-red-500 font-medium';
                    quantityText = 'No stocks';
                }

                var itemList = `
                <div class='w-full flex items-center text-sm py-4 px-5 text-gray-700 border-b border-[#dadada] text-left'>
                    <p class='w-[40%]'>${menu.item}</p>
                    <p class='w-[10%] text-right'>${menu.quantity}</p>
                    <p class='w-[15%] ${quantityClass} text-right'>${quantityText}</p>
                    <p class='w-[15%] text-right'>${new Date(menu.updated_at).toLocaleString()}</p>
                    <p class='w-[20%] text-right'>${menu.update_reason}</p>
                </div>
                `;
                itemDiv.append(itemList);
            });
        },
        error: function(xhr, status, error){
            console.error(xhr, status, error);
        }
    })
});

        })
    </script>
</body>
</html>