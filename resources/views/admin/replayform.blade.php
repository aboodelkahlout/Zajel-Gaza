<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>رد على التعليق</title>

    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('bootstrap-5.3.7-dist/css/bootstrap.min.css') }}">

    <style>
        body {
            font-family: 'Tajawal', sans-serif;
            background-color: #f8f9fa;
            padding: 30px;
        }

        .card {
            border-radius: 15px;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        .form-label {
            font-weight: 600;
        }

        .comment-box {
            background-color: #f1f1f1;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        h2 {
            margin-bottom: 25px;
            color: #0d6efd;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4">
                <h2 class="text-center">رد على التعليق</h2>

                <div class="comment-box">
                    <strong>التعليق:</strong><br>
                    {{ $comment->comment }}
                </div>

                <form method="POST" action="{{ route('admin.commentssaveReply', $comment->id) }}">
                    @csrf
                    <div class="mb-3">
                        <label for="reply_text" class="form-label">نص الرد</label>
                        <textarea name="reply_text" id="reply_text" rows="4" class="form-control" required>{{ old('reply_text', $comment->reply->reply_text ?? '') }}</textarea>
                    </div>

                    <div class="text-end">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-paper-plane"></i> إرسال الرد
                        </button>
                        <button type="button" class="btn btn-secondary" onclick="history.back();">
                        رجوع <i class="fas fa-arrow-left me-2"></i></button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<script src="{{ asset('bootstrap-5.3.7-dist/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
