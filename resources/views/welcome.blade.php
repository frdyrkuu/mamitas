<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="image/x-icon">
    <title>Cashier Login</title>
</head>

<body class="relative h-screen bg-[#7e817f]">
    <div id="resetPass"
        class="hidden w-1/4 h-fit absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-white shadow-xl rounded-xl p-6 z-50">
        <p class="text-center text-xl font-medium mb-6">Forgot password</p>
        <div class="w-full">
            <form action="{{ route('reset_password') }}" method="POST" class="mb-2">
                @csrf
                <label for="Username" class="text-main">*Cashier Name</label>
                <input type="text" name="username"
                    class="w-full px-6 py-2 rounded-md outline-none border border-[#565857] mb-4">
                <button class="w-full py-2 border-2 border-main text-main rounded-lg">Continue</button>
            </form>
            <button onclick="closeDiv()" class="block mx-auto text-sm underline text-main">Cancel</button>
        </div>
    </div>
    <div id="main"
        class="w-3/4 h-[80%] flex p-6 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#fefef8] rounded-3xl shadow-md backdrop-blur-sm border border-opacity-20">
        <div class="w-[60%] relative">
            <img src="{{ asset($cms->company_logo) }}" alt=""
                class="w-[80%] absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
        </div>
        <div class="w-[40%] flex flex-col justify-center">
            @if ($errors->has('error'))
                <div class="w-full bg-[#d14646] px-4 py-2 flex items-center gap-4 rounded-md mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="14" height="14"
                        fill="red"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path
                            d="M256 32c14.2 0 27.3 7.5 34.5 19.8l216 368c7.3 12.4 7.3 27.7 .2 40.1S486.3 480 472 480H40c-14.3 0-27.6-7.7-34.7-20.1s-7-27.8 .2-40.1l216-368C228.7 39.5 241.8 32 256 32zm0 128c-13.3 0-24 10.7-24 24V296c0 13.3 10.7 24 24 24s24-10.7 24-24V184c0-13.3-10.7-24-24-24zm32 224a32 32 0 1 0 -64 0 32 32 0 1 0 64 0z" />
                    </svg>
                    <p class="text-white">{{ $errors->first('error') }}</p>
                </div>
            @endif
            @if (session('success'))
                <div class="w-full bg-[#28a745] px-4 py-2 flex items-center gap-4 rounded-md mb-2">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" width="14" height="14"
                        fill="green"><!--!Font Awesome Free 6.5.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path
                            d="M173.898 439.404l-166.4-166.4c-7.8-7.8-7.8-20.4 0-28.2s20.4-7.8 28.2 0L192 397.898 477.3 112.604c7.8-7.8 20.4-7.8 28.2 0s7.8 20.4 0 28.2l-320 320c-7.8 7.8-20.4 7.8-28.2 0z" />
                    </svg>
                    <p class="text-white">{{ session('success') }}</p>
                </div>
            @endif
            <div class="w-full flex justify-between">
                <p class="text-xl font-semibold mb-4 text-[#3f3f3f]">Login your Account</p>
                <a href="{{ route('office.login') }}" class="text-main underline">Login as
                    Admin<a />
                    <a href="{{ route('register') }}" class="text-main underline">Create account</a>
            </div>
            <form action="{{ route('auth_login') }}" method="POST" class="">
                @csrf
                <span class="w-full border-b border-[#d3d3d3] block mx-auto pt-4 mb-4"></span>
                <div class="w-full flex flex-col gap-1 mb-3">
                    <label for="">Cashier Name</label>
                    <input type="text" name="name"
                        class="w-full p-2 outline-none rounded-md border border-[#727272] focus:border focus:border-main">
                </div>
                <div class="w-full flex flex-col gap-1 mb-1">
                    <label for="">Password</label>
                    <div class="relative">
                        <img id="eyeOpen" src="{{ asset('images/eye.png') }}" alt=""
                            class="w-[4%] absolute right-3 top-1/2 transform -translate-y-1/2 hover:cursor-pointer">
                        <input id="pass" type="password" name="password"
                            class="w-full p-2 outline-none rounded-md border border-[#727272] focus:border focus:border-main">
                    </div>
                </div>
                <input type="hidden" name="role" value="cashier">
                <div class="mb-4">
                    <a class="underline" onclick="forgotPassword(event)">Forgot Password?</a>
                </div>
                <button
                    class="w-full rounded-md py-2 text-main border border-main hover:bg-main hover:text-white ease-in-out duration-100">
                    Login
                </button>
            </form>
        </div>
    </div>
    <script>
        var toggleOpen = document.getElementById('eyeOpen')
        var pass = document.getElementById('pass')

        toggleOpen.addEventListener('click', function() {
            if (pass.type === 'password') {
                pass.type = 'text';
                toggleOpen.src = "{{ asset('images/eye-inv.png') }}";
            } else {
                pass.type = 'password';
                toggleOpen.src = "{{ asset('images/eye.png') }}";
            }
        })

        function forgotPassword(event) {
            event.preventDefault();
            let fPassDiv = document.getElementById('resetPass')
            let main = document.getElementById('main')

            fPassDiv.classList.remove('hidden')
            main.style.filter = 'blur(5px)'
        }

        function closeDiv() {
            let fPassDiv = document.getElementById('resetPass')
            let main = document.getElementById('main')
            fPassDiv.classList.add('hidden')
            main.style.filter = 'blur(0px)'
        }
    </script>
</body>

</html>
