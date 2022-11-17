<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Vendor;
use App\Models\Invoice;
use App\Models\Purchase;
use App\Models\Product;
use App\Models\User;
use App\Models\PurchaseDetail;
use App\Models\ProductSerial;
use App\Models\Customer;
use App\Models\InvoiceDetail;
use App\Models\InvoicePayment;
use App\Models\AccountPayable;
use App\Models\AccountReceivable;
use App\Models\Coupen;
use App\Models\Country;
use App\Models\CustomerCategory;
use App\Models\RetailerCustomer;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
use App\Models\VoidInvoices;
use App\Models\VoidInvoiceDetails;
use Response;
use Auth;
use DB;
use App\Helpers\Apihelper;
use Storage;
use App\Models\CustomerBalance;
use App\Models\PurchaseReceiveDetails;
use Carbon\Carbon;



class InvoiceController extends Controller
{
    public function index(){

        // $paid = AccountReceivable::orderby('id', 'DESC')->get();
        $role = Auth::user()->role_id;
        $invoices = Invoice::orderBy('id','DESC')->get();
        return view('invoice.index')->with(compact('invoices', 'role'));
    }

    public function create(){
        $customerCatlist = CustomerCategory::get();
        $countries = Country::get();
        $products = Product::orderBy('id','DESC')->get();
        $customers = Customer::with('retailer')->orderby('id', 'DESC')->get();
        // dd($customers);die;
        // dd($emails);die;

        return view('invoice.create')->with(compact('customerCatlist','customers','products', 'countries'));
    }

    public function store(Request $request){

        //echo public_path().'/invoice-pdf/invoice.pdf';die();

        // echo 'Final Amount ';
        // print_r($request->final_amount);
        // echo '<br/>';
        // echo 'additional amount ';
        // return view('preview');
        // die();
        //print_r($request->all());die();
        $customerData = Customer::where('id',$request->customer)->first();
        //$invoice = Invoice::get()->first();
        $request->validate([
            // 'customer_type'    =>  'required',
            'customer'    =>  'required',
            'sku_id'    =>  'required',
            'shipping_cost'    =>  'required',
            'type'     =>  'required',
        ]);


        $invoice = Invoice::create([
            'user_id' => Auth::user()->id,
            'customer' => $request->customer,
            'invoice_no' => '',
            'customer_type' => $request->customer_type,
            'coupon_id' => $request->discount_id,
            'payment_type' => $request->payment_type,
            'sub_total' => $request->sub_total,
            'shipping_cost' => $request->shipping_cost,
            'tax_amount' => $request->tax_amount,
            'discount_amount' => $request->discount_amount,
            'final_amount' => $request->final_amount,
            'note' => $request->note,
            'status' => '',
            'tracking_num' => $request->tracking_num
        ]);

        $invoicePayment = InvoicePayment::create([
            'invoice_id' => $invoice->id,
            'amount' => ($request->final_amount - $request->additional_amount),
            'payment_type' => $request->payment_type
        ]);

        if($request->additional_amount){
            $invoicePayment = InvoicePayment::create([
                'invoice_id' => $invoice->id,
                'amount' => $request->additional_amount,
                'payment_type' => $request->invoice_payment_type
            ]);
        }

        // if ($invoice->payment_type == 5) {
        //     $invoice->status = 'unpaid';
        // }else{
        //     $invoice->status = 'paid';
        // }
        // $invoice->save();

        // $userid = Auth::user()->id;
        // dd($userid);die;


        $invoice_number = 'inv-';
        for ($i=0; $i < (6 - strlen($invoice->id)); $i++) {
            $invoice_number .= '0';
        }
        $invoice_number .= $invoice->id;
        $invoice->invoice_no = $invoice_number;
        $invoice->save();
        // echo $invoice->id.'<br>';
        // print_r($invoice_number);die;


        if ($invoice->payment_type == 5) {
            $PA = $request->final_amount - $request->additional_amount;
            $cr = CustomerBalance::where('customer_id', $request->customer)->first();
            if($cr){
                if($cr->balance > $PA){
                    $cr->balance = $cr->balance - $PA;
                    $cr->save();
                    $PA = 0;
                }
                else{
                    $PA -= $cr->balance;
                    $cr->delete();
                }
            }
            if ($PA > 0) {
                $accountReceivable = AccountReceivable::create([
                    'customer' => $request->customer,
                    // 'invoice_no' => date("Ymdhis"),
                    'invoice_id' => $invoice->id,
                    'pending_amount' => ($request->final_amount - $request->additional_amount),
                    'final_amount' => ($request->final_amount - $request->additional_amount)
                ]);
                $invoice->status = 'unpaid';
            }else{
                $invoice->status = 'paid';
            }
        }else{
            $invoice->status = 'paid';
        }
        $invoice->save();

        foreach ($request->sku_id as $key => $value) {
            InvoiceDetail::create([
                'invoice_id' => $invoice->id,
                'sku_id' => $value,
                'quantity' => $request->quantity[$key],
                'cost' => $request->cost[$key],
                // 'shipping_cost' => $request->shipping_cost,
                'serial_num' => $request->serial_num[$key],
                'type' => $request->type[$key],
            ]);
            $product = Product::where('id', $value)->first();
            $product->quantity = $product->quantity - $request->quantity[$key];
            $product->save();


            $serials = explode(',', $request->serial_num[$key]);
            ProductSerial::whereIn('product_serial', $serials)->where('product_id', $value)->delete();


            $product = Product::where('id', $value)->first();
            $serial_num = ProductSerial::where('product_id', $value)->pluck('product_serial')->toArray();
            $data = array(
                'qty' => $product->quantity,
                'sku' => $product->sku,
                'serial_num' => implode(',', $serial_num)
            );
            $web_id = Apihelper::productQty($data);
        }
        //--------UNCOMMENT TO ENABLE EMAIL----------//

        //email
        // $details = [
        //     'title' => 'Mail from WAVE-POS',
        //     'body' => 'This is for testing Email'
        // ];
        // Mail::to($customerData)->send(new Testmail($details));

        $this->mail($invoice->id);
        //return $pdf->download(public_path().'/invoice-pdf/'.$invoice->id.'.pdf');
        //print_r($request->all());die();

        return redirect('invoice')->with('success', 'Record created successfully.');
    }
    public function edit($id)
    {
        $invoice = Invoice::with('invoiceDetails.sku_name', 'customer_name','invoicePayment', 'accountReceivable', 'user_name','coupen','InvoiceReturn.Invoice_Return_Details.invoiceDetails.sku_name')->findOrFail($id);

        $customerCatlist = CustomerCategory::get();
        $countries = Country::get();

        $customers = Customer::with('retailer')->orderby('id', 'DESC')->get();
        $products = Product::orderBy('id','DESC')->get();
        //print_r($invoice->invoicePayment->pluck('payment_type')->toArray()[0]);
        // print_r($invoice->invoicePayment->pluck('amount')->toArray());die();
        return view('invoice.edit')->with(compact('invoice','customerCatlist','products', 'countries','customers'));
    }
    public function update(Request $request, $id)
    {

        $invoicedetails = InvoiceDetail::where('invoice_id', $id)->get();

        foreach ($invoicedetails as $key => $invoiceD) {


            $product = Product::where('id', $invoiceD->sku_id)->first();
            $product->quantity = $product->quantity + $invoiceD->quantity;
            $product->save();

            $serials = explode(',', $invoiceD->serial_num);
            foreach ($serials as $value) {
                ProductSerial::create([
                    'product_id' => $invoiceD->sku_id,
                    'product_serial' => $value
                ]);
            }
            $product = Product::where('id', $invoiceD->sku_id)->first();
            $serial_num = ProductSerial::where('product_id', $invoiceD->sku_id)->pluck('product_serial')->toArray();
            $data = array(
                'qty' => $product->quantity,
                'sku' => $product->sku,
                'serial_num' => implode(',', $serial_num)
            );
            $web_id = Apihelper::productQty($data);
        }


        InvoiceDetail::where('invoice_id', $id)->forceDelete();

        $form_data = array(
            'customer' => $request->customer,
            'coupon_id' => $request->discount_id,
            'discount_amount' => $request->discount_amount,
            'shipping_cost' => $request->shipping_cost,
            'sub_total' => $request->sub_total,
            'tax_amount' => $request->tax_amount,
            'note' => $request->note,
            'final_amount' => $request->final_amount
        );

        Invoice::whereId($id)->update($form_data);

        foreach ($request->sku_id as $key => $value) {
            InvoiceDetail::create([
                'invoice_id' => $id,
                'sku_id' => $value,
                'quantity' => $request->quantity[$key],
                'cost' => $request->cost[$key],
                'serial_num' => $request->serial_num[$key],
                'type' => $request->type[$key],
            ]);


            $product = Product::where('id', $value)->first();
            $product->quantity = $product->quantity - $request->quantity[$key];
            $product->save();

            $serials = explode(',', $request->serial_num[$key]);
            ProductSerial::whereIn('product_serial', $serials)->where('product_id', $value)->delete();

            $product = Product::where('id', $value)->first();
            $serial_num = ProductSerial::where('product_id', $value)->pluck('product_serial')->toArray();
            $data = array(
                'qty' => $product->quantity,
                'sku' => $product->sku,
                'serial_num' => implode(',', $serial_num)
            );
            $web_id = Apihelper::productQty($data);
        }

        //print_r($request->all());die();
        return redirect('/invoice')->with('Update', 'Invoice has been Updated!');
    }
    public function show($id)
    {
        // $purchaseDetails = PurchaseDetail::where('purchase_id', $id)->first();
        // $purchaseDetail = PurchaseDetail::where('purchase_id', $id)->first();
        // dd($purchaseDetails);die;
        $invoice = Invoice::with('invoiceDetails.sku_name', 'customer_name', 'accountReceivable', 'user_name','InvoiceReturn.Invoice_Return_Details.invoiceDetails.sku_name')->findOrFail($id);
        // dd($invoice);die;
        return view('invoice.show', compact('invoice'));
    }

    // public function subCat(Request $request)
    // {
    //     $category_id = $request->cat_id;

    //     $subcategories = Cattype::where('category_id',$category_id)->get();
    //     return response()->json([
    //         'subcategories' => $subcategories
    //     ]);
    // }
    public function ajaxserial(Request $request)
    {
        //print_r($request->product_id);die();
        $success = true;
        $faildSerails = [];
        $serials = explode(',', $request->value);
        foreach ($serials as $key => $serial) {
            $productserial = ProductSerial::where("product_id", $request->product_id)->where('product_serial', $serial)->first();
            if (!$productserial) {
                $success = false;
                $faildSerails[] = $serial;
            }
        }
        return response()->json([
            'success' => $success,
            'faildSerails' => $faildSerails
        ]);
        // $productserial = ProductSerial::where("product_id", "=", $request->product_id)->get();


        //echo $productserial;
        //$success = false;
        //die();

    }

    public function returnserial(Request $request)
    {
        //print_r($request->product_id);die();
        $success = true;
        $faildSerails = [];
        $serials = explode(',', $request->value);
        foreach ($serials as $key => $serial) {
            $productserial = InvoiceDetail::where("invoice_id", $request->invoice_id)->where("sku_id", $request->product_id)->where('serial_num', "22,33")->first();
            if (!$productserial) {
                $success = false;
                $faildSerails[] = $serial;
            }
        }
        return response()->json([
            'success' => $success,
            'faildSerails' => $faildSerails
        ]);

    }

    public function invoicereporting(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $customer = $request->customer_id;
        $user_id = $request->sale_person;
        $type = $request->type;

        $users = User::orderBy('id','DESC')->get();
        $customers = Customer::orderBy('id','DESC')->get();
        $invoices = Invoice::with('customer_name','user_name','invoiceDetails.sku_name')->orderBy('id','DESC')
            ->addSelect(['pending' => AccountReceivable::selectRaw('pending_amount')
                ->whereColumn('invoice_id', 'invoice.id')

            ])
            ->addSelect(['limit' => RetailerCustomer::selectRaw('credit_line_in_days')
                ->whereColumn('retailer_customer.customer_id', 'invoice.customer')

            ])
            ->when($customer, function ($q) use ($customer) {
                return $q->where('customer', $customer);
            })
            ->when($user_id, function($q) use ($user_id) {
                return $q->where('user_id', $user_id);
            })
            ->when($start_date, function($q) use ($start_date) {
                return $q->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function($q) use ($end_date) {
                return $q->whereDate('created_at', '<=', $end_date);
            })
            ->when($type, function($q) use ($type) {
                if($type == 1){
                    return $q->having('pending', '>', 0);
                }
                else{
                    return $q->having('pending', Null)->orHaving('pending', '')->orHaving('payment_type', '!=', 5);
                }
            })
            ->get();

        return view('invoice.reporting')->with(compact('customers','users','invoices','type','start_date','end_date','customer','user_id'));
    }

    public function custom(Request $request)
    {
        $customer_id = $request->custom_id;

        $customers = Customer::where('customer_type',$customer_id)->get();
        return response()->json([
            'customers' => $customers
        ]);
    }

    public function discountcoupon(Request $request)
    {
        $success = true;
        $message = '';
        $class = '';
        $coupen = Coupen::where([
            ['code', '=', $request->get('coupon_id')],
            ['status', '=', 1]
        ])->first();
        $message = '';
        $class = 'alert alert-success';
        if($coupen) {
            $customer = Invoice::where([
                ['customer', '=', $request->get('customer_id')],
                ['coupon_id', '=', $coupen->id]
            ])->count();
            $invoice = Invoice::where('coupon_id', '=', $coupen->id)->count();

            if($coupen->start_date && $coupen->end_date && (strtotime($coupen->start_date) > strtotime(date('Y-m-d')) || strtotime($coupen->end_date) < strtotime(date('Y-m-d')))){
                $success = false;
                $message = 'Coupon Expired';
                $class = 'alert alert-danger';
            }
            elseif($coupen->usage_limit_per_customer && $customer >= $coupen->usage_limit_per_customer){
                $success = false;
                $message = 'Your usage limit is completed';
                $class = 'alert alert-danger';
            }

            elseif($coupen->usage_limit_per_coupen && $invoice >= $coupen->usage_limit_per_coupen){
                $success = false;
                $message = 'Usage limit is completed';
                $class = 'alert alert-danger';
            }
        }
        else{
            $success = false;
            $message = 'Invalid Coupon';
            $class = 'alert alert-danger';
        }

        if ($success) {
            return Response::json(['success' => $success, 'message' => 'Coupon has applied', 'data' => $coupen, 'class' => $class]);
        }
        else{
            return Response::json(['success' => $success,'message' => $message, 'class' => $class]);
        }

    }


    public function VoidDelete($id)
    {
        $user_id = Auth::id();
        $invoice = Invoice::where('id', $id)->first();
        $invoicedetails = InvoiceDetail::where('invoice_id', $id)->get();
        $AccountReceivable = AccountReceivable::where('invoice_id', $id)->delete();
        //print_r($AccountReceivable->id);die();
        // if ($AccountReceivable) {

        //     Invoice::where('id', $id)->delete();
        //     $AccountReceivable = AccountReceivable::find($AccountReceivable->id);
        //     $AccountReceivable->pending_amount = '0';
        //     $AccountReceivable->update();
        // }
        //print_r($AccountReceivable);die();

        $VoidInvoices = VoidInvoices::create([
            'user_id' => $user_id,
            'customer' => $invoice->customer,
            'customer_type' => ($invoice->customer_type == null) ? '0' : 1,
            'invoice_no' => $invoice->invoice_no,
            'coupon_id' => $invoice->coupon_id,
            'payment_type' => $invoice->payment_type,
            'tracking_num' => $invoice->tracking_num,
            'discount_amount' => $invoice->discount_amount,
            'shipping_cost' => $invoice->shipping_cost,
            'sub_total' => $invoice->sub_total,
            'tax_amount' => $invoice->tax_amount,
            'final_amount' => $invoice->final_amount,
            'note' => $invoice->note,
            'status' => $invoice->status
        ]);

        foreach ($invoicedetails as $key => $invoiceD) {

            //print_r($invoiceD->serial_num);die();
            VoidInvoiceDetails::create([
                'invoice_id' => $VoidInvoices->id,
                'sku_id' => $invoiceD->sku_id,
                'quantity' => $invoiceD->quantity,
                'cost' => $invoiceD->cost,
                'serial_num' => $invoiceD->serial_num,
                'type' => $invoiceD->type
            ]);

            $product = Product::where('id', $invoiceD->sku_id)->first();
            $product->quantity = $product->quantity + $invoiceD->quantity;
            $product->save();

            $serials = explode(',', $invoiceD->serial_num);
            foreach ($serials as $value) {
                ProductSerial::create([
                    'product_id' => $invoiceD->sku_id,
                    'product_serial' => $value
                ]);
            }
            $product = Product::where('id', $invoiceD->sku_id)->first();
            $serial_num = ProductSerial::where('product_id', $invoiceD->sku_id)->pluck('product_serial')->toArray();
            $data = array(
                'qty' => $product->quantity,
                'sku' => $product->sku,
                'serial_num' => implode(',', $serial_num)
            );
            $web_id = Apihelper::productQty($data);
        }

        Invoice::where('id', $id)->delete();
        InvoiceDetail::where('invoice_id', $id)->delete();


        return redirect('/invoice')->with('delete', 'Invoice has been moved to trash!');
    }

    public function void(){

        $invoices = VoidInvoices::orderBy('id','DESC')->get();
        return view('invoice.void')->with(compact('invoices'));
    }

    public function invoiceReturn($id)
    {
        $invoice = Invoice::with('invoiceDetails.sku_name', 'customer_name.retailer', 'accountReceivable', 'user_name')->findOrFail($id);
        $vendors = Vendor::get();
        $customerCatlist = CustomerCategory::get();
        $countries = Country::get();
        //print_r($invoice->invoiceDetails);die();
        return view('invoice-return.form', compact('invoice','customerCatlist', 'countries', 'vendors'));
    }

    public function voidview($id)
    {
        $invoice = VoidInvoices::with('invoiceDetails.sku_name', 'customer_name', 'accountReceivable', 'user_name')->findOrFail($id);
        return view('invoice.voidview', compact('invoice'));
    }

    public function voidreporting(Request $request)
    {
        $start_date = $request->start_date;
        $end_date = $request->end_date;
        $customer = $request->customer_id;
        $user_id = $request->sale_person;

        $users = User::orderBy('id','DESC')->get();
        $customers = Customer::orderBy('id','DESC')->get();
        $invoices = VoidInvoices::with('customer_name','user_name')->orderBy('id','DESC')
            ->when($customer, function ($q) use ($customer) {
                return $q->where('customer', $customer);
            })
            ->when($user_id, function($q) use ($user_id) {
                return $q->where('user_id', $user_id);
            })
            ->when($start_date, function($q) use ($start_date) {
                return $q->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date, function($q) use ($end_date) {
                return $q->whereDate('created_at', '<=', $end_date);
            })
            ->get();

        return view('invoice.void-reporting')->with(compact('customers','users','invoices','start_date','end_date','customer','user_id'));
    }

    public function serialsearch(Request $request)
    {
        $success = false;
        $html = '';
        if($request->serial_num){
            $indetail = InvoiceDetail::whereRaw("FIND_IN_SET('". $request->serial_num ."',serial_num)")->first();
            $serial = ProductSerial::where('product_serial',$request->serial_num)->first();

            $getpurchasesid = PurchaseReceiveDetails::whereRaw('FIND_IN_SET(?,serial)', [$request->serial_num])->first();
            //$getpurchasesid = PurchaseDetail::where('sku_id','=', $request->sku_id)->first();
            if (isset($getpurchasesid->purchase_rec->purchase_id)) {
                $purchasesid = $getpurchasesid->purchase_rec->purchase_id;
            }else{
                $purchasesid = 0;
            }
            if($indetail){
                $invoice = Invoice::where('id',$indetail->invoice_id)->first();
                $product = Product::with('productSerials')->where('id', $indetail->sku_id)->first();
                //print_r($product->productSerials);die();
                $success = true;
                $html = (string)view('invoice/serialshow', compact('invoice','product', 'purchasesid'));
            }
            elseif($serial){
                $serialno = $request->serial_num;
                $product = Product::with('productSerials')->where('id', $serial->product_id)->first();
                //print_r($product->productSerials);die();
                $success = true;
                $html = (string)view('invoice/serialshow2', compact('product', 'serialno' , 'purchasesid'));
            }
            else{
                $product = Product::with('productSerials')->where('name', $request->serial_num)->orWhere('sku', $request->serial_num)->orWhere('barcode', $request->serial_num)->first();
                if($product){
                    $indetail = InvoiceDetail::where('sku_id',$product->id)->pluck('invoice_id')->toArray();
                    $invoices = Invoice::whereIn('id',$indetail)->get();
                    $success = true;
                    $html = (string)view('invoice/multi_invoice_serialshow', compact('invoices','product', 'purchasesid'));
                }
            }
            //$html = $request->serial_num;
            return Response::Json(['success' => $success,'html' => $html]);
        }
        else{
            return view('invoice.serialsearch');
        }


    }

    public function sendmail($id)
    {
        // $purchase = Purchase::where('id',$id)->with('purchaseDetails.sku_name', 'vendor_name')->first();
        // $purchase_rel = Purchase::with('purchaseDetails.sku_name', 'vendor_name')->findOrFail($purchase->id);
        // $data = [
        //   'subject' => 'Order Invoice',
        //   'email' => $purchase_rel->vendor_name->email,
        //   'content' => 'Purchase Order',
        //   'purchase' => $purchase,
        //   'purchase_rel' => $purchase_rel
        // ];
        $invoice = Invoice::with('invoiceDetails.sku_name', 'customer_name', 'accountReceivable', 'user_name')->findOrFail($id);


        //print_r($invoice->accountReceivable);die;
        //PDF::setOptions(['dpi' => 150, 'defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('invoice/pdf', compact('invoice'))->setPaper('a4', 'landscape')->save(public_path().'/invoice-pdf/'.'INV-0000'.$invoice->id.'.pdf');
        //return PDF::loadFile(public_path().'/invoice-pdf/'.'INV-0000'.$invoice->id.'.pdf')->stream('download.pdf');
        //echo $pdf->output();die;
        //$attach =public_path().'/invoice-pdf/'.$invoice->id.'.pdf';

        //Storage::put(public_path().'/invoice-pdf/invoice.pdf', $pdf->output());



        $data = [
            'subject' => 'Order Invoice',
            'email' => $invoice->customer_name->email,
            //'email' => 'usama.webewox@gmail.com',
            'invoice' => $invoice,
        ];

        $file = public_path('/invoice-pdf/'.'INV-0000'.$invoice->id.'.pdf');

        //return view('invoice/email-template')->with(compact('invoice'));
        // print_r($data);die;
        Mail::send('invoice/email-template', $data, function($message) use ($data, $file) {
            $message->to($data['email'])
                ->subject($data['subject']);

            $message->attach($file);

        });
        return redirect()->back();

        // return redirect('purchase')->with('success', 'Email sent successfully');
    }

    public function mail($id)
    {
        // $purchase = Purchase::where('id',$id)->with('purchaseDetails.sku_name', 'vendor_name')->first();
        // $purchase_rel = Purchase::with('purchaseDetails.sku_name', 'vendor_name')->findOrFail($purchase->id);
        // $data = [
        //   'subject' => 'Order Invoice',
        //   'email' => $purchase_rel->vendor_name->email,
        //   'content' => 'Purchase Order',
        //   'purchase' => $purchase,
        //   'purchase_rel' => $purchase_rel
        // ];
        $invoice = Invoice::with('invoiceDetails.sku_name', 'customer_name', 'accountReceivable', 'user_name')->findOrFail($id);

        $pdf = PDF::loadView('invoice/pdf', compact('invoice'))->save(public_path().'/invoice-pdf/'.'INV-0000'.$invoice->id.'.pdf');
        //$attach =public_path().'/invoice-pdf/'.$invoice->id.'.pdf';

        //Storage::put(public_path().'/invoice-pdf/invoice.pdf', $pdf->output());



        $data = [
            'subject' => 'Order Invoice',
            'email' => $invoice->customer_name->email,
            //'email' => 'usama.webewox@gmail.com',
            'invoice' => $invoice,
        ];

        $file = public_path('/invoice-pdf/'.'INV-0000'.$invoice->id.'.pdf');

        //return view('invoice/email-template')->with(compact('invoice'));
        // print_r($data);die;
        Mail::send('invoice/email-template', $data, function($message) use ($data, $file) {
            $message->to($data['email'])
                ->subject($data['subject']);

            $message->attach($file);

        });


        // return redirect('purchase')->with('success', 'Email sent successfully');
    }

    public function Testmail()
    {
        //$purchase = Purchase::where('id',$id)->with('purchaseDetails.sku_name', 'vendor_name')->first();
        //$purchase_rel = Purchase::with('purchaseDetails.sku_name', 'vendor_name')->findOrFail($purchase->id);
        $data = [
            'subject' => 'Purchase Order Request',
            'email' => 'qaiserabbas613@gmail.com',
            'content' => 'Purchase Order',
        ];

        Mail::send('emails/OrderEmail', $data, function($message) use ($data) {
            $message->to($data['email'])
                ->subject($data['subject']);
        });
        return redirect('purchase')->with('success', 'Email sent successfully');
    }

    public function reports()
    {
        $products = Product::groupBy('name')->select('name', DB::raw('count(*) as total'))->get();
        foreach($products as $product){
            $ids = DB::table('products')->where('name', $product->name)->select('id')->get()->toArray();
            $quantity = [];
            $quantity_p = [];
            foreach($ids as $id){
                $quan = DB::table('invoice_details')->where('sku_id', $id->id)->get()->toArray();
                $quan_p = PurchaseDetail::where('sku_id', $id->id)->with(['receiveDetails'])->get()->toArray();
                array_push($quantity, $quan);
                array_push($quantity_p, $quan_p);
            }
            $product->setAttribute('invoice', $quantity);
            $product->setAttribute('purchases', $quantity_p);

        }
        dd($products->toArray()[900]);
    }

    public function report()
    {
        $products = Product::groupBy('name')->select('name', DB::raw('count(*) as total'))->get();
        return view('invoice.report')->with(compact('products'));
    }

    public function reportv(Request $request)
    {
        dd($request);
        $fromDate = Carbon::parse($request->start_date)->toDatetimeString();
        $toDate = Carbon::parse($request->end_date)->toDatetimeString();
        $name = $request->name;
        $ids = DB::table('products')->where('name', $name)->select('id')->get();
        $quantity = [];
        $quantity_p = [];

        foreach($ids as $id){
            if ($fromDate != null) {
                $quan = DB::table('invoice_details')->where('sku_id', $id->id)->where('created_at', '>=', $fromDate)->get();
                // dd($quan);
                $quan_p = PurchaseDetail::where('sku_id', $id->id)->with(['receiveDetails'])->where('created_at', '>=', $fromDate)->get()->toArray();
            }

            if ($toDate != null) {
                $quan = DB::table('invoice_details')->where('sku_id', $id->id)->where('created_at', '<=', $toDate)->get();
                $quan_p = PurchaseDetail::where('sku_id', $id->id)->with(['receiveDetails'])->where('created_at', '<=', $toDate)->get()->toArray();
            }
            else{
                $quan = DB::table('invoice_details')->where('sku_id', $id->id)->get();
                $quan_p = PurchaseDetail::where('sku_id', $id->id)->with(['receiveDetails'])->get()->toArray();
            }


            array_push($quantity, $quan);
            array_push($quantity_p, $quan_p);
        }
        return view('invoice.view')->with(compact('quantity', 'quantity_p', 'name'));
    }

    public function reportprint($name)
    {
        $ids = DB::table('products')->where('name', $name)->select('id')->get();
        $quantity = [];
        $quantity_p = [];
        foreach($ids as $id){
            $quan = DB::table('invoice_details')->where('sku_id', $id->id)->get();
            $quan_p = PurchaseDetail::where('sku_id', $id->id)->with(['receiveDetails'])->get()->toArray();
            array_push($quantity, $quan);
            array_push($quantity_p, $quan_p);
        }
        return view('invoice.print')->with(compact('quantity', 'quantity_p', 'name'));
    }

    public function reportpdf($name)
    {
        $ids = DB::table('products')->where('name', $name)->select('id')->get();
        $quantity = [];
        $quantity_p = [];
        foreach($ids as $id){
            $quan = DB::table('invoice_details')->where('sku_id', $id->id)->get();
            $quan_p = PurchaseDetail::where('sku_id', $id->id)->with(['receiveDetails'])->get()->toArray();
            array_push($quantity, $quan);
            array_push($quantity_p, $quan_p);
        }
        return view('invoice.print')->with(compact('quantity', 'quantity_p', 'name'));
    }
    // public function invoiceReturn($id)
    // {
    //     $invoice = Invoice::where('id', $id)->first();
    //     $invoice->status = 'return';
    //     $invoice->save();

    //     return redirect('/invoice')->with('return', 'Invoice has been returned');
    // }
    // public function sendEmail()
    // {
    //     $details = [
    //         'title' => 'Mail from WAVE-POS',
    //         'body' => 'This is for testing Email'
    //     ];

    //     Mail::to("uf2178517@gmail.com")->send(new Testmail($details));
    //     return "Email send";
    // }
}
