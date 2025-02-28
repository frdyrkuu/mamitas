<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-[#fefef8] h-screen mx-auto">

    <!-- Hero -->
    <div class="relative overflow-hidden">
        <div class="max-w-[85rem] mx-auto px-4 sm:px-6 lg:px-8 py-10 sm:py-24">
            <div class="text-center">
                <p class="mt-3 text-gray-600 font-bold">
                    Admin Forgot password </p>
                <h1 class="text-4xl sm:text-6xl font-bold text-gray-800">
                    Forgot Password?
                </h1>

                <p class="mt-3 text-gray-600">
                    Enter your email associated with your admin account.
                </p>

                <div class="mt-7 sm:mt-12 mx-auto max-w-xl relative">
                    <!-- Form -->
                    <!-- Form -->
                    <form action="{{ route('office.forgotAdmin') }}" method="POST" id="myForm">
                        @csrf
                        <div
                            class="relative z-10 flex gap-x-3 p-3 bg-white border rounded-lg shadow-lg shadow-gray-100">
                            <div class="w-full">
                                <label for="hs-search-article-1" class="block text-sm text-gray-700 font-medium"><span
                                        class="sr-only">Enter Email</span></label>
                                <input type="email" name="email" id="hs-search-article-1"
                                    class="py-2.5 px-4 block w-full border-transparent rounded-lg focus:border-blue-500 focus:ring-blue-500"
                                    placeholder="Enter email">
                            </div>
                            <div>
                                <button type="submit"
                                    class="size-[46px] inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">
                                    <svg class="shrink-0 size-5" xmlns="http://www.w3.org/2000/svg" width="24"
                                        height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8" />
                                        <path d="m21 21-4.3-4.3" />
                                    </svg>
                                </button>
                            </div>
                        </div>

                    </form>
                    <br>
                    <div class="whitespace-nowrap pt-2 sm:pt-0 grid sm:block">
                        <a class="py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none"
                            href="/">
                            Return Home
                        </a>
                    </div>
                    <!-- End Form -->

                    <script>
                        // Check if the value is '1' (Email Sent)
                        @if ($value == '1')
                            // Trigger SweetAlert when the value is '1'
                            Swal.fire({
                                title: 'Success!',
                                text: 'The email has been sent successfully.',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Redirect to the homepage when OK is clicked
                                    window.location.href = '/';
                                }
                            });
                        @endif

                        @if ($value == '2')
                            // Trigger SweetAlert when the value is '1'
                            Swal.fire({
                                title: 'Oops!',
                                text: 'The email has been not associated with the admin email.',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Redirect to the homepage when OK is clicked
                                    window.location.href = '/back-office/login';
                                }
                            });
                        @endif
                    </script>


                    <!-- SVG Element -->
                    <div class="hidden md:block absolute top-0 end-0 -translate-y-12 translate-x-20">
                        <svg class="w-16 h-auto text-orange-500" width="121" height="135" viewBox="0 0 121 135"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M5 16.4754C11.7688 27.4499 21.2452 57.3224 5 89.0164" stroke="currentColor"
                                stroke-width="10" stroke-linecap="round" />
                            <path d="M33.6761 112.104C44.6984 98.1239 74.2618 57.6776 83.4821 5" stroke="currentColor"
                                stroke-width="10" stroke-linecap="round" />
                            <path d="M50.5525 130C68.2064 127.495 110.731 117.541 116 78.0874" stroke="currentColor"
                                stroke-width="10" stroke-linecap="round" />
                        </svg>
                    </div>
                    <!-- End SVG Element -->

                    <!-- SVG Element -->
                    <div class="hidden md:block absolute bottom-0 start-0 translate-y-10 -translate-x-32">
                        <svg class="w-40 h-auto text-cyan-500" width="347" height="188" viewBox="0 0 347 188"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M4 82.4591C54.7956 92.8751 30.9771 162.782 68.2065 181.385C112.642 203.59 127.943 78.57 122.161 25.5053C120.504 2.2376 93.4028 -8.11128 89.7468 25.5053C85.8633 61.2125 130.186 199.678 180.982 146.248L214.898 107.02C224.322 95.4118 242.9 79.2851 258.6 107.02C274.299 134.754 299.315 125.589 309.861 117.539L343 93.4426"
                                stroke="currentColor" stroke-width="7" stroke-linecap="round" />
                        </svg>
                    </div>
                    <!-- End SVG Element -->
                </div>

            </div>
        </div>
    </div>
    <!-- End Hero -->


</body>

</html>
