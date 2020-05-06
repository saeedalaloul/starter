<?php

namespace App\Http\Controllers;

use App\Http\Requests\OfferRequest;
use App\Models\Offer;
use App\Traits\OfferTrait;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class CrudController extends Controller
{
    use OfferTrait;


    public function __construct()
    {
    }

    public function getOffers()
    {
        return Offer::get();
    }

    public function store(OfferRequest $request)
    {
        $file_name =  $this -> saveImage($request -> photo,'images/offers');

        Offer::create([
            'photo' => $file_name,
            'name_ar' => $request->name_ar,
            'name_en' => $request->name_en,
            'price' => $request->price,
            'details_ar' => $request->details_ar,
            'details_en' => $request->details_en,
        ]);

        return redirect()->back()->with(['success' => 'تم اضافه العرض بنجاح ']);
    }

    public function getAllOffers()
    {
        $offers = Offer::select('id',
            'price',
            'photo',
            'name_' . LaravelLocalization::getCurrentLocale() . ' as name',
            'details_' . LaravelLocalization::getCurrentLocale() . ' as details'
        )->get(); // return collection
        return view('offers.all', compact('offers'));
    }

    public function create()
    {
        return view('offers.create');
    }

    public function edit($offer_id)
    {
        $offer = Offer::find($offer_id);
        if (!$offer)
            return redirect()->back();

        $offer = Offer::select('id', 'name_ar', 'name_en', 'details_ar', 'details_en', 'price')->find($offer_id);
        return view('offers.edit', compact('offer'));
    }

    public function UpdateOffer(OfferRequest $request)
    {
        //validtion

        // chek if offer exists

        $offer = Offer::find($request -> id);
        if (!$offer)
            return redirect()->back();

        //update data

        $offer->update($request->all());

        return redirect()->back()->with(['success' => ' تم التحديث بنجاح ']);

        /*  $offer->update([
              'name_ar' => $request->name_ar,
              'name_en' => $request->name_en,
              'price' => $request->price,
          ]);*/
    }
}
