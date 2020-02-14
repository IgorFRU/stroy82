<?php

namespace App\Http\Controllers;

use App\Discount;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DiscountController extends Controller
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
        $today = Carbon::now();
        $data = array (
            'title' => 'Скидки и акции',
            'discounts' => Discount::where('discount_end', '>', $today)->orderBy('discount_start', 'DESC')->get(),
            // 'numeral' => Discount::where([
            //                 'discount_end', '>', $today,
            //                 'type', '%'
            //             ])->numeral();
            'today' => $today,
            'actually' => true,
        );
        return view('admin.discounts.index', $data);
    }

    public function archive()
    {
        $today = Carbon::now();
        $data = array (
            'title' => 'Архив акций',
            'discounts' => Discount::where('discount_end', '<', $today)->orderBy('discount_start', 'DESC')->get(),
            'today' => $today,
            'actually' => false,
        );

        return view('admin.discounts.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = array (
            'title' => 'Новая акция',
            'discount' => [],
        );
        
        return view('admin.discounts.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $discount = Discount::create($request->all());
        
        return redirect()->route('admin.discounts.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function show(Discount $discount)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function edit(Discount $discount)
    {
        $data = array (
            'title' => 'Редактирование акции',
            'discount' => $discount
        );
        
        return view('admin.discounts.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Discount $discount)
    {
        // $discount->update($request->except('alias'));
        $discount->update($request->all());

        return redirect()->route('admin.discounts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Discount  $discount
     * @return \Illuminate\Http\Response
     */
    public function destroy(Discount $discount)
    {
        $discount->delete();
        return redirect()->route('admin.discounts.index');
    }
}
