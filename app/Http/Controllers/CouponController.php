<?php

namespace App\Http\Controllers;

use App\Http\Requests\CouponStoreRequest;
use App\Http\Resources\CouponResource;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {

        $coupons = Coupon::latest()->paginate(10);
        // foreach ($coupons as $coupon) {
        //     if($coupon->coupon_validity >= Carbon::now()->format('Y-m-d')){
        //         $coupon->coupon_status = 1;
        //     }else{
        //         $coupon->coupon_status = 0;
        //     }
        //     $coupon->save();
        // }
        return view('Coupons.index', compact('coupons'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('Coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        Coupon::create([
            'coupon_name' => strtoupper($request->input('coupon_name')),
            'coupon_discount' => $request->input('coupon_discount'),
            'coupon_validity' => $request->input('coupon_validity'),
            'coupon_status' => $request->input('coupon_status'),
        ]);

        $notification = [
            'message' => 'Coupon Created Successfully!!!',
            'alert-type' => 'success'
        ];

        return redirect()->route('coupons.index')->with($notification);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\Response
     */
    public function show(Coupon $coupon)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $coupon = Coupon::findOrFail($id);
        return view('Coupons.edit', compact('coupon'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(CouponStoreRequest $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->update([
            'coupon_name' => strtoupper($request->input('coupon_name')),
            'coupon_discount' => $request->input('coupon_discount'),
            'coupon_validity' => $request->input('coupon_validity'),
            'coupon_status' => $request->input('coupon_status'),
        ]);

        $notification = [
            'message' => 'Coupon Updated Successfully!!!',
            'alert-type' => 'success'
        ];

        return redirect()->route('coupons.index')->with($notification);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coupon  $coupon
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id)->delete();
        $notification = [
            'message' => 'Coupon Deleted Successfully!!!',
            'alert-type' => 'success'
        ];

        return redirect()->route('coupons.index')->with($notification);
    }

    public function couponCheck($code)
    {
        $coupon = Coupon::where("coupon_code", $code)->first();
        if($coupon->coupon_validity >= Carbon::now()->format('d/m/Y')) {
            if($coupon->coupon_status == 1) {
                return new CouponResource($coupon);
            } else {
                return response()->json(['error' => 'Coupon is not valid']);
            }
        }else{
            return response()->json(['error' => 'Coupon Expired!!!']);
        }

    }
    public function changeCouponStatus(Request $request)
    {
        //dd($request->all());
        $coupon = Coupon::findOrFail($request->coupon_id);
        $coupon->coupon_status = $request->status;
        $coupon->save();

        return response()->json(['success'=>'Coupon status change successfully.']);
    }
}
