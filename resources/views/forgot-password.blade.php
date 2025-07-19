<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>تحقق بريد الكتروني - احجز فندق</title>
  <link rel="stylesheet" href="css/verfayemail.css">
  <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet" />
</head>
<body>
    <div class="container">
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    </div>

  <div class="forgot-container">
    <div class="forgot-header">
      <h1 class="forgot-title">نسيت كلمة المرور</h1>
      <p class="forgot-subtitle">أدخل بريدك الإلكتروني لإعادة تعيين كلمة المرور</p>
    </div>

    <form id="forgotForm" method="POST" action="{{ route('password.email') }}">
    @csrf
    <div class="form-group">
            <label>البريد الإلكتروني</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

      <button type="submit" class="next-button">التالي</button>

      <p class="back-link">تذكرت كلمة المرور؟ <a href="{{route('login')}}">العودة لتسجيل الدخول</a></p>
    </form>
  </div>

   <!-- <script>
    document.getElementById('forgotForm').addEventListener('submit', function(e) {
  e.preventDefault();

  const emailInput = document.getElementById('email');
  emailInput.setCustomValidity(''); // مسح رسالة الخطأ السابقة

  // تحقق من الحقل فارغ
  if (!emailInput.value.trim()) {
    emailInput.setCustomValidity("يرجى ملء هذا الحقل.");
  } else if (!emailInput.checkValidity()) { // تحقق من صحة الايميل
    emailInput.setCustomValidity("يرجى إدخال بريد إلكتروني صالح.");
  }

  // إذا هناك رسالة خطأ نعرضها ونوقف الإرسال
  if (!emailInput.checkValidity()) {
    emailInput.reportValidity();
    return;
  }

  // إذا التحقق ناجح ننتقل للصفحة التالية
  window.location.href = "./انشاء كلمة مرور جديدة.html";
});

  </script> -->
</body>
</html>
