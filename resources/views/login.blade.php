<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <link rel="stylesheet" href="{{ asset('css/login.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset ('bootstrap-5.3.7-dist/css/bootstrap.min.css')}}">
</head>
<body>
    <div class="login-container">
        <h1>مرحباً بعودتك</h1>
        <p class="subtitle">سجل الدخول للوصول إلى حسابك</p>

        <form id="loginForm" action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">البريد الإلكتروني</label>
                <input type="email" name="email"  class="form-control @error('email') is-invalid @enderror"  id="email" value="{{old('email')}}"  placeholder="أدخل بريدك الإلكتروني">
                @error('email')
                <small class="text-danger">
                    {{ $message }}
                </small>
                @enderror
            </div>

            <div class="form-group">
                <div class="password">
                    <label for="password">كلمة المرور</label>
                    <input type="password" class="form-control passwordinput @error('password') is-invalid @enderror" name="password" value="{{old('password')}}"  id="password" placeholder="أدخل كلمة المرور">
                    <i class="fa fa-eye"></i>
                </div>
                @error('password')
                <small class="text-danger">
                    {{ $message }}
                </small>
                @enderror


                <br>
                <a href="{{ route('password.request') }}">هل نسيت كلمة المرور؟</a>
                <br>
                <br>

            <button type="submit" class="next-button">التالي</button>

            <p class="register-link">ليس لديك حساب؟ <a href="{{route('showregisterpage')}}">سجل الآن</a></p>
            <p class="register-link">صاحب عمل؟ <a href="{{route('hotel_owner.register')}}">تسجيل حساب كصاحب فندق</a></p>

            <div class="account-type">نوع الحساب: ضيف</div>
        </form>
    </div>


    <script src="{{asset('js/custtom.js')}}"></script>
    <!-- <script>
        document.getElementById('loginForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const email = document.getElementById('email').value.trim();
            const password = document.getElementById('password').value.trim();

            if (email === "" || password === "") {
                alert("يرجى تعبئة البريد الإلكتروني وكلمة المرور.");
            } else {

                window.location.href = "./احجز فندق الرئيسية.html";
            }
        });
    </script> -->
</body>
</html>