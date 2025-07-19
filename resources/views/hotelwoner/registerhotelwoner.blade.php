<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>انشاء حساب  صاحب فندق</title>
    <link rel="stylesheet" href="{{ asset('css/createaccountforuser.css')}}">
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{asset('bootstrap-5.3.7-dist/css/bootstrap.min.css')}}">
</head>
<body>
    <div class="register-container">
        <div class="register-header">
            <h1 class="register-title">مرحبًا بعودتك</h1>
            <p class="register-subtitle">هل انت صاحب فندق سجل حسابك الان!</p>
        </div>

        <form id="registerForm" action="{{ route('registerhotelowner') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="fullname">الاسم الكامل</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" id="fullname" value="{{old('name')}}" placeholder="أدخل اسمك الكامل">
                            @error('name')
                  <small class="text-danger">
                    {{ $message }}
                </small>
                 @enderror
            </div>

            <div class="form-group">
                <label for="email">البريد الإلكتروني</label>
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{old('email')}}" id="email" placeholder="أدخل بريدك الإلكتروني">
                @error('email')
                  <small class="text-danger">
                    {{ $message }}
                </small>
                 @enderror
            </div>

            <div class="form-group">
                <label for="phone"> رقم التيلفون</label>
                <input type="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" value="{{old('phone')}}" id="phone" placeholder="رقم التيلفون">
                @error('phone')
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
                <div class="passwordconfirm">
                    <label for="confirm-password">تأكيد كلمة المرور</label>
                    <input type="password" name="password_confirmation" class="form-control passwordconfirminput @error('password_confirmation') is-invalid @enderror" value="{{old('password_confirmation')}}" id="confirm-password" placeholder="أعد إدخال كلمة المرور">
                    <i class="fa fa-eye"></i>
                    @error('password_confirmation')
                   <small class="text-danger">
                    {{ $message }}
                </small>
                   @enderror
                </div>
            </div>

            <button id="nextButton" class="next-button">التالي</button>

            <p class="login-link">لديك حساب بالفعل؟ <a href="{{route('login')}}">سجل الدخول</a></p>

        </form>
    </div>

    <script src="{{asset('js/custtom.js')}}"></script>
    <script src="{{asset('bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js')}}"></script>
    <!-- <script>
        const nextButton = document.getElementById('nextButton');
        const registerForm = document.getElementById('registerForm');

        nextButton.addEventListener('click', () => {
            if (registerForm.checkValidity()) {
                window.location.href = "./احجز فندق الرئيسية.html";
            } else {
                registerForm.reportValidity();
            }
        });
    </script> -->
</body>
</html>
