<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{

public function index()
    {
        $users = User::paginate(10);
        return response()->json($users);
    }
public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'first_name' => ['required','string','max:255','regex:/^[\pL\s\-]+$/u'],
        'last_name' => ['required','string','max:255','regex:/^[\pL\s\-]+$/u'],
        'email' => ['required','email','unique:users,email'],
        'password' => ['required','string','min:8','confirmed'],
        'phone' => ['nullable','string','max:20'],
        'role' => ['nullable','in:employee,beneficiary,donor,trainer']
    ],[
        'first_name.regex' => 'الاسم الأول لا يمكن أن يحتوي على أرقام.',
        'last_name.regex' => 'الاسم الأخير لا يمكن أن يحتوي على أرقام.'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'errors' => $validator->errors()
        ],422);
    }

    $user = User::create([
        'first_name' => $request->first_name,
        'last_name' => $request->last_name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'phone' => $request->phone,
        'role' => $request->role ?? 'beneficiary'
    ]);

    return response()->json([
        'message' => 'تم تسجيل المستخدم بنجاح',
        'user' => $user
    ],201);
}



public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => ['required','email'],
        'password' => ['required','string']
    ],[
        'email.required' => 'حقل البريد الإلكتروني مطلوب',
        'email.email' => 'صيغة البريد الإلكتروني غير صحيحة',
        'password.required' => 'حقل كلمة المرور مطلوب'
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'خطأ في البيانات المدخلة',
            'errors' => $validator->errors()
        ],422);
    }

    if (!Auth::attempt($request->only('email','password'))) {
        return response()->json([
            'status' => false,
            'message' => 'البريد الإلكتروني أو كلمة المرور غير صحيحة'
        ],401);
    }

    $user = Auth::user();

  
    $user->update([
        'last_login_at' => now()
    ]);

    
    $token = $user->createToken('auth_token')->plainTextToken;

    return response()->json([
        'status' => true,
        'message' => 'تم تسجيل الدخول بنجاح',
        'user' => $user,
        'token' => $token,
        'token_type' => 'Bearer'
    ]);
}

public function logout(Request $request)
{
    $user = Auth::user();
    $user->tokens()->delete();

    return response()->json([
        'status' => true,
        'message' => 'تم تسجيل الخروج بنجاح'
    ]);
}

public function getUserProfile(Request $request)
{
    $user = Auth::user();

    return response()->json([
        'status' => true,
        'user' => $user
    ]);
}


public function updateProfile(Request $request)
{
    $user = Auth::user();

    $validator = Validator::make($request->all(), [
        'first_name' => ['sometimes', 'required', 'string', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
        'last_name'  => ['sometimes', 'required', 'string', 'max:255', 'regex:/^[\pL\s\-]+$/u'],
        'email'      => ['sometimes', 'required', 'email', 'unique:users,email,' . $user->id],
        'phone'      => ['nullable', 'string', 'max:20'],
        'password'   => ['nullable', 'string', 'min:8', 'confirmed'],
    ], [
        'first_name.required' => 'الاسم الأول مطلوب',
        'first_name.string'   => 'الاسم الأول يجب أن يكون نصاً',
        'first_name.max'      => 'الاسم الأول يجب ألا يتجاوز 255 حرفاً',
        'first_name.regex'    => 'الاسم الأول يجب أن يحتوي على أحرف فقط بدون أرقام',

        'last_name.required'  => 'اسم العائلة مطلوب',
        'last_name.string'    => 'اسم العائلة يجب أن يكون نصاً',
        'last_name.max'       => 'اسم العائلة يجب ألا يتجاوز 255 حرفاً',
        'last_name.regex'     => 'اسم العائلة يجب أن يحتوي على أحرف فقط بدون أرقام',

        'email.required'      => 'البريد الإلكتروني مطلوب',
        'email.email'         => 'صيغة البريد الإلكتروني غير صحيحة',
        'email.unique'        => 'البريد الإلكتروني مستخدم بالفعل',

        'phone.string'        => 'رقم الهاتف يجب أن يكون نصاً',
        'phone.max'           => 'رقم الهاتف يجب ألا يتجاوز 20 خانة',

        'password.string'     => 'كلمة المرور يجب أن تكون نصاً',
        'password.min'        => 'كلمة المرور يجب ألا تقل عن 8 أحرف',
        'password.confirmed'  => 'تأكيد كلمة المرور غير متطابق',
    ]);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'يوجد خطأ في البيانات المدخلة',
            'errors' => $validator->errors()
        ], 422);
    }

    $data = $request->only([
        'first_name',
        'last_name',
        'email',
        'phone',
    ]);

    if ($request->filled('password')) {
        $data['password'] = Hash::make($request->password);
    }

    $user->update($data);

    return response()->json([
        'status' => true,
        'message' => 'تم تعديل المعلومات بنجاح',
        'user' => $user->fresh()
    ], 200);
}

}
