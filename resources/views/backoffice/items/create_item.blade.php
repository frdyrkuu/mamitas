<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/5bf9be4e76.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">

    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Back Office</title>
</head>

<body class="w-full h-auto bg-[#fefefe]">
    <div id="success_popup"
        class="hidden bg-white w-1/4 px-7 py-11 rounded-lg absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 z-50">
        <p class="text-3xl text-green-500 font-medium text-center mb-4">Succesfully added!</p>
        <p class="text-sm text-[#8e8f8e] text-center">This item is successfully added to your items list.</p>
    </div>
    <div class="w-full flex items-center h-[7%] bg-[#db121c] px-10">
        <p class="text-lg text-white">Create Item</p>
    </div>
    <div id="main" class="w-full h-[93%] flex z-0">
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
                <a href="{{ route('office.items_list') }}"
                    class="w-full flex items-center justify-center h-auto py-4 bg-[#f5a7a4]">
                    <img src="{{ asset('images/prod-red.png') }}" alt="" class="w-[30px] h-auto">
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
                <a href="{{ route('office.ordering') }}" class="w-full flex items-center justify-center h-auto py-4">
                    <img src="{{ asset('images/order-new.png') }}" alt="" class="w-[30px] h-auto">
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
        <div class="w-[95%] bg-[#f2f2f2] z-0 p-7">
            <div class="w-2/3 flex mx-auto shadow-md text-sm">
                <form id="itemForm" action="{{ route('office.add_item') }}" class="w-full" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class=" bg-white rounded-md p-10 mb-5">
                        <div class="w-full flex items-center justify-between gap-5 mb-10">
                            <div class="w-1/2">
                                <label for="" class="text-gray-500">Item Name</label>
                                <input type="text" name="item_name"
                                    class="w-full mt-1 px-2 py-1 outline-none border-b-2 bg-slate-50 border-[#eaeaea] focus:border-b-2 focus:border-main" required>
                            </div>
                            <div class="w-1/2">
                                <label for="" class="text-gray-500">SKU</label>
                                <input type="text" name="item_sku"
                                    class="w-full mt-1 px-2 py-1 outline-none border-b-2 bg-slate-50 border-[#eaeaea] focus:border-b-2 focus:border-main" required>
                            </div>
                            
                        </div>

                        <div class="w-full flex items-center justify-between gap-5 mb-10">
                            <div class="w-1/2">
                                <label for="" class="text-gray-500">Supplier</label>
                                <select name="supplier"
                                    class="w-full mt-1 p-2 border border-[#eaeaea] focus:border-main outline-none rounded-md">
                                    @foreach ($suppliers as $supplier)
                                        <option value="{{ $supplier->name }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="w-1/2">
                                <label for="expiration_date">Expiration Date</label>
                                <input 
                                    type="date" 
                                    name="expiration_date" 
                                    id="expiration_date" 
                                    class="w-full rounded-xl outline-none border border-[#bebebe] focus:border focus:border-main px-4 py-2 mb-3"
                                    min="{{ date('Y-m-d') }}"
                                >
                            </div>
                        </div>

                        <div class="w-full flex items-center justify-between gap-5 mb-10">
                            <div class="w-full">
                                <label for="" class="text-gray-500">Description</label>
                                <textarea id="message" rows="4" name="item_description"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Write your product description here..."></textarea>
                            </div>
                        </div>

                        <div class="w-full flex items-center justify-between gap-5 mb-10">
                            <div class="w-full">
                                <label for="" class="text-gray-500">Product Ad-ons Promo</label>
                                <textarea id="message" rows="4" name="item_promo"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Write your product promo here..."></textarea>
                            </div>
                        </div>

                        <div class="w-full flex items-center justify-between gap-5 mb-10">
                            <div class="w-1/3">
                                <label for="" class="text-gray-500">Color</label>
                                <input type="text" name="color"
                                    class="w-full mt-1 px-2 py-1 outline-none border-b-2 bg-slate-50 border-[#eaeaea] focus:border-b-2 focus:border-main">
                            </div>
                            <div class="w-1/3 flex items-end">
                                <div class="w-1/2">
                                    <label for="" class="text-gray-500">Size</label>
                                    <input type="text" name="size"
                                        class="w-full mt-1 px-2 py-1 outline-none border-b-2 bg-slate-50 border-[#eaeaea] focus:border-b-2 focus:border-main">
                                </div>
                                <div class="w-1/2">
                                    <select name="size_legend" id=""
                                        class="w-full mt-1 px-2 py-2 outline-none border-b-2 bg-slate-50 border-[#eaeaea] focus:border-b-2 focus:border-main">
                                        <option value="g">Grams (g)</option>
                                        <option value="kg">Kilograms (kg)</option>
                                        <option value="ml">Milliliters (ml)</option>
                                        <option value="l">Liters (l)</option>
                                    </select>
                                </div>
                            </div>
                            <div class="w-1/3">
                                <label for="" class="text-gray-500">Select Category</label>
                                <select name="category" id=""
                                    class="w-full mt-1 px-2 py-1 outline-none border-b-2 bg-slate-50 border-[#eaeaea] focus:border-b-2 focus:border-main">
                                    <option value="Dry Goods">Dry Goods</option>
                                    <option value="Wet Goods">Wet Goods</option>
                                    <option value="Groceries">Groceries</option>
                                    <option value="Meals">Meals</option>
                                    <option value="Limited Edition">Limited Edition</option>
                                </select>
                            </div>
                        </div>
                        <div class="w-full flex items-center justify-between gap-5">
                            <div class="w-1/2">
                                <label for="" class="text-gray-500">Product unit</label>
                                <select name="product_unit"
                                    class="w-full mt-1 px-2 py-1 outline-none border-b-2 bg-slate-50 border-[#eaeaea] focus:border-b-2 focus:border-main">
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
                                <input type="text" name="item_barcode"
                                    class="w-full mt-1 px-2 py-1 outline-none border-b-2 bg-slate-50 border-[#eaeaea] focus:border-b-2 focus:border-main"
                                    autofocus="false">
                            </div>
                        </div>
                    </div>
                    <div class=" bg-white rounded-md p-10">
                        <div class="w-full flex items-center justify-between gap-16 mb-10">
                            <div class="w-1/2">
                                <label for="" class="text-gray-500">Purchase Cost</label>
                                <input type="number" name="cost" step="any"
                                    class="w-full mt-1 px-2 py-1 outline-none border-b-2 bg-slate-50 border-[#eaeaea] focus:border-b-2 focus:border-main">
                            </div>
                            <div class="w-1/2">
                                <label for="" class="text-gray-500">Retail Value</label>
                                <input type="number" name="retail"
                                    class="w-full mt-1 px-2 py-1 outline-none border-b-2 bg-slate-50 border-[#eaeaea] focus:border-b-2 focus:border-main">
                            </div>
                        </div>
                        <div class="w-ful flex gap-16">
                            <div class="w-1/2">
                                <label for="item_image" class="text-gray-500 block mb-2">Change Item Image</label>
                                <div class="items-center space-x-4">
                                    <!-- Image Preview -->
                                    <div
                                        class="w-32 h-32 bg-gray-100 border rounded-md overflow-hidden flex items-center justify-center">
                                        <img id="imagePreview" class="w-full h-full object-cover hidden"
                                            alt="Image Preview">
                                    </div>
                                    <!-- File Input -->
                                    <input type="file" name="item_image" id="item_image"
                                        class="mt-4 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                        accept="image/*" onchange="previewImage(event)">
                                </div>
                            </div>
                            <script>
                                function previewImage(event) {
                                    const input = event.target;
                                    const preview = document.getElementById('imagePreview');
    
                                    if (input.files && input.files[0]) {
                                        const reader = new FileReader();
    
                                        reader.onload = function(e) {
                                            preview.src = e.target.result;
                                            preview.classList.remove('hidden');
                                        };
    
                                        reader.readAsDataURL(input.files[0]);
                                    }
                                }
                            </script>
                           
                        </div>
                        <div class="w-1/2 flex gap-5 items-center justify-end">
                            <button type="button" id="submitButton"
                                class="w-[100px] bg-main uppercase rounded-sm py-2 shadow-md font-medium text-black text-xs">Add
                                Item</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('submitButton').addEventListener('click', function(event) {
            event.preventDefault(); // Prevent the default form submission
        
            // Form validation: Check required fields
            const itemName = document.querySelector('input[name="item_name"]').value.trim();
            // const itemQuantity = document.querySelector('input[name="item_quantity"]').value.trim();
            const errorMessage = [];
        
            if (!itemName) {
                errorMessage.push('Item Name is required.');
            }
            // if (!itemQuantity) {
            //     errorMessage.push('Item Quantity is required.');
            // }
        
            // Show error if validation fails
            if (errorMessage.length > 0) {
                Swal.fire({
                    title: "Error!",
                    text: errorMessage.join(" "),
                    icon: "error",
                    confirmButtonColor: "#d33",
                });
                return;
            }
        
            // If validation passes, show success popup only
            Swal.fire({
                title: "Success!",
                text: "Your item has been added successfully.",
                icon: "success",
                confirmButtonColor: "#3085d6",
            }).then(() => {
                // Submit the form after success
                document.getElementById('itemForm').submit(); // Submit the form
            });
        });
        
        document.addEventListener('DOMContentLoaded', function() {
            var qrInput = document.querySelector('input[name="item_qr"]');
        
            qrInput.addEventListener('keydown', function(event) {
                if (event.key === 'Enter') {
                    event.preventDefault(); // Prevent default Enter key behavior
                }
            });
        });
        
        var main = document.getElementById('main');
        
        function openInventoryOptions() {
            var inventoryOptions = document.getElementById('inventory_options');
            inventoryOptions.classList.toggle('hidden');
            main.classList.toggle('blur-5px');
        }
        
        function openDashboard() {
            var inventoryOptions = document.getElementById('dash_options');
            inventoryOptions.classList.toggle('hidden');
            main.classList.toggle('blur-5px');
        }
        
        function openItems() {
            var inventoryOptions = document.getElementById('items_options');
            inventoryOptions.classList.toggle('hidden');
            main.classList.toggle('blur-5px');
        }
    </script>
    
    
</body>

</html>
