<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/5bf9be4e76.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    @vite('resources/css/app.css')
    <title>Content Management</title>
</head>

<body class="w-full h-auto bg-[#fefefe]">
    <div class="w-full flex items-center h-[60%] bg-[#db121c] px-10 py-5 gap-10">
        <a href="/back-office/dashboard" class="text-lg text-white">Go to Dashboard</a>
        <p class="text-lg text-white">Content Management</p>
    </div>
    <div class="w-full h-screen  flex z-0">

        <div class=" bg-[#f2f2f2] z-0 p-7 w-full">
            <div class="w-1/2 flex mx-auto shadow-md text-sm">
                <form action="{{ route('office.cms') }}" class="w-full" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class=" bg-white rounded-md p-10 mb-5">
                        <div class="flex justify-between">
                            <img class="h-[200px] max-w-full rounded-md mb-10" src="{{ asset($name->company_logo) }}"
                                alt="Company Logo">

                            <div class="w-1/2">
                                <label for="item_image" class="text-gray-500 block mb-2">Change Logo</label>
                                <div class="items-center space-x-4">
                                    <!-- Image Preview -->
                                    <div
                                        class="w-32 h-32 bg-gray-100 border rounded-md overflow-hidden flex items-center justify-center">
                                        <img id="imagePreview" class="w-full h-full object-cover hidden"
                                            alt="Image Preview">
                                    </div>
                                    <!-- File Input -->
                                    <input type="file" name="company_logo" id="item_image"
                                        class="mt-4 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                                        accept="image/*" onchange="previewImage(event)">
                                </div>
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

                        <div class="w-full flex items-center justify-between gap-5 mb-10">
                            <div class="w-1/2">
                                <label for="" class="text-gray-500">Item Name</label>
                                <input type="text" name="company_name" value="{{ $name->company_name }}"
                                    class="w-full mt-1 px-2 py-1 outline-none border-b-2 bg-slate-50 border-[#eaeaea] focus:border-b-2 focus:border-main"
                                    required>
                            </div>
                        </div>
                        <div class="w-full flex items-center justify-between gap-5 mb-10">
                            <div class="w-full">
                                <label for="" class="text-gray-500">Description</label>
                                <textarea id="message" rows="4" name="company_description"
                                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500"
                                    placeholder="Write your product description here...">{{ $name->company_description }}</textarea>
                            </div>
                        </div>
                    </div>
                    <div class=" bg-white rounded-md p-10">
                        <div class="w-full gap-16">
                            <div class="w-full flex gap-5 items-center justify-center">
                                <button
                                    class="w-[400px] bg-main rounded-sm py-2 shadow-md font-medium text-white">Upload</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- 
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
    @endif --}}

</body>

</html>
