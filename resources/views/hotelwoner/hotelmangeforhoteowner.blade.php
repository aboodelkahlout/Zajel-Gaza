<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>لوحة تحكم الفندق - إدارة الفندق</title>
    <link href="https://fonts.googleapis.com/css2?family=Tajawal:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="{{ asset ('bootstrap-5.3.7-dist/css/bootstrap.min.css')}}">
   <link rel="stylesheet" href="{{ asset ('css/hotelmangeforhotelwoner.css')}}">
</head>
<body>
    <div class="dashboard">
        <!-- الشريط الجانبي -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h3>لوحة تحكم الفندق</h3>
            </div>
            @include('hotelwoner.layout')
        </div>


        <!-- المحتوى الرئيسي -->
        <div class="main-content">
            <div class="header">
                <h1>إدارة الفندق</h1>
            </div>

            <!-- قسم معلومات الفندق -->
            <div class="content-section">
                <h2 class="section-title">
                    <i class="fas fa-info-circle" style="margin-left:10px;"></i>
                    معلومات الفندق الأساسية
                </h2>
                <form class="hotel-info-form" action="{{ route('edit.info.hotel',$hotel->id) }}" enctype="multipart/form-data" method="POST">
                    @csrf
                    @method('put')
                    <div>
                        <div class="form-group">
                            <label>اسم الفندق</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name' , $hotel->name)}}">
                        </div>
                        @error('name')
                <small class="text-danger">
                    {{ $message }}
                </small>
                @enderror
                        <div class="form-group">
                            <label>الوصف</label>
                            <input type="text" class="form-control @error('description')
                                is-invalid
                            @enderror" name="description" value="{{old('description' ,$hotel->description)}}">
                        </div>
                        @error('description')
                <small class="text-danger">
                    {{ $message }}
                </small>
                @enderror
                        <div class="form-group">
                            <label>العنوان</label>
                            <input type="text" class="form-control @error('adress')
                                is-invalid
                            @enderror " name="adress" value="{{old('adress', $hotel->adress)}}">
                        </div>
                        @error('adress')
                <small class="text-danger">
                    {{ $message }}
                </small>
                @enderror
                    </div>
                    <div>
                        <div class="form-group">
                            <label>انواع الغرف</label>
                            <input type="text" class="form-control  @error('room_types')
                                is-invalid
                            @enderror" name="room_types" value="{{old('room_types', $hotel->room_types)}}" placeholder="فردي , ثنائي , عائلي">
                        </div>
                        @error('room_types')
                <small class="text-danger">
                    {{ $message }}
                </small>
                @enderror
                        <div class="form-group">
                            <label>عدد الغرف </label>
                            <input type="number" class="form-control  @error('room_count')
                                is-invalid
                            @enderror " name="room_count" value="{{old('room_count',$hotel->room_count)}}">
                        </div>
                        @error('room_count')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                        <div class="form-group">
                            <label>سعر الليلة الواحدة</label>
                            <input type="number" class="form-control @error('price_per_night')
                                is-invalid
                            @enderror " name="price_per_night" value="{{old('price_per_night',$hotel->price_per_night)}}">
                        </div>
                        @error('price_per_night')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                        <div class="form-group">
                            <label>رقم الهاتف</label>
                            <input type="number" class="form-control @error('phone_number')
                                is-invalid
                            @enderror " name="phone_number" value="{{old('phone_number', $hotel->phone_number)}}">
                        </div>
                        @error('phone_number')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                        <div class="form-group">
                            <label>واتساب </label>
                            <input type="number" class="form-control @error('whatsapp')
                                is-invalid
                            @enderror " name="whatsapp" value="{{old('whatsapp',$hotel->whatsapp)}}">
                        </div>
                        @error('whatsapp')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror

                        <div class="form-group">
                            <label>انستغرام </label>
                            <input type="url" class="form-control  @error('instagram')
                                is-invalid
                            @enderror " name="instagram" value="{{old('instagram', $hotel->instagram)}}">
                        </div>
                        @error('instagram')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror

                        <div class="form-group">
                            <label>فيس بوك</label>
                            <input type="url" class="form-control  @error('facebook')
                                is-invalid
                            @enderror" name="facebook" value="{{old('facebook',$hotel->facebook)}}">
                        </div>
                        @error('facebook')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror

                        <div class="form-group">
                            <label for="cover_image">صورة الغلاف</label>
                            <input type="file" name="cover_image" class="form-control" accept="image/*">
                        </div>

                        <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                    </div>
                </form>
            </div>

            <!-- قسم أنواع وأسعار الغرف -->

            <!-- قسم معرض الصور -->
            <div class="content-section">
                <h2 class="section-title">
                    <i class="fas fa-images" style="margin-left: 10px;"></i>
                    معرض صور الفندق
                </h2>
                <form action="{{ route('hotel.image.upload', $hotel->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <label class="btn btn-primary" style="margin-bottom: 15px;">
                        <i class="fas fa-plus"></i> إضافة صور جديدة
                        <input type="file" name="images[]" accept="image/*" multiple style="display: none;" onchange="this.form.submit()">
                    </label>
                </form>
                <div class="row">
                @foreach ($hotel->images as $image)
                <div class="gallery-grid d-flex col-md-2">
                    <div class="gallery-item">
                    <img src="{{ asset($image->image_path) }}" alt="صورة الفندق">

                        <div class="gallery-actions">
                            <form action="{{route('hotel.image.delete' , $image->id)}}" method="post">
                                @csrf
                                @method('delete')
                                <button class=" gallery-btn btn btn-outline-danger" onclick=" return confirm('هل انت متأكد من حذف هذه الصورة . {{ asset($image->image_path) }}')">
                                <i class="fas fa-trash"></i>
                                </button>
                        </form>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const roomModal = document.getElementById('roomModal');
            const roomForm = document.getElementById('roomForm');
            const modalTitle = document.getElementById('modalTitle');
            const roomTypeInput = document.getElementById('roomType');
            const roomPriceInput = document.getElementById('roomPrice');
            const roomDescriptionInput = document.getElementById('roomDescription');
            const cancelBtn = document.getElementById('cancelBtn');
            const addRoomBtn = document.getElementById('addRoomBtn');
            const roomsTableBody = document.querySelector('.rooms-table tbody');

            let editingRow = null;

            function showToast(message) {
                let toast = document.createElement('div');
                toast.textContent = message;
                toast.style.cssText = `
                    position: fixed;
                    bottom: 20px;
                    right: 20px;
                    background: #28a745;
                    color: white;
                    padding: 10px 20px;
                    border-radius: 5px;
                    box-shadow: 0 2px 5px rgba(0,0,0,0.3);
                    z-index: 9999;
                    transition: opacity 0.5s ease;
                `;
                document.body.appendChild(toast);
                setTimeout(() => {
                    toast.style.opacity = '0';
                    setTimeout(() => toast.remove(), 500);
                }, 2000);
            }

            addRoomBtn.addEventListener('click', function () {
                editingRow = null;
                modalTitle.textContent = 'إضافة نوع غرفة جديد';
                roomForm.reset();
                roomModal.style.display = 'flex';
            });

            cancelBtn.addEventListener('click', function () {
                roomModal.style.display = 'none';
            });

            roomForm.addEventListener('submit', function (e) {
                e.preventDefault();

                const type = roomTypeInput.value.trim();
                const price = roomPriceInput.value.trim();
                const description = roomDescriptionInput.value.trim();

                if (!type || !price || !description) {
                    alert('يرجى تعبئة جميع الحقول');
                    return;
                }

                if (isNaN(price)) {
                    alert('يرجى إدخال سعر صالح');
                    return;
                }

                if (editingRow) {
                    editingRow.cells[0].textContent = type;
                    editingRow.cells[1].textContent = price + ' ر.س';
                    editingRow.cells[2].textContent = description;
                    showToast('تم تعديل الغرفة بنجاح');
                } else {
                    const newRow = roomsTableBody.insertRow();
                    newRow.insertCell(0).textContent = type;
                    newRow.insertCell(1).textContent = price + ' ر.س';
                    newRow.insertCell(2).textContent = description;
                    const actionCell = newRow.insertCell(3);

                    const editIcon = document.createElement('i');
                    editIcon.className = 'fas fa-edit action-icon';
                    editIcon.title = 'تعديل';
                    actionCell.appendChild(editIcon);

                    const deleteIcon = document.createElement('i');
                    deleteIcon.className = 'fas fa-trash action-icon';
                    deleteIcon.title = 'حذف';
                    actionCell.appendChild(deleteIcon);

                    editIcon.addEventListener('click', onEditClick);
                    deleteIcon.addEventListener('click', onDeleteClick);

                    showToast('تمت إضافة الغرفة بنجاح');
                }

                roomModal.style.display = 'none';
            });

            function onEditClick() {
                editingRow = this.closest('tr');
                modalTitle.textContent = 'تعديل نوع الغرفة';
                roomTypeInput.value = editingRow.cells[0].textContent;
                roomPriceInput.value = editingRow.cells[1].textContent.replace(' ر.س', '');
                roomDescriptionInput.value = editingRow.cells[2].textContent;
                roomModal.style.display = 'flex';
            }

            function onDeleteClick() {
                if (confirm('هل أنت متأكد من حذف هذا النوع من الغرف؟')) {
                    this.closest('tr').remove();
                    showToast('تم حذف الغرفة');
                }
            }

            // للصفوف الموجودة مسبقًا
            document.querySelectorAll('.action-icon.fa-edit').forEach(icon => {
                icon.addEventListener('click', onEditClick);
            });

            document.querySelectorAll('.action-icon.fa-trash').forEach(icon => {
                icon.addEventListener('click', onDeleteClick);
            });

            // إغلاق النموذج عند الضغط خارج النافذة
            window.addEventListener('click', function (e) {
                if (e.target === roomModal) {
                    roomModal.style.display = 'none';
                }
            });
             // سكربت معرض الصور
    window.handleImageUpload = function (files) {
        const galleryGrid = document.querySelector('.gallery-grid');

        Array.from(files).forEach(file => {
            const reader = new FileReader();

            reader.onload = function (e) {
                const galleryItem = document.createElement('div');
                galleryItem.classList.add('gallery-item');

                const img = document.createElement('img');
                img.src = e.target.result;
                img.alt = "صورة الفندق";

                const actions = document.createElement('div');
                actions.classList.add('gallery-actions');

                const deleteBtn = document.createElement('div');
                deleteBtn.classList.add('gallery-btn');
                deleteBtn.title = "حذف";

                const trashIcon = document.createElement('i');
                trashIcon.className = 'fas fa-trash';

                deleteBtn.appendChild(trashIcon);
                actions.appendChild(deleteBtn);
                galleryItem.appendChild(img);
                galleryItem.appendChild(actions);
                galleryGrid.appendChild(galleryItem);

                deleteBtn.addEventListener('click', function () {
                    if (confirm('هل تريد حذف هذه الصورة؟')) {
                        galleryItem.remove();
                    }
                });
            };

            reader.readAsDataURL(file);
        });
    };

    // حذف الصور القديمة
    document.querySelectorAll('.gallery-btn').forEach(btn => {
        btn.addEventListener('click', function () {
            const item = this.closest('.gallery-item');
            if (confirm('هل تريد حذف هذه الصورة؟')) {
                item.remove();
            }
        });
    });

        });
        </script>


</body>
</html>