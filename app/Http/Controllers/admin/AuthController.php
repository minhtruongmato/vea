<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterAdminRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\User;
use Auth;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Str;

class AuthController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLogin(){
        if (Auth::check()) {
            return redirect()->intended(route('admin.dashboard'));
        };
        return view('admin.user.login');
    }

    /**
     * @param LoginRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postLogin(LoginRequest $request){
        $email = $request->email;
        $password = $request->password;

        if (Auth::attempt(['email' => $email, 'password' => $password], true)) {
            return redirect()->intended('admin');
        }
        return redirect('admin/dang-nhap')->with('error','Tài khoản hoặc mật khẩu không đúng');
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function showRegister()
    {
        if (Auth::check()) {
            if (Auth::user()->level == 99) {
                return view('admin.user.register');
            }
            return redirect()->intended(route('admin.dashboard'))->with('error','Vui lòng đăng nhập quyền Quản trị viên');
        };
        return redirect()->intended(route('admin.postLogin'));
    }


    /**
     * @param RegisterAdminRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postRegister(RegisterAdminRequest $request)
    {
        $verifyToken = $this->generateToken();
        $newuser = new User;
        $newuser->name = $request->name;
        $newuser->email = $request->email;
        $newuser->password = bcrypt($request->password);
        $newuser->level = User::ADMIN;
        $newuser->active = User::DEACTIVE;
        $newuser->verify_token = $verifyToken;
        $newuser->save();
        $newuser->sendActiveAccount();
        return redirect('admin/dang-ky')->with('success','Đăng ký tài khoản thành công');
    }

    private function generateToken(){
        $verifyToken = Str::random(32);
        $userCheckToken = User::where(['verify_token' => $verifyToken])->count();
        if($userCheckToken == 0){
            return $verifyToken;
        }else{
            $this->generateToken();
        }

    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showChangePassword()
    {
        if (Auth::check()) {
            if (Auth::user()->level == User::SUBPER_ADMIN || Auth::user()->level == User::ADMIN) {
                return view('admin.user.change');
            }
        };
    }

    /**
     * @param ChangePasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postChangePassword(ChangePasswordRequest $request)
    {
        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Mật khẩu hiện tại không khớp với mật khẩu bạn đã cung cấp. Vui lòng thử lại.");
        }

        if(strcmp($request->get('current_password'), $request->get('new_password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","Mật khẩu mới không thể giống với mật khẩu hiện tại. Vui lòng chọn một mật khẩu khác.");
        }

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new_password'));
        $user->save();

        return redirect()->back()->with("success","Thay đổi mật khẩu thành công !");
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showForgotPassword()
    {
        return view('admin.user.email');
    }

    /**
     * @param ForgotPasswordRequest $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function postForgotPassword(ForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user){
            $user->sendResetPasswordEmail();
            return redirect('admin/quen-mat-khau')->with('success','Gửi Email thành công!');
        }
        return redirect('admin/quen-mat-khau')->with('error','Email không tồn tại trong hệ thống!');

    }

    /**
     * @param $token
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showResetPassword($token)
    {
        $user = User::where('remember_token', $token)->firstOrFail();
        if ($user) {
            return view('admin.user.reset', ['token' => $token]);
        }

    }

    /**
     * @param ResetPasswordRequest $request
     * @param $token
     * @return \Illuminate\Http\RedirectResponse
     */
    public function postResetPassword(ResetPasswordRequest $request, $token)
    {

        $password = bcrypt($request->new_password);
        if(User::where('remember_token', $token)->firstOrFail()->update(['password' => $password])){
            return redirect()->route('admin.getLogin')->with('success','Đổi mật khẩu thành công! Đăng nhập để thực hiện phiên làm viêc!');
        }else{
            return redirect()->route('admin.getLogin')->with('error','Đổi mật khẩu thất bại!');
        }
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(){
        Auth::logout();
        return redirect()->intended('admin/dang-nhap');
    }

    public function showProfile(Request $request){
        $user = User::where('id', Auth::user()->id)->firstOrFail();
        if (strtolower($request->method()) == 'post' ){
            $data = $request->all();
            unset($data['_token']);
            $user->avatar = $data['avatar'];
            $user->name = $data['name'];
            $user->bank = $data['bank'];
            $user->bank_code = $data['bank_code'];
            $user->save();
        }
        return view('admin.user.profile', ['user' => $user]);
    }

    public function activeAccount(Request $request, $token){
        dd($token);
    }

}
