<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        $messages = [
            'email.unique' => 'Данный e-mail адрес уже занят другим пользователем!',
            'email.required' => 'Для входа в аккаунт используется e-mail адрес!',
            'name.required' => 'Поле "имя" обязательно для заполнения!',
            'name.max' => 'Имя должно быть короче 255 символов!',
            'surname.max' => 'Фамилия должна быть короче 255 символов!',
            'address.max' => 'Адрес должен быть короче 255 символов!',
            'phone.required' => 'Необходимо заполнить поле "номер телефона"!',
            'password.required' => 'Придумайте пароль для пользователя!',
            'password.min' => 'Пароль не должен быть короче 8 символов!',
            'password.confirmed' => 'Пароли не совпадают. Подтвердите пароль!',
            'name.required' => 'Необходимо указать имя пользователя!',
            'name.string' => 'Имя пользователя должно быть строковым!',
        ];

        $phone = str_replace(array('+','-', '(', ')'), '', $data['phone']);
        if (strlen($phone) == 11) {
            $phone = substr($phone, 1);
        }

        $user_id = User::where('phone', $phone)->where('quick', 1)->first();
        // dd($phone, $user_id);
        if ($user_id) {
            $user_id = $user_id->id;
        } else {
            $user_id = -1;
        }

        // dd($phone, $user_id);
        
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],            
            'surname' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('users')->ignore($user_id),
            ],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], $messages);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\Admin
     */
    protected function create(array $data)
    {
        $phone = str_replace(array('+','-', '(', ')'), '', $data['phone']);
        if (strlen($phone) == 11) {
            $phone = substr($phone, 1);
        }

        $user = User::where('phone', $phone)->where('quick', 1)->first();
        // dd($phone);
        // dd($user);
        if ($user) {
            $user->update([
                'quick' => 0,
                'name' => $data['name'],
                'surname' => $data['surname'],
                'address' => $data['address'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
            ]);
        } else {
            $user = User::create([
                'name' => $data['name'],
                'surname' => $data['surname'],
                'address' => $data['address'],
                'email' => $data['email'],
                'phone' => $data['phone'],
                'password' => Hash::make($data['password']),
            ]);
        }
        // dd($data);
        
        return $user;
    }
}
