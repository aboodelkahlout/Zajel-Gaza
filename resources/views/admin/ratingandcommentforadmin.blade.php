<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة التحكم - إدارة التقييمات والتعليقات</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{asset('bootstrap-5.3.7-dist/css/bootstrap.min.css')}}">
        <link rel="stylesheet" href="{{asset('css/ratingsandcommentsforadmin.css')}}">
</head>
<body>
    <div class="dashboard">
            <!-- Sidebar -->
            <div class="sidebar" id="sidebar">
                <div class="sidebar-header">
                    <h3>لوحة التحكم</h3>
                    <button class="toggle-sidebar" id="toggleSidebar">
                        <i class="fas fa-bars"></i>
                    </button>
                </div>
                <div class="sidebar-menu">
                @include('admin.layout')
            </div>
        </div>

        <!-- المحتوى الرئيسي -->
        <div class="main-content">
            <div class="header">
                <h1>التقييمات والتعليقات</h1>
            </div>



            <!-- قائمة التعليقات -->
            <h1>إدارة التعليقات والتقييمات</h1>

            @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif



@foreach($comments as $comment)
    <div class="review-item" style="border: 1px solid #ccc; padding: 15px; margin-bottom: 15px;">
        <div class="review-header" style="display: flex; justify-content: space-between;">
            <div class="review-user" style="display: flex; align-items: center;">
                <div class="user-avatar" style="margin-right: 10px;">
                    <img src="https://via.placeholder.com/40" alt="صورة المستخدم">
                </div>
                <div>
                    <div class="user-name">{{ $comment->user->name }}</div>
                    <div class="review-date">
                        <i class="fas fa-hotel" style="color: #34495e; margin-left: 5px;"></i>
                        {{ $comment->hotel->name }}
                    </div>
                </div>
            </div>

            <div class="review-rating">
                @php
                    $rating = $comment->hotel->ratings->where('user_id', $comment->user_id)->first();
                    $stars = $rating ? $rating->rating : 0;
                @endphp

                @for ($i = 0; $i < 5; $i++)
                    @if ($i < $stars)
                        <i class="fas fa-star" style="color: gold;"></i>
                    @else
                        <i class="far fa-star" style="color: gold;"></i>
                    @endif
                @endfor
            </div>
        </div>

        <div class="review-text" style="margin-top: 10px;">
            {{ $comment->comment }}
        </div>

        <div class="review-actions" style="margin-top: 10px;">

            <form action="{{ route('admin.destroycomment', $comment->id) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="action-btn delete-btn" onclick="return confirm('هل أنت متأكد من حذف التعليق؟')">
                    <i class="fas fa-trash"></i> حذف
                </button>
            </form>
        </div>


        @if($comment->reply)
        @foreach ( $comment->reply as $reply )
    <div class="review-reply" style="margin-top: 10px; background: #f9f9f9; padding: 10px; border-right: 3px solid #2980b9;">
        <div class="reply-header" style="font-weight: bold; margin-bottom: 5px;">
            رد صاحب الفندق
        <span class="review-date" style="float: left;">{{ $reply->created_at->format('d-m-Y') }}</span>
        </div>
        <div class="review-text">
            {{ $reply->reply_text }}
        </div>
    </div>
    @endforeach
    @endif
</div>

@endforeach
            <!-- ترقيم الصفحات -->
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script>
        // JavaScript for toggling sidebar
        document.addEventListener('DOMContentLoaded', function() {
            const toggleSidebar = document.getElementById('toggleSidebar');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');

            toggleSidebar.addEventListener('click', function() {
                sidebar.classList.toggle('collapsed');
                mainContent.classList.toggle('sidebar-collapsed');
            });
        });

        // Reviews Management Functions
        let currentReviewId = null;

        function confirmDeleteReview(id) {
            currentReviewId = id;
            document.getElementById('deleteModal').style.display = 'flex';
        }

        function deleteReview() {
            // Here you would typically send an AJAX request to the server
            alert('تم حذف التقييم بنجاح');
            closeModal('deleteModal');
            // Remove the review from the page
            const reviewCards = document.querySelectorAll('.review-card');
            reviewCards.forEach(card => {
                if (card.querySelector('.btn-danger').getAttribute('onclick').includes(id)) {
                    card.remove();
                }
            });
        }

        function approveReview(id) {
            currentReviewId = id;
            if(confirm('هل أنت متأكد من قبول هذا التقييم؟ سيتم نشره للعامة.')) {
                // Here you would typically send an AJAX request to the server
                alert('تم قبول التقييم بنجاح');
                updateReviewStatus(id, 'published');
            }
        }

        function rejectReview(id) {
            currentReviewId = id;
            document.getElementById('rejectModal').style.display = 'flex';
        }

        function rejectReviewConfirm() {
            const reason = document.getElementById('rejectReason').value;
            // Here you would typically send an AJAX request to the server
            alert('تم رفض التقييم بنجاح');
            updateReviewStatus(currentReviewId, 'rejected');
            closeModal('rejectModal');
        }

        function updateReviewStatus(id, status) {
            const reviewCards = document.querySelectorAll('.review-card');
            reviewCards.forEach(card => {
                if (card.querySelector('.btn-danger').getAttribute('onclick').includes(id)) {
                    const statusSpan = card.querySelector('.status');
                    const actionsDiv = card.querySelector('.review-actions');

                    if (status === 'published') {
                        statusSpan.textContent = 'منشور';
                        statusSpan.className = 'status status-published';
                    } else if (status === 'rejected') {
                        statusSpan.textContent = 'مرفوض';
                        statusSpan.className = 'status status-rejected';
                    }
                }
            });
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
            if(modalId === 'rejectModal') {
                document.getElementById('rejectReason').value = '';
            }
        }

        // Toggle between table and card view
        function toggleView(viewType) {
            if (viewType === 'table') {
                document.querySelector('.table-container').style.display = 'block';
                document.querySelector('.reviews-container').style.display = 'none';
            } else {
                document.querySelector('.table-container').style.display = 'none';
                document.querySelector('.reviews-container').style.display = 'block';
            }
        }
    </script>
</body>
</html>