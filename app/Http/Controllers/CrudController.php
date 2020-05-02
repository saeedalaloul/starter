<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CrudController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function getOffers()
    {
        return Offer::get();
    }

    public function store(Request $request)
    {
        $rules = $this->getRules();
        $messages = $this->getMessages();

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }
        Offer::create([
            'name' => $request['name'],
            'price' => $request['price'],
        ]);
        return redirect() -> back()->with(['success'=>'تم إضافة العرض بنجاح']);
    }

    public function create()
    {
        return view('offers.create');
    }

    protected function getMessages()
    {
        return [
            'name.required' => __('messages.offer name required'),
            'name.unique' => __('messages.offer name must be unique'),
            'price.required' => __('messages.Offer Price'),
        ];
    }

    protected function getRules()
    {
        return [
            'name' => 'required|max:100|unique:offers,name',
            'price' => 'required|numeric'
        ];
    }

}
