<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <title>التحقق من البريد الإلكتروني</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .verification-card {
            max-width: 400px;
            margin: 100px auto;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="card verification-card shadow-sm">
        <div class="card-body">
            <h4 class="card-title mb-3 text-center">التحقق من البريد الإلكتروني</h4>

            @if(session('error'))
                <div class="alert alert-danger text-center">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('verify.code.submit') }}" method="POST">
                @csrf
                <input type="hidden" name="email" value="{{ $email }}">

                <div class="mb-3">
                    <label for="code" class="form-label">رمز التحقق</label>
                    <input type="text" name="code" id="code" class="form-control @error('code') is-invalid @enderror" required>

                    @error('code')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-100">تحقق</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
