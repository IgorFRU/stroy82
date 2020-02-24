<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Setting;
use App\Admin;
use App\User;
use App\Order;
use App\Orderstatus;
use Auth;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $orderstatus = Orderstatus::first();
        if ($orderstatus == NULL) {
            $orderstatus = Orderstatus::create(
                [
                    'orderstatus'   => 'Ожидает обработки',
                    'color'         => '#ffed4a',
                    'icon'          => '<i class="fas fa-clock"></i>'
                ]
            );
        }

        $settings = Setting::first();
        if ($settings == NULL) {
            $settings = Setting::create(
                [
                    'site_name'        => 'Строительный магазин "Stroy82"',
                    'address'          => '',
                    'phone_main'       => '9788160166',
                    'phone_add'        => '',
                    'email'            => 'info@stroy82.com',
                    'viber'            => '',
                    'whatsapp'         => '',
                    'main_text'        => '',
                    'orderstatus_id'   => $orderstatus->id
                ]
            );
        }

        $data = [
            'title' => 'Главная страница административного раздела',
            'settings' => $settings,
            'one_admin' => Auth::user(),
            'admins' => Admin::get(),
            'orders' => Order::unreadlast(5)->get(),
            'users' => User::last(5)->get(),
        ];

        // dd(Order::unread()->get()->limit(5));
        // dd($data['settings']);
        return view('admin', $data);
        // echo ('is admin');
    }

    public function settings(Request $request) {
        // dd($request->all());
        $settings = Setting::first();
        $settings->update($request->except(['phone_main', 'phone_add']));

        if (isset($request->phone_main)) {
            $phone_main = str_replace(array('+','-', '(', ')', ' '), '', $request->phone_main);
            if (strlen($phone_main) == 11) {
                $phone_main = substr($phone_main, 1);
            }
           $settings->phone_main = $phone_main;
        }
        
        if (isset($request->phone_add)) {
            $phone_add = str_replace(array('+','-', '(', ')', ' '), '', $request->phone_add);
            if (strlen($phone_add) == 11) {
                $phone_add = substr($phone_add, 1);
            }
           $settings->phone_add = $phone_add;
        }

        $settings->update([
            'phone_main' => $phone_main,
            'phone_add' => $phone_add,
        ]);

        return redirect()->route('admin.index');
    }

    public function profile() {
        
        $data = [
            'title' => 'Редактирование своего профиля',
            'user' => Auth::user(),
        ];

        return view('admin.admin.edit', $data);
    }

    public function profileUpdate(Request $request) {
        $user = Auth::user();
        $messages = [
            'email.unique' => 'Данный e-mail адрес уже занят другим администратором!',
            'email.required' => 'Необходимо указать e-mail адрес!',
            'password.min' => 'Пароль не должен быть короче 8 символов!',
            'password.confirmed' => 'Пароли не совпадают. Подтвердите пароль!',
            'name.required' => 'Необходимо указать имя!',
            'name.string' => 'Имя должно быть строковым!',
        ];

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                \Illuminate\Validation\Rule::unique('admins')->ignore($user->id),
            ],
            'password' => 'nullable|string|min:8|confirmed',
        ], $messages)->validate();

        $user->name = $request->name;
        $user->email = $request->email;
        if ($request->password != NULL) {
            $user->password = Hash::make($request->password);
        } 
        $user->save();        
        
        return redirect()->route('admin.index')->with('success', 'Ваш профиль, <strong>'. $user->name .'</strong>, успешно изменён!'); 
    }
}
