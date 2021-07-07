<?php

namespace App\Http\Controllers;

use App\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = ' | Currency List';
        $currencies = Currency::all();

        return view('currency.currency_list', compact('title', 'currencies'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = ' | Create Currency';

        return view('currency.create_currency', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'currency' => 'required|unique:currencies',
            'status' => 'required',
        ]);

        Currency::create([
            'currency' => $request->currency,
            'status' => $request->status,
        ]);

        return redirect()->back()->with('success', 'Currency Successfully Created!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $title = ' | Edit Currency';
        $currency = Currency::find($id);

        return view('currency.edit_currency', compact('title', 'currency'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'currency' => 'required|unique:currencies,currency,'.$id,
            'status' => 'required',
        ]);

        $currency = Currency::find($id);
        $currency->currency = $request->currency;
        $currency->status = $request->status;
        $currency->save();

        return redirect()->back()->with('success', 'Currency Successfully Updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
