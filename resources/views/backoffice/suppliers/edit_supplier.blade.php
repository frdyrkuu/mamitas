<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/5bf9be4e76.js" crossorigin="anonymous"></script>
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
    @vite('resources/css/app.css')
    <title>Back Office</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="w-full h-screen bg-[#fefefe]">
    <div class="w-full flex items-center h-[7%] bg-[#db121c] px-10">
        <p class="text-lg text-white">Update Supplier's Details</p>
    </div>
    <div class="w-full h-[93%] flex z-0">
        <div class="w-[5%] pt-10 bg-[#fefefe] mb-10">
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
                    class="w-full flex items-center justify-center h-auto py-4">
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
                <a href="{{ route('office.supplier') }}" class="w-full flex items-center justify-center h-auto py-4 bg-[#f5a7a4]">
                    <img src="{{ asset('images/supplier-red.png') }}" alt="" class="w-[30px] h-auto">
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
            <div class="w-1/2 flex mx-auto flex-col shadow-md text-sm">
                @if ($errors->any())
                    <div class="w-full p-4 mb-4 bg-red-100 border border-red-400 text-red-700 rounded">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if(session('error'))
                    <script>
                        document.addEventListener('DOMContentLoaded', function() {
                            Swal.fire({
                                title: "Error!",
                                text: "{{ session('error') }}",
                                icon: "error",
                                confirmButtonText: "OK"
                            });
                        });
                    </script>
                @endif

                <form action="{{ route('office.update_supplier_details', $supplier->id) }}" class="w-full" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class=" bg-white rounded-md p-10 mb-5">
                        {{-- Display Supplier Information --}}
                        <div class="w-full mb-10">
                            <label for="" class="text-gray-500">Supplier Information</label>
                            <div id="supplier-details" class="w-full mt-2 p-4 bg-gray-50 rounded-lg border border-[#eaeaea]">
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="text-sm text-gray-600">Name</label>
                                        <p id="supplier-name" class="font-medium">{{ $supplier->name }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm text-gray-600">Contact Person</label>
                                        <p id="supplier-contact-person" class="font-medium">{{ $supplier->contact_person }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm text-gray-600">Contact Number</label>
                                        <p id="supplier-contact-number" class="font-medium">{{ $supplier->contact_number }}</p>
                                    </div>
                                    <div>
                                        <label class="text-sm text-gray-600">Email</label>
                                        <p id="supplier-email" class="font-medium">{{ $supplier->email }}</p>
                                    </div>
                                    <div class="col-span-2">
                                        <label class="text-sm text-gray-600">Address</label>
                                        <p id="supplier-address" class="font-medium">{{ $supplier->address }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Edit Supplier Form --}}
                        <div class="w-full mb-10">
                            <label for="" class="text-gray-500">Edit Supplier</label>
                            <div class="w-full mt-2 p-4 bg-gray-50 rounded-lg border border-[#eaeaea]">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="space-y-2">
                                        <label for="suppliers_name">Supplier's Name</label>
                                        <input 
                                            type="text" 
                                            name="suppliers_name" 
                                            id="suppliers_name" 
                                            class="w-full rounded-md outline-none border border-[#bebebe] focus:border focus:border-main px-4 py-2"
                                            value="{{ $supplier->name }}"
                                        >
                                    </div>
                                    <div class="space-y-2">
                                        <label for="contact_person">Contact Person</label>
                                        <input 
                                            type="text" 
                                            name="contact_person" 
                                            id="contact_person" 
                                            class="w-full rounded-md outline-none border border-[#bebebe] focus:border focus:border-main px-4 py-2"
                                            value="{{ $supplier->contact_person }}"
                                        >
                                    </div>
                                    <div class="space-y-2">
                                        <label for="contact_number">Contact Number</label>
                                        <input 
                                            type="text" 
                                            name="contact_number" 
                                            id="contact_number" 
                                            class="w-full rounded-md outline-none border border-[#bebebe] focus:border focus:border-main px-4 py-2"
                                            value="{{ $supplier->contact_number }}"
                                        >
                                    </div>
                                    <div class="space-y-2">
                                        <label for="email">Email</label>
                                        <input 
                                            type="email" 
                                            name="email" 
                                            id="email" 
                                            class="w-full rounded-md outline-none border border-[#bebebe] focus:border focus:border-main px-4 py-2"
                                            value="{{ $supplier->email }}"
                                        >
                                    </div>
                                    <div class="col-span-2 space-y-2">
                                        <label for="address">Address</label>
                                        <textarea 
                                            name="address" 
                                            id="address" 
                                            class="w-full rounded-md outline-none border border-[#bebebe] focus:border focus:border-main px-4 py-2"
                                            rows="3"
                                        >{{ $supplier->address }}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class=" bg-white rounded-md p-10">

                        <div class="w-full gap-16">
                            <div class="w-full flex gap-5 items-center justify-center">
                                <button
                                    class="min-w-[50%] bg-main rounded-sm py-2 shadow-md font-medium text-white">Save</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @if (session('success'))
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                Swal.fire({
                    title: "Success!",
                    text: "{{ session('success') }}",
                    icon: "success",
                    confirmButtonText: "OK"
                });
            });
        </script>
    @endif

</body>

</html>
