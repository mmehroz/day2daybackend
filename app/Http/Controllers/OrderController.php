<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItems;
use Carbon\Carbon;
use Illuminate\Http\Request;
use DB;
use PDF;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        // dd("test");
        $orders = Order::latest('id')->get();
        return view('Orders.index', compact(
            'orders'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        $order = Order::whereId($order->id)
            ->first();
        $orderItems = DB::table('orderdetails')
        ->select('*')
        ->where('order_id','=',$order->id)
        ->where('deleted_at','=',null)
        ->get();
        // $orderItems = OrderItems::where('order_id', $order->id)
        //     ->with('product')
        //     ->orderBy('id', 'DESC')->get();

        return view('Orders.show', compact(
            'order',
            'orderItems'
        ));
    }

    public function orderStatusUpdate($order_id, $status)
    {
        $order = Order::whereId($order_id)->first()->update([
            'status' => $status,
        ]);


        $notification = [
            'message' => 'Order '.$status,
            'alert-type' => 'success'
        ];

        return back()->with($notification);
    }

    public function adminInvoiceDownload($order_id)
    {
        $order = Order::whereId($order_id)->first();
        $orderItems = OrderItems::where('order_id', $order->id)->orderBy('id', 'DESC')->get();

        $pdf = PDF::loadView('Orders.invoice-download', compact('order','orderItems'))
            ->setPaper('a4')
            ->setOptions([
                'tempDir' => public_path(),
                'chroot' => public_path(),
            ]);
        return $pdf->download('invoice.pdf');
    }

}
