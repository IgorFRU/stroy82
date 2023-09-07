<?php

namespace App\Http\Controllers;

use App\Currency;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CurrencyController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = array (
            'title'         => 'АДМИН - Паркетный мир - Валюты',
            'currencies'    => Currency::orderBy('id', 'DESC')
                                    ->paginate(10)
        );

        return view('admin.currencies.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array (            
            'title' => 'АДМИН - Паркетный мир - Добавление валюты',
            'currency' => [],
            'currencies' => Currency::get()
        );
        
        return view('admin.currencies.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'currency' => 'required|unique:currencies|min:3|max:3',
        ]);
        //метод для массовго заполнения

        Currency::create($request->all());
        
        return redirect()->route('admin.currencies.index')->with('success', 'Валюта успешно добавлена');
    }

    /**
     * Display the specified resource.
     *
     * @param  \app\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $currency)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \app\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function edit(Currency $currency)
    {
        $data = array (            
            'title' => 'АДМИН - Паркетный мир - редактирование валюты',
            'currency' => $currency
        );
        
        return view('admin.currencies.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \app\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Currency $currency)
    {
        $request->validate([
            'currency' => 'required|min:3|max:3',
        ]);
        
        $currency->update($request->all());

        return redirect()->route('admin.currencies.index')->with('success', 'Валюта успешно изменена');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \app\Currency  $currency
     * @return \Illuminate\Http\Response
     */
    public function destroy(Currency $currency)
    {
        $currency->delete();

        return redirect()->back()->with('success', 'Валюта успешно удалена');
    }
}
