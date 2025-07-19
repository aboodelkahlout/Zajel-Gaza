<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\hotel;
use App\Models\Rating;
use App\Models\comment;
use App\Models\hotelimage;
use App\Models\CommentReply;
use Illuminate\Http\Request;
use App\Mail\SendVerificationCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class HotelWonerController extends Controller
{
    //
    public function showRegisterForm()
    {
        return view('hotelwoner.registerhotelwoner');
    }

    public function register(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255|min:2||regex:/^[\p{Arabic}a-zA-Z]+(?: [\p{Arabic}a-zA-Z]+)*$/u',
            'email'    => 'required|unique:users|email',
            'password' => 'required|min:6|confirmed',
            'phone'    => 'required|string|min:9|max:10| regex:/^05[0-9]{8}$/'
        ],[
            'name.required' => 'الاسم مطلوب',
            'name.min'=>'لا يجب ان يكون الاسم اقل من حرفين',
            'name.regex'=>'يجب ان يحتوي على احرف فقط ولا يوجداكثر من فراغ بين كل اسم والاخر',
            'email.required' => 'الإيميل مطلوب',
            'email.email'=>'الايميل غير صحيح',
            'email.email'    => 'الإيميل غير صحيح',
            'email.unique'   => 'الإيميل مستخدم',
            'password.required' => 'كلمة المرور مطلوبة',
            'password.min'     => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل',
            'password.confirmed' => 'كلمة المرور غير متطابقة',
            'phone.required' =>'الرقم مطلوب',
            'phone.regex'=>'يجب ان تكون مقدمة الرقم 05',
            'phone.min'=>'يجب ان يكون الرقم 10 خانات',
            'phone.max'=>'يجب ان يكون الرقم 10 خانات'
        ]);

        $code = rand(100000, 999999);

        try {
            Mail::to($request->email)->send(new SendVerificationCode($code));
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'فشل في إرسال رسالة التحقق. تأكد من صحة الإيميل أو حاول لاحقاً.']);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => 'hotel_owner',
            'verification_code' => $code,
            'is_verified' => false,
        ]);

        return redirect()->route('verify.code.form', ['email' => $user->email]);
    }

    function hotelownerdashbord(){

        $owner = Auth::user();

        $owner_id=$owner->id;

        $hotelIds = $owner->hotels->pluck('id');

        $hotels = $owner->hotels->map(function ($hotel) {
            $averageRating = $hotel->ratings->avg('rating');
            $hotel_owner_id=$hotel->hotel_owner_id;
            $allrating=$hotel->ratings->count();
            $imagesCount = $hotel->images->count();
            $roomCount = $hotel->room_count;
            $pricepernight=$hotel->price_per_night;

            return [
                'id' => $hotel->id,
                'name' => $hotel->name,
                'status' => $hotel->status,
                'imagescount' => $imagesCount,
                'roomcount' => $roomCount,
                'averagerating' => $averageRating,
                'pricepernight' => $pricepernight,
                'allrating' => $allrating,
                'hotel_owner_id'=>$hotel_owner_id,

            ];
        });

    return view('hotelwoner.homehotelwoner', compact('hotels','hotelIds','owner_id'));
}

function showeditinfo($id){

    $hotel = hotel::with(['images', 'ratings'])->findOrFail($id);
    return view('hotelwoner.hotelmangeforhoteowner', compact('hotel'));
}

function editinfohotel(Request $request,$id){
    $request->validate([
        'name' => 'required|string',
        'description'=> 'required|string',
        'adress'=> 'required|string',
        'room_types'=>'required|string',
        'room_count' => 'required|integer|min:1',
        'price_per_night' => 'required|numeric|min:1',
        'phone_number'=>'required|numeric|digits:10|regex:/^05[0-9]{8}$/',
        'whatsapp'=>' nullable|numeric|digits:10',
        'instagram'=>' nullable|string',
        'facebook'=>' nullable|string',

    ],[

        'name.required'=>'الاسم مطلوب ',
        'name.string'=> ' الاسم يجب ان يكون نص',
        'description.required'=>' الوصف مطلوب',
        'description.string'=>' الوصف يجب ان يكون نص',
        'adress.required'=>' العنوان مطلوب',
        'adress.string'=>' العنوان يجب ان يكون نص',
        'room_types.required'=>' نوع الغرف مطلوب',
        'room_types.in' => 'نوع الغرفة يجب أن يكون إما فردية، مزدوجة، أو عائلية.',
        'room_types.string'=>' نوع الغرف يجب ان يكون نص',
        'room_count.required'=>' عدد الغرف مطلوب',
        'room_count.integer'=>' عدد الغرف يجب ان يكون عدد',
        'room_count.min'=>'  عدد الغرف يجب ان يكون اكثر من صفر',
        'price_per_night.required'=>' السعر الليلة مطلوب',
        'price_per_night.min'=>'  السعر الليلة يجب ان يكون اكثر من صفر',
        'price_per_night.numeric'=> 'السعر الليلة يجب ان يكون عدد',
        'phone_number.required'=>' رقم الهاتف مطلوب',
        'phone_number.regex'=>'يجب ان يبدأ الرقم ب 05',
        'phone_number.numeric'=>' رقم الهاتف يجب ان يكون عدد',
        'phone_number. digits'=>' رقم الهاتف يجب ان يكون 10 ارقام',
        'whatsapp.numeric'=>' رقم الواتساب يجب ان يكون عدد ',
        'whatsapp.digits:10'=>' رقم الواتساب يجب ان يكون 10 ارقام',
        'instagram.string'=>' ايميل الايnstagram يجب ان يكون نص',
        'facebook.string'=>' ايميل الفيس بوك يجب ان يكون نص',
        'facebook.url'=>' يجب ان يبدا الرابط ب https://facebook.com/واسم حسابك هنا'
    ]);

    $hotel = Hotel::findOrFail($request->id);

    if ($request->hasFile('cover_image')) {
        $image = $request->file('cover_image');
        $imageName = time() . '_' . $image->getClientOriginalName();
        $image->move(public_path('img'), $imageName);
        $hotel->cover_image = $imageName;
    }

    $hotel->name = $request->name;
    $hotel->description = $request->description;
    $hotel->adress = $request->adress;
    $hotel->room_types = $request->room_types;
    $hotel->room_count = $request->room_count;
    $hotel->price_per_night = $request->price_per_night;
    $hotel->phone_number = $request->phone_number;
    $hotel->whatsapp = $request->whatsapp;
    $hotel->instagram = $request->instagram;
    $hotel->facebook = $request->facebook;

    $hotel->save();
    return redirect()->route('owner.dashboard')->with([
        'success' => 'تم تحديث معلومات الفندق بنجاح ',
    ]);
}
        function uploadImages(Request $request, $hotelId)
        {

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $filename = time() . '_' . preg_replace('/\s+/', '_', $image->getClientOriginalName());
                    $image->move(public_path('img'), $filename);

                    HotelImage::create([
                        'hotel_id' => $hotelId,
                        'image_path' => 'img/' . $filename
                    ]);
                }
            }


            return back()->with('success', 'تم رفع الصورة بنجاح');

        }


        public function deleteImage($id)
        {
            $image = HotelImage::findOrFail($id);

            $path = public_path($image->image_path);

            if (file_exists($path)) {
                unlink($path);
            }

            $image->delete();

            return back()->with('success', 'تم حذف الصورة بنجاح');
        }


        function addhotel($owner_id){
            return view('hotelwoner.hotelownerform',compact('owner_id'));
        }

        function addhotelop(Request $request, $id){

            $request->validate([
                'name' => 'required|string',
                'description'=> 'required|string',
                'adress'=> 'required|string',
                'room_types'=>'required|string',
                'room_count' => 'required|integer|min:0',
                'price_per_night' => 'required|numeric|min:0',
                'phone_number'=>'required|numeric|digits:10',
                'whatsapp'=>' nullable|numeric|digits:10',
                'instagram'=>' nullable|string',
                'facebook'=>' nullable|string',

            ],[

                'name.required'=>'الاسم مطلوب ',
                'name.string'=> ' الاسم يجب ان يكون نص',
                'description.required'=>' الوصف مطلوب',
                'description.string'=>' الوصف يجب ان يكون نص',
                'adress.required'=>' العنوان مطلوب',
                'adress.string'=>' العنوان يجب ان يكون نص',
                'room_types.required'=>' نوع الغرف مطلوب',
                'room_types.string'=>' نوع الغرف يجب ان يكون نص',
                'room_count.required'=>' عدد الغرف مطلوب',
                'room_count.integer'=>' عدد الغرف يجب ان يكون عدد',
                'room_count.min:0'=>' عدد الغرف يجب ان يكون 0 او اكثر',
                'price_per_night.required'=>' السعر الليلة مطلوب',
                'price_per_night.min:0'=>' السعر الليلة يجب ان يكون 0 او اكثر',
                'price_per_night.numeric'=> '  السعر الليلة يجب ان يكون عدد',
                'phone_number.required'=>' رقم الهاتف مطلوب',
                'phone_number.numeric'=>' رقم الهاتف يجب ان يكون عدد',
                'phone_number. digits:10'=>' رقم الهاتف يجب ان يكون 10 ارقام',
                'whatsapp.numeric'=>' رقم الواتساب يجب ان يكون عدد ',
                'whatsapp.digits:10'=>' رقم الواتساب يجب ان يكون 10 ارقام',
                'instagram.string'=>' ايميل الايnstagram يجب ان يكون نص',
                'facebook.string'=>' ايميل الفيس بوك يجب ان يكون نص',
            ]);

            $hotel = new Hotel();
            $hotel->hotel_owner_id = $id;
            $hotel->name = $request->name;
            $hotel->description = $request->description;
            $hotel->room_types = $request->room_types;
            $hotel->phone_number = $request->phone_number;
            $hotel->adress = $request->adress;
            $hotel->room_count = $request->room_count;
            $hotel->price_per_night = $request->price_per_night;
            $hotel->whatsapp = $request->whatsapp;
            $hotel->instagram = $request->instagram;
            $hotel->facebook = $request->facebook;
            $hotel->status = 'pending';

            if ($request->hasFile('cover_image')) {
                $image = $request->file('cover_image');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('img'), $imageName);
                $hotel->cover_image = $imageName;
            }


            $hotel->save();

            return redirect()->route('owner.dashboard')->with('success', 'تمت إضافة الفندق بنجاح');
        }

        function statistics($id){


            $hotel=hotel::with(['images', 'ratings','favorites','comments'])->findOrFail($id);
            $imagesCount = $hotel->images->count();
            $ratingsCount = $hotel->ratings->count();
            $favoritesCount = $hotel->favorites->count();
            $commentsCount = $hotel->comments->count();
            $averageRating = $hotel->ratings->avg('rating');
            $positiveRatings = $hotel->ratings->where('rating', '>=', 4)->count();
            $neutralRatings  = $hotel->ratings->where('rating', '=', 3)->count();
            $negativeRatings = $hotel->ratings->where('rating', '<=', 2)->count();

            $statistic=[
                'imagesCount'=>$imagesCount,
                'ratingsCount'=>$ratingsCount,
                'favoritesCount'  =>$favoritesCount,
                 'commentsCount' =>$commentsCount,
                 'averageRating' =>$averageRating,
                 'positiveRatings' =>$positiveRatings,
                 'neutralRatings' =>$neutralRatings,
                 'negativeRatings' =>$negativeRatings,

            ];

            return view('hotelwoner.statistics',compact('statistic'));
        }

        function comments(){

            $comments = comment::with(['user', 'hotel', 'reply'])->whereHas('hotel', function ($query) {$query->where('hotel_owner_id', auth()->id());})->get();

            return view('hotelwoner.commentforhotelowner', compact('comments'));
        }

        function hotelownerdestroycomment($id){

            $comment = Comment::findOrFail($id);

            $comment->delete();

            return back()->with('sucsess' , 'تم الحذف بنجاح');
        }

        function replyForm($id){


            $comment = Comment::with('reply')->findOrFail($id);

             return view('hotelwoner.replayform', compact('comment'));
        }


        function saveReply(Request $request , $id){

            $request->validate([
                'reply_text' => 'required|string',
            ]);

            $comment = comment::findOrFail($id);

          $savreply = CommentReply::updateOrCreate(
                [
                 'comment_id' => $id,
                 'reply_text' => $request->reply_text,
                 'replied_by' => 'hotel_owner',
                 'replied_by_id' => auth()->user()->id
                ]
            );

                return redirect()->route('hotel.comments');
        }


        function showeditreply($id , $replyid){

            $comments=comment::findOrFail($id);

            $reply=CommentReply::findOrFail($replyid);

            return view('hotelwoner.editreplayform',compact('comments','reply'));
        }


        function editreply(Request $request ,$replyid){

            $request->validate(['reply_text'=>'required'],[
                'reply_text.required' => 'الرجاء ادخال التعليق',
            ]);


            $reply=CommentReply::findOrFail($replyid);

            $reply->update([
                'reply_text' => $request->reply_text,
            ]);


            return redirect()->route('hotel.comments');
        }


        function destroyreply($id){


            $reply =CommentReply::findOrFail($id);

            $reply->delete();

            return back()->with('sucsess' , 'تم الحذف بنجاح');
        }




        function settings(){

            $owner = Auth::user();


            return view('hotelwoner.settingforhotelowner', compact('owner'));
        }




        function updatesettings(Request $request, $id){


            $request->validate([
                'email'=>'required|unique:users',

            ],[
                'email.required'=>'الايميل مطلوب',
                'email.unique'=>'البريد الالكتروني مستخدم بالفعل',
            ]);

            $user=User::findOrFail($id);




            $code = rand(100000, 999999);


            try {
                Mail::to($request->email)->send(new SendVerificationCode($code));
            } catch (\Exception $e) {
                return back()->withErrors(['email' => 'فشل في إرسال رسالة التحقق. تأكد من صحة الإيميل أو حاول لاحقاً.']);
            }




            $email = $request->only('email');

            $user->update($email);

            return redirect()->route('verify.code.form', ['email' => $user->email]);
        }


        function updatepassword(Request $request , $id){

            $request->validate([
                'current_password'=>'required|min:6',
                'new_password'=>'required|min:6',
                'confirm_password'=>'required|min:6'
            ],[
                'current_password.required'=>'كلمة السر مطلوبة',
                'current_password.min:6'=>'كلمة السر 6 خانات على الاقل',
                'new_password.required'=>'كلمة المرور الجديدة مطلوبة ',
                'new_password.min'=>'كلمة السر 6 خانات على الاقل',
                'new_password.confirmed'=>'كلمة المرور غير متطابقة '
            ]);

            $user = Auth::user();

       if ($request->filled('current_password') || $request->filled('new_password') || $request->filled('confirm_password')) {

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'كلمة المرور الحالية غير صحيحة.']);
        }

        if ($request->new_password !== $request->confirm_password) {
            return back()->withErrors(['confirm_password' => 'تأكيد كلمة المرور لا يطابق الجديدة.']);
        }

        $request->validate([
            'new_password' => 'required|min:6',
        ]);

        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success','تم تحديث كلمة السر بنجاح ');
    }
 }

 public function logout(Request $request)
{
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login')->with('success', 'تم تسجيل الخروج بنجاح.');
}


}
