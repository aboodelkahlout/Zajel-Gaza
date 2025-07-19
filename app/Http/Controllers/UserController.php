<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\hotel;
use App\Models\Rating;
use App\Models\Favorite;
use App\Mail\ContactMessage;
use App\Mail\VerfyTestEmail;
use Illuminate\Http\Request;
use App\Mail\SendVerificationCode;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    //
    function showloginpage(){
        return view('login');
    }

    function send(Request $request){

        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
        ]);

        Mail::to('aboodkalout19@gmail.com')->send(new ContactMessage($request->all()));

        return back()->with('success','send email successfully');

    }

    public function login(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required',
    ],[
        'email.required'    => 'البريد الإلكتروني مطلوب',
        'email.email'       => 'البريد الإلكتروني غير صالح',
        'password.required' => 'كلمة المرور مطلوبة',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user) {
        return back()->withErrors(['email' => 'البريد الإلكتروني غير موجود'])->withInput();;
    }

    if (!$user->is_verified) {
        return back()->withErrors(['email' => 'يرجى تفعيل البريد الإلكتروني أولاً'])->withInput();;
    }

    if (!Hash::check($request->password, $user->password)) {
        return back()->withErrors(['password' => 'كلمة المرور غير صحيحة'])->withInput();;
    }

    Auth::login($user);

    switch ($user->role) {
        case 'admin':
            return redirect()->route('admin.dashboard');
        case 'hotel_owner':
            return redirect()->route('owner.dashboard');
        case 'user':
            return redirect()->route('user.home');
        default:
            return redirect()->route('index');
    }
}

    function showregisterpage(){
        return view('register');
    }

    public function register(Request $request)
{
    $request->validate([
        'name'     => 'required|string|max:255|min:2|regex:/^[\p{Arabic}a-zA-Z]+(?: [\p{Arabic}a-zA-Z]+)*$/u',
        'email'    => 'required|unique:users|email',
        'password' => 'required|min:6|confirmed',
        'phone'    => 'required|string|min:9|max:10| regex:/^05[0-9]{8}$/'
    ],[
        'name.required' => 'الاسم مطلوب',
        'name.min'=>'الاسم لا يجب ان يكون اقل من حرفين',
        'name.regex'=>'يجب ان يحتوي على احرف فقط ولا يوجداكثر من فراغ بين كل اسم والاخر',
        'email.required' => 'الإيميل مطلوب',
        'email.email'    => 'الإيميل غير صحيح',
        'email.unique'   => 'الإيميل مستخدم',
        'email.email'=>'يجب ان يكون الايميل صحيح',
        'password.required' => 'كلمة المرور مطلوبة',
        'password.min'     => 'كلمة المرور يجب أن تكون 6 أحرف على الأقل',
        'password.confirmed' => 'كلمة المرور غير متطابقة',
        'phone.required' =>'الرقم مطلوب',
        'phone.min'=>'يجب ان يكون الرقم 10 خانات',
        'phone.regex'=>'يجب ان تكون مقدمة الرقم 05',
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
        'phone'=>$request->phone,
        'role' => 'user',
        'verification_code' => $code,
        'is_verified' => false,
    ]);

    return redirect()->route('verify.code.form', ['email' => $user->email]);
}


public function showVerificationForm(Request $request)
{
    return view('verify-code', ['email' => $request->query('email')]);
}

public function verifyCode(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'code' => 'required|numeric',
    ]);

    $user = User::where('email', $request->email)->first();

    if (!$user || $user->verification_code !== trim($request->code)) {
        return back()->with('error', 'رمز التحقق غير صحيح');
    }

    $user->update([
        'is_verified' => 1,
        'verification_code' => $request->code,
    ]);

    return redirect()->route('login')->with('success', 'تم التحقق من بريدك الإلكتروني! يمكنك تسجيل الدخول الآن.');
}



    function index(){
        return view('index');
    }


    function home(Request $request){


        $searchinput=$request->q;


        if ($request->has('q')) {
            $hotels=hotel::where('name','Like','%'. $searchinput .'%')->orwhere('adress','Like','%'.  $searchinput .'%')->get();
            return view('user.homeforuser', compact('hotels'));
        }
        else{
            $hotels=hotel::latest()->where('status','approved')->take(4)->get();

            return view('user.homeforuser',compact('hotels'));
        }

    }


    function detileshotel($id) {

            $hotel = hotel::with(['images','ratings','comments.reply','comments.user'])->findOrFail($id);

            $averageRating = round($hotel->ratings->avg('rating'), 1);

            return view('user.detiles', compact('hotel', 'averageRating'));
        }



    function userrating(Request $request , $id){

        $hotel=hotel::findOrFail($id);

        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);


        $hotel->ratings()->updateOrCreate(
            ['user_id' => auth()->id()],
            ['rating' => $request->rating]
        );

        return back()->with('success', 'تم إرسال التقييم بنجاح');

    }


    function usercomment(Request $request , $id){

        $hotel=hotel::findOrFail($id);

        $request->validate([
            'comment'=>'required',
        ],[
            'comment.required'=>'النعليق مطلوب'
        ]);

        $hotel->comments()->create([
            'user_id' => auth()->id(),
            'hotel_id'=>$hotel,
            'comment'=>$request->comment
        ]);

        return back()->with('success', 'تم إرسال التعليق بنجاح');


    }

    function showallhotel(Request $request){

        $searchinput=$request->q;

        if ($request->has('q')) {
            $hotels=hotel::where('name','Like','%'. $searchinput .'%')->orwhere('adress','Like','%'.  $searchinput .'%')->paginate(10);
            return view('user.allhotel', compact('hotels'));
        }

        else{
            $hotels=hotel::where('status','approved')->paginate(10);
            return view('user.allhotel',compact('hotels'));
        }

    }

    function fav(){
        $user = auth()->user();
        $user_id = $user->id;
        $favhotels=Favorite::with('hotel')->where('user_id',$user_id)->get();
        return view('user.fav',compact('favhotels'));
    }

    function addfav($id){

        $user = auth()->user();
        $hotel= hotel::findOrFail($id);
        $addedfav=Favorite::where('user_id', $user->id)->where('hotel_id', $hotel->id)->first();

        if ($addedfav == true) {
            $addedfav->delete();
        }else{
            $fav  = Favorite::create([
                'user_id' => $user->id,
                 'hotel_id'=> $hotel->id
            ]);
        }


        return back();
    }

    function removefav($id){
        $delfavhotel=Favorite::where('id',$id);
        $delfavhotel->delete();
        return back()->with('success', 'تم ازالة الهوتيل من المفضلة بنجاح');
    }


    function mosthotelrating(){

        $hotels = hotel::with('ratings')->get();
        $hotels->map(function ($hotel) {
            $hotel->avg_rating = round($hotel->ratings->avg('rating'), 1);
            return $hotel;
        });

        $sortedHotels = $hotels->sortByDesc('avg_rating')->take(6);

        return view('user.mostratinghotel',compact('sortedHotels'));
    }

    function settings(){
        return view('user.settingforuser');
    }

    function updatesettings(Request $request){

        $request->validate([
            'name' => 'required|string|max:255|min:2|regex:/^[\p{Arabic}a-zA-Z]+(?: [\p{Arabic}a-zA-Z]+)*$/u',
            'current_password'=>'required|min:6',
            'new_password'=>'required|min:6',
            'confirm_password'=>'required|min:6',
            'phone'=>'min:10|max:10'
        ],[
            'name.required' => 'الاسم مطلوب',
            'name.min'=>'الاسم لا يجب ان يكون اقل من حرفين',
            'name.regex'=> 'يجب ان يحتوي على احرف فقط ولا يوجداكثر من فراغ بين كل اسم والاخر',
            'current_password.required'=>'كلمة السر مطلوبة',
            'current_password.min:6'=>'كلمة السر 6 خانات على الاقل',
            'new_password.required'=>'كلمة المرور الجديدة مطلوبة ',
            'new_password.min'=>'كلمة السر 6 خانات على الاقل',
            'new_password.confirmed'=>'كلمة المرور غير متطابقة ',
            'phone.max'=>'لا يجب ان يزيد الرقم عن 10 خانات ',
            'phone.min'=>'لا يجب ان يكون الرقم اقل من 10 خانات'
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


    $user->update([
        'name'     =>$request->name,
        'phone'    => $request->phone,
        'password' => Hash::make($request->new_password),
    ]);


    return back()->with('success','تم تحديث اعدادات الحساب بنجاح ');}

}


    function  updateemail(Request $request){



        $request->validate([
            'email'=>'required|unique:users',

        ],[
            'email.required'=>'الايميل مطلوب',
            'email.unique'=>'البريد الالكتروني مستخدم بالفعل',
        ]);


        $user=auth()->user();

        $code = rand(100000, 999999);


        try {
            Mail::to($request->email)->send(new SendVerificationCode($code));
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'فشل في إرسال رسالة التحقق. تأكد من صحة الإيميل أو حاول لاحقاً.']);
        }




        $email = $request->email;

        $user->update([
        'email' => $request->email,
        'verification_code' => $code,
        'email_verified_at' => null,
        ]);

        return redirect()->route('verify.code.form', ['email' => $user->email]);
    }

    function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }
}
