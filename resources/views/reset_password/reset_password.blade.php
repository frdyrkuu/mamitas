<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="{{ asset('jquery/jquery.js') }}"></script>
  @vite('resources/css/app.css')
</head>
<body class="relative h-screen bg-[#7e817f]">
  <div class="w-3/4 h-[80%] flex p-6 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 bg-[#fefef8] rounded-3xl shadow-md backdrop-blur-sm border border-opacity-20">
    <div class="w-[60%] relative">
      <img src="{{asset('images/new_logo.png')}}" alt="" class="w-[80%] absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2">
    </div>
    <div class="w-[40%] flex flex-col justify-center">
        <p class="text-2xl font-semibold mb-4 text-[#3f3f3f]">Reset your account's password</p>
        <form action="{{route("change_password")}}" method="POST">
            @csrf
            <div class="w-full flex flex-col gap-1 mb-1">
                <label for="">New Password</label>
                <div class="relative">
                    <img id="eyeOpen" src="{{asset('images/eye.png')}}" alt="" class="w-[4%] absolute right-3 top-1/2 transform -translate-y-1/2 hover:cursor-pointer">
                    <input id="pass" type="password" name="confirm_password" class="w-full p-2 outline-none rounded-md border border-[#727272] focus:border focus:border-main">
                </div>
                <div class="w-full flex flex-col gap-1">
                    <label for="">Confirm Password</label>
                    <input id="confirmPass" type="password" name="new_password" class="w-full p-2 outline-none rounded-md border border-[#727272] focus:border focus:border-main">
                </div>
            </div>
            <p id="warning" class="text-red text-xs mb-3"></p>
            @foreach ($cashier as $c)
                <input type="hidden" name="name" value="{{$c->name}}">
            @endforeach
            <button id="saveButton" disabled class="w-full rounded-md py-2 bg-gray-500 text-white">
                Save
            </button>
            {{-- text-main border border-main hover:bg-main hover:text-white ease-in-out duration-100 --}}
        </form>
    </div>
  </div>
  <script>
      var toggleOpen = document.getElementById('eyeOpen')
      var pass = document.getElementById('pass')

      toggleOpen.addEventListener('click', function(){
        if (pass.type === 'password') {
          pass.type = 'text';
          toggleOpen.src = "{{asset('images/eye-inv.png')}}";
        } else {
          pass.type = 'password';
          toggleOpen.src = "{{asset('images/eye.png')}}";
        }
      })

      $(document).ready(function() {
        function checkPasswordMatch() {
            var password = $("#pass").val();
            var confirmPassword = $("#confirmPass").val();

            if (!password || !confirmPassword) {
                $("#warning").text("One of the fields is empty");
                $("#saveButton").attr('disabled', true).removeClass('bg-main').addClass('bg-gray-500');
            } else if(password !== confirmPassword){
                $("#warning").text("Password doesn't match");
                $("#saveButton").attr('disabled', true).removeClass('bg-main').addClass('bg-gray-500');
            } else {
                $("#warning").text("");
                $("#saveButton").attr('disabled', false).removeClass('bg-gray-500').addClass('bg-main');
            }
        }

        $("#pass, #confirmPass").on('keyup', checkPasswordMatch);
    });

  </script>
</body>
</html>