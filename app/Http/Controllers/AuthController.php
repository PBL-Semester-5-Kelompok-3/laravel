<?php

namespace App\Http\Controllers;

use App\Mail\HelloMail;
use Illuminate\Http\Request;
use App\Models\User;
use Tymon\JWTAuth\Facades\JWTAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/api/register",
     *     tags={"Authentication"},
     *     summary="Register a new user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"username","email","password"},
     *             @OA\Property(property="username", type="string", example="JohnDoe"),
     *             @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(response=201, description="User registered successfully"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'username' => 'required|string|max:255|unique:users,username',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation error',
                'message' => $validator->errors()
            ], 422); // Menggunakan 422 (Unprocessable Entity) untuk kesalahan validasi
        }

        // Membuat user baru jika validasi berhasil
        $user = User::create([
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'message' => 'User registered successfully.',
            'data' => $user
        ], 201);
    }
    /**
     * @OA\Post(
     *     path="/api/login",
     *     tags={"Authentication"},
     *     summary="Login user",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *             @OA\Property(property="password", type="string", example="password123")
     *         )
     *     ),
     *     @OA\Response(response=200, description="User logged in successfully"),
     *     @OA\Response(response=401, description="Unauthorized"),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation error',
                'message' => $validator->errors()
            ], 422); // Menggunakan 422 (Unprocessable Entity) untuk kesalahan validasi
        }

        $credentials = $request->only('email', 'password');

        if ($token = JWTAuth::attempt($credentials)) {
            return response()->json(['token' => $token]);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    /**
     * @OA\Post(
     *     path="/api/forgot-password",
     *     tags={"Authentication"},
     *     summary="Send reset password OTP to email",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email"},
     *             @OA\Property(property="email", type="string", example="johndoe@example.com")
     *         )
     *     ),
     *     @OA\Response(response=200, description="OTP sent to your email."),
     *     @OA\Response(response=404, description="Email not found."),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function forgotPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation error',
                'message' => $validator->errors()
            ], 422); // Menggunakan 422 (Unprocessable Entity) untuk kesalahan validasi
        }

        // Mengecek apakah email ada di database
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'Email not found.'], 404);
        }

        // Generate OTP 4 digit
        $otp = rand(1000, 9999);

        // Menyimpan OTP dalam cache selama 10 menit
        Cache::put('otp_' . $user->email, $otp, 600); // 600 detik = 10 menit

        // Kirim OTP via email
        Mail::to($user->email)->send(new HelloMail($user->username, $otp));

        return response()->json(['message' => 'OTP sent to your email.']);
    }

    /**
     * @OA\Post(
     *     path="/api/reset-password",
     *     tags={"Authentication"},
     *     summary="Reset user password using OTP",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","otp","password","password_confirmation"},
     *             @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *             @OA\Property(property="otp", type="string", example="902520"),
     *             @OA\Property(property="password", type="string", example="newpassword123"),
     *             @OA\Property(property="password_confirmation", type="string", example="newpassword123")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Password successfully reset."),
     *     @OA\Response(response=400, description="Invalid or expired OTP."),
     *     @OA\Response(response=404, description="User not found."),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function resetPassword(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|numeric|digits:4',  // Validasi OTP 4 digit
            'password' => 'required|string|confirmed|min:8',  // Validasi password
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation error',
                'message' => $validator->errors()
            ], 422); // Menggunakan 422 (Unprocessable Entity) untuk kesalahan validasi
        }

        // Ambil OTP yang disimpan di cache
        $cachedOtp = Cache::get('otp_' . $request->email);

        // Cek apakah OTP yang diberikan valid atau tidak ditemukan
        if (!$cachedOtp || $cachedOtp != $request->otp) {
            return response()->json(['error' => 'Invalid or expired OTP.'], 400);
        }

        // Ambil user berdasarkan email
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['error' => 'User not found.'], 404);
        }

        // Update password pengguna dengan password baru
        $user->forceFill([
            'password' => Hash::make($request->password),
        ])->save();

        // Menghapus OTP dari cache setelah digunakan
        Cache::forget('otp_' . $request->email);

        return response()->json(['message' => 'Password successfully reset.']);
    }

    /**
     * @OA\Post(
     *     path="/api/verify-otp",
     *     tags={"Authentication"},
     *     summary="Verify OTP for password reset",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"email","otp"},
     *             @OA\Property(property="email", type="string", example="johndoe@example.com"),
     *             @OA\Property(property="otp", type="string", example="902520")
     *         )
     *     ),
     *     @OA\Response(response=200, description="OTP verified successfully."),
     *     @OA\Response(response=400, description="Invalid or expired OTP."),
     *     @OA\Response(response=404, description="Email not found."),
     *     @OA\Response(response=422, description="Validation error")
     * )
     */
    public function verifyOtp(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'otp' => 'required|numeric|digits:4',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => 'Validation error',
                'message' => $validator->errors()
            ], 422); // Menggunakan 422 (Unprocessable Entity) untuk kesalahan validasi
        }

        // Ambil OTP yang disimpan di cache
        $cachedOtp = Cache::get('otp_' . $request->email);

        // Cek apakah OTP tidak ada atau telah kedaluwarsa
        if (!$cachedOtp) {
            return response()->json(['error' => 'OTP has expired or not found.'], 400);
        }

        // Verifikasi apakah OTP yang dimasukkan sama dengan OTP yang ada di cache
        if ($cachedOtp != $request->otp) {
            return response()->json(['error' => 'Invalid OTP.'], 400);
        }

        return response()->json(['message' => 'OTP verified successfully.']);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     tags={"Authentication"},
     *     summary="Logout user",
     *     @OA\Response(response=200, description="Successfully logged out")
     * )
     */
    public function logout()
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return response()->json(['message' => 'Successfully logged out']);
    }
}
