<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Admin Password</title>

    @vite('resources/css/app.css')
    {{-- <link rel="stylesheet" href="https://preline.co/assets/css/main.min.css?v=1.0.0"> --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="bg-[#fefef8]">
    <main class="max-w-xl py-20 items-center mx-auto h-screen justify-center">
        <div class="mt-7 bg-white border border-gray-200 rounded-xl shadow-sm">
            <div class="p-4 sm:p-7">
                <div class="text-center">
                    <a href="/"> <img src="{{ asset('images/logo-transparent.png') }}" alt="Mamitas Logo"
                            class="w-20 h-20 mx-auto">
                    </a>
                    <h1 class="block text-2xl font-bold text-gray-800">Reset Password</h1>
                </div>

                <div class="mt-5">
                    <div
                        class="py-3 flex items-center text-xs text-gray-400 uppercase before:flex-1 before:border-t before:border-gray-200 before:me-6 after:flex-1 after:border-t after:border-gray-200 after:ms-6">
                    </div>
                    <!-- Form -->
                    <form method="POST" action="{{ route('office.resetPassword') }}" id="change-password-form">
                        @csrf
                        <div class="grid gap-y-4">
                            <!-- Form Group -->
                            {{-- email --}}
                            <div>
                                <label for="Email" class="block text-sm mb-2">Admin Email</label>
                                <div class="relative">
                                    <input type="email" id="email" name="adminEmail"
                                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-red-500 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none"
                                        required aria-describedby="email-error" required />
                                </div>
                            </div>
                            <div>
                                <label for="new_password" class="block text-sm mb-2">New Password</label>
                                <div class="relative">
                                    <input type="password" id="new_password" name="newPassword"
                                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-red-500 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none"
                                        required aria-describedby="email-error" required />

                                    <span class="text-xs font-semibold text-red-500">
                                        @if (isset($returnAuth) && $returnAuth)
                                            {{ $returnAuth }}
                                        @endif
                                    </span>

                                </div>
                            </div>
                            <!-- End Form Group -->

                            <!-- Form Group -->
                            <div>
                                <div class="flex justify-between items-center">
                                    <label for="password" class="block text-sm mb-2">Confirm Password</label>
                                </div>
                                <div class="relative">
                                    <input type="password" id="password" name="confirmPassword"
                                        class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-red-500 focus:ring-red-500 disabled:opacity-50 disabled:pointer-events-none"
                                        required aria-describedby="password-error" required />
                                </div>
                            </div>
                            <!-- End Form Group -->

                            <button type="submit" id="confirm-submit"
                                class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-medium rounded-lg border border-transparent bg-red-600 text-white hover:bg-red-700 focus:outline-none focus:bg-red-700 disabled:opacity-50 disabled:pointer-events-none">
                                Sign in
                            </button>
                        </div>
                    </form>

                    <script>
                        document.getElementById('confirm-submit').addEventListener('click', function(event) {
                            const newPassword = document.getElementById('new_password').value.trim();
                            const confirmPassword = document.getElementById('password').value.trim();

                            // Validate input fields
                            if (!newPassword || !confirmPassword || !email) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Please input all given fields!',
                                });
                                return; // Stop form submission
                            }

                            if (newPassword.length < 8) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'The new password must be at least 8 characters long!',
                                });
                                return; // Stop form submission
                            }

                            if (newPassword !== confirmPassword) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Passwords do not match!',
                                });
                                return; // Stop form submission
                            }

                            // If all validations pass, show the confirmation dialog
                            Swal.fire({
                                title: 'Are you sure?',
                                text: 'You are about to change the admin password!',
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#d33',
                                cancelButtonColor: '#3085d6',
                                confirmButtonText: 'Yes, proceed!',
                                cancelButtonText: 'No, cancel',
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Submit the form programmatically
                                    document.getElementById('change-password-form').submit();
                                }
                            });
                        });

                        // Check for success message after form submission
                        @if (session('success'))
                            Swal.fire({
                                icon: 'success',
                                title: 'Password Updated',
                                text: '{{ session('success') }}',
                            });
                        @endif
                    </script>
                
                    @if (session('success'))
                        <script>
                            Swal.fire({
                                title: 'Success!',
                                text: '{{ session('success') }}',
                                icon: 'success',
                                confirmButtonText: 'OK'
                            });
                        </script>
                    @endif

                    @if (session('error'))
                        <script>
                            Swal.fire({
                                title: 'Error!',
                                text: '{{ session('error') }}',
                                icon: 'error',
                                confirmButtonText: 'OK'
                            });
                        </script>
                    @endif



                    <!-- End Form -->
                </div>
            </div>
        </div>
    </main>

</body>

</html>
