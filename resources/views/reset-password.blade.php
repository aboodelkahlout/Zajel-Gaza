<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>كلمة مرور جديدة - احجز فندق</title>
    <link rel="stylesheet" href="{{ asset('css/createnewpassword.css')}}">

    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset ('bootstrap-5.3.7-dist/css/bootstrap.min.css')}}">


    <style>
    .password{
        position: relative;
    }

    .password i{
        position: absolute;
    left: 13px;
    top: 48px;
}

.password i:hover{
cursor:pointer;
}


.secounddivpassword{
    position: relative;
}



.secounddivpassword i{
    position: absolute;
    left: 13px;
    top: 48px;
}

.secounddivpassword i:hover{
    cursor: pointer;
}

    </style>


</head>
<body>
    <div class="password-container">
        <div class="password-header">
            <h1 class="password-title">كلمة مرور جديدة</h1>
            <p class="password-subtitle">قم بإنشاء كلمة مرور جديدة لحسابك</p>
        </div>

        <form id="passwordForm" method="POST" action="{{ route('password.update') }}">
        @csrf

           <input type="hidden" name="token" value="{{ $token }}">
           <input type="hidden" name="email" value="{{ $email }}">
            <div class="form-group password">
                <label for="new-password">كلمة المرور الجديدة</label>
                            <input type="password" name="password"   id="new-password" class="password-input" placeholder="أدخل كلمة المرور الجديدة">
                            <i class="fa fa-eye"></i>
                            @error('password')
                             <small class="text-danger">
                              {{ $message }}
                             </small>
                              @enderror
                <div class="password-strength">
                    <div class="strength-meter" id="strengthMeter"></div>
                </div>
            </div>

            <div class="form-group secounddivpassword">
                <label for="confirm-password">تأكيد كلمة المرور</label>
                <input type="password" id="confirm-password" name="password_confirmation" class="password_confirmation password-input" placeholder="أعد إدخال كلمة المرور الجديدة">
                <i class="fa fa-eye"></i>
            </div>

            <div class="password-requirements">
                <p>يجب أن تحتوي كلمة المرور على:</p>
                <div class="requirement">8 أحرف على الأقل</div>
                <div class="requirement">حرف كبير واحد على الأقل</div>
                <div class="requirement">رقم واحد على الأقل</div>
                <div class="requirement">رمز خاص واحد على الأقل (!@#$%^&*)</div>
            </div>

            <button type="submit" class="btn btn-success mt-2">تحديث كلمة المرور</button
            </form>
    </div>

   <script>
  // متابعة قوة كلمة المرور
  const passwordInput = document.getElementById('new-password');
  const strengthMeter = document.getElementById('strengthMeter');
  const passwordForm = document.getElementById('passwordForm');

  passwordInput.addEventListener('input', function() {
    const password = this.value;
    let strength = 0;

    // التحقق من الطول
    if (password.length >= 8) strength += 25;
    if (password.length >= 12) strength += 15;

    // التحقق من الأحرف الكبيرة
    if (/[A-Z]/.test(password)) strength += 20;

    // التحقق من الأرقام
    if (/[0-9]/.test(password)) strength += 20;

    // التحقق من الرموز الخاصة
    if (/[!@#$%^&*]/.test(password)) strength += 20;

    // تحديث مقياس القوة
    strengthMeter.style.width = strength + '%';

    // تغيير اللون حسب القوة
    if (strength < 40) {
      strengthMeter.style.backgroundColor = '#e74c3c'; // أحمر
    } else if (strength < 70) {
      strengthMeter.style.backgroundColor = '#f39c12'; // برتقالي
    } else {
      strengthMeter.style.backgroundColor = '#2ecc71'; // أخضر
    }
  });

  // التحقق من تطابق كلمتي المرور قبل الإرسال
//   passwordForm.addEventListener('submit', function(e) {
//     e.preventDefault();  // منع الإرسال الافتراضي أولاً

//     const password = document.getElementById('new-password').value;
//     const confirmPassword = document.getElementById('confirm-password').value;

//     if (password !== confirmPassword) {
//       alert('كلمتا المرور غير متطابقتين!');
//       return; // توقف هنا ولا تتابع
//     }

//     // إذا تطابقت، الانتقال لصفحة تسجيل الدخول
//     window.location.href = './تسجيل الدخول.html';
//   });


let icon=document.querySelector('.password i');
let passwordinput=document.querySelector('.password-input');
var click=0;
icon.onclick=()=>{

    if (passwordinput.type=="password") {
        passwordinput.type="text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    }else{
        passwordinput.type="password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }

}


let secoundicon=document.querySelector('.secounddivpassword i');
let secoundpasswordinput=document.querySelector('.secounddivpassword input');
secoundicon.onclick=()=>{
    if (secoundpasswordinput.type=="password") {
        secoundpasswordinput.type="text";
        secoundicon.classList.remove("fa-eye");
        secoundicon.classList.add('fa-eye-slash');
    }else{
        secoundpasswordinput.type="password";
        secoundicon.classList.remove("fa-eye-slash");
        secoundicon.classList.add('fa-eye');
    }
}




</script>

</body>
</html>