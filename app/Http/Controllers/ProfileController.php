<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Auth, Hash};
use Illuminate\Validation\Rules\Password;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Validation\Rule;
use Image;

class ProfileController extends Controller
{
    /**
     * Path for user avatar file.
     *
     * @var string
     */
    protected $avatarPath = '/uploads/avatars/';

    public function index()
    {
        $user = auth()->user();

        return view('admin.profile.index', compact('user'));
    }

    public function updatePassword(User $user, Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    return $fail(__('Password saat ini tidak sesuai'));
                }
            }],
            'password' => [
                'required',
                'string',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols()
                    ->uncompromised()
            ],
        ]);

        $user->forceFill([
            'password' => Hash::make($request['password']),
        ])->save();

        Auth::logoutOtherDevices($request['password']);
        Auth::logout();
    }

    public function updateProfile(User $user, Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'avatar' => ['nullable', 'image', 'max:1024']
        ]);

        if (isset($request['avatar']) && $request['avatar']->isValid()) {

            $filename = $request['avatar']->hashName();

            if (!file_exists($path = public_path($this->avatarPath))) {
                mkdir($path, 0777, true);
            }

            Image::make($request['avatar']->getRealPath())->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            })->save(public_path($this->avatarPath) . $filename);

            // delete old avatar from storage
            if ($user->avatar != null && file_exists(public_path($this->avatarPath . $user->avatar))) {
                unlink(public_path($this->avatarPath . $user->avatar));
            }

            $user->forceFill([
                'avatar' => $filename,
            ])->save();
        }

        if ($request['email'] !== $user->email && $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $request);
        } else {
            $user->forceFill([
                'name' => $request['name'],
                'email' => $request['email'],
            ])->save();
        }

        return redirect()->back();
    }
}
