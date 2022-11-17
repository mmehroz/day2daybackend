<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DB;
use Validator;
use Mail;

class navController extends Controller
{
    public function parentnav()
    {
        $getnav = DB::table('categories')
        ->select('*')
        ->where('deleted_at','=',null)
        ->get();
        return response()->json(['parentnav' => $getnav ,'message' => 'Parent Nav'],200);
    }
        public function subnav(Request $request)
    {
        $validate = Validator::make($request->all(), [ 
          'category_id'     => 'required',
          'type'            => 'required',
        ]);
        if ($validate->fails()) {    
            return response()->json($validate->errors(), 400);
        }
        if ($request->type == "sub") {
            $categoryid = DB::table('sub_sub_categories')
            ->select('category_id')
            ->where('subsubcategory_slug','=',$request->category_id)
            ->first();
            $categories = DB::table('sub_categories')
            ->select('*')
            ->where('category_id','=',$categoryid->category_id)
            ->where('deleted_at','=',null)
            ->get();    
        }elseif($request->type == "child"){
            $categoryid = DB::table('sub_categories')
            ->select('category_id')
            ->where('subcategory_slug','=',$request->category_id)
            ->first();
            $categories = DB::table('sub_categories')
            ->select('*')
            ->where('category_id','=',$categoryid->category_id)
            ->where('deleted_at','=',null)
            ->get();    
        }else{
            $categories = DB::table('categories')
            ->select('*')
            ->where('deleted_at','=',null)
            ->get();
        }
        return response()->json(['subnav' => $categories ,'message' => 'Sub Nav'],200);
    }
         public function innersubnav(Request $request)
    {
        $validate = Validator::make($request->all(), [ 
          'subcategory_id'     => 'required',
        ]);
        if ($validate->fails()) {    
            return response()->json("Sub Category Id Required", 400);
        }
        $insubnav = DB::table('sub_sub_categories')
        ->select('*')
        ->where('subcategory_id','=',$request->subcategory_id )
        ->where('deleted_at','=',null)
        ->get();
        return response()->json(['innersubnav' => $insubnav ,'message' => 'Inner Sub Nav'],200);
    }
     public function webnav()
    {
        $getnav = DB::table('categories')
        ->select('*')
        ->where('deleted_at','=',null)
        ->get();
        $nav = array();
        $index = 0;
        foreach ($getnav as $getnavs) {
        	 $categories = DB::table('sub_categories')
	        ->select('*')
	        ->where('category_id','=',$getnavs->id)
	        ->where('deleted_at','=',null)
	        ->get();
	        $getnav[$index]->subMenu = $categories;
	        foreach ($categories as $categoriess) {
                $insubnav = DB::table('sub_sub_categories')
		        ->select('*')
		        ->where('subcategory_id','=',$categoriess->category_id )
		        ->where('deleted_at','=',null)
		        ->get();
	        	$getnav[$index]->inner = $insubnav;	
            }
	        $nav[$index] = $getnav[$index];
	        $index++;
        }
        // dd($nav);
        return response()->json(['menu' => $nav ,'message' => 'Web Nav'],200);
    }
      public function categories()
    {
        $categories = DB::table('categories')
        ->select('*')
        ->where('deleted_at','=',null)
        ->get();
        return response()->json(['categories' => $categories ,'message' => 'Categories'],200);
    }
       public function featuredproducts()
    {
        // $featuredproducts = DB::table('productdetails')
        // ->select('*')
        // ->where('featured','=',1)
        // ->where('status','=',1)
        // ->orderBy('id', 'DESC')
        // ->limit(10)
        // ->get();
        // return response()->json(['featuredproducts' => $featuredproducts ,'message' => 'Featured Products'],200);
        $products = Product::where('status', 1)->where('featured', 1)->orderBy('id', 'DESC')->limit(10)->get();
        return ProductResource::collection($products);
    }
      public function flashsale()
    {
        // $flashproducts = DB::table('productdetails')
        // ->select('*')
        // ->where('hot_deals','=',1)
        // ->where('status','=',1)
        // ->orderBy('id', 'DESC')
        // ->limit(10)
        // ->get();
        // return response()->json(['flashproducts' => $flashproducts ,'message' => 'Flash Sale Products'],200);
        $products = Product::where('status', 1)->where('hot_deals', 1)->orderBy('id', 'DESC')->limit(10)->get();
        return ProductResource::collection($products);
    }
       public function newarrival()
    {
        // $newarrival = DB::table('productdetails')
        // ->select('*')
        // ->where('new_arrival','=',1)
        // ->where('status','=',1)
        // ->orderBy('id', 'DESC')
        // ->limit(10)
        // ->get();
        // return response()->json(['newarrival' => $newarrival ,'message' => 'New Arrival Products'],200);
        $products = Product::where('status', 1)->where('new_arrival', 1)->orderBy('id', 'DESC')->limit(10)->get();
        return ProductResource::collection($products);
    }
       public function topbrands()
    {
        $topbrands = DB::table('brands')
        ->select('*')
        ->where('deleted_at','=',null)
        ->orderBy('id', 'DESC')
        // ->limit(20)
        ->get();
        return response()->json(['topbrands' => $topbrands ,'message' => 'Top Brands'],200);
    }
        public function productdetails(Request $request)
    {
        $validate = Validator::make($request->all(), [ 
          'product_slug'     => 'required',
        ]);
        if ($validate->fails()) {    
            return response()->json("Product Slug Required", 400);
        }
        $details = DB::table('productdetails')
        ->select('*')
        ->where('product_slug','=',$request->product_slug)
        ->first();
        if (isset($details)) {
        $variant = DB::table('product_variants')
        ->select('id','name')
        ->where('product_id','=',$details->id)
        ->get();
        $sortvariants = array();
        $index=0;
        if (isset($variant)) {
            foreach ($variant as $variants) {
                $variantsize = DB::table('product_variant_sizes')
                ->select('*')
                ->where('variant_id','=',$variants->id)
                ->get();
                if (isset($variantsize)) {
                    $sortsize = array();
                    foreach ($variantsize as $variantsizes) {
                        $sortsize[] = $variantsizes;
                    }
                    // $mergesize = implode(',', $variantsize->size);
                    $variant[$index]->size = $sortsize;
                }else{
                    $variant[$index]->size = "-";
                }
                    $sortvariants[$index] = $variants;
            $index++;
            }
        }
        $gallery = DB::table('product_photos')
        ->select('pictures')
        ->where('product_id','=',$details->id)
        ->get();
        $relatedproduct = DB::table('productdetails')
        ->select('*')
        ->where('category_id','=',$details->category_id)
        ->limit(6)
        ->get();
            return response()->json(['details' => $details,'gallery' => $gallery, 'sortvariants' => $sortvariants, 'relatedproduct' => $relatedproduct, 'message' => 'Product Details'],200);
        }else{
            return response()->json(['message' => 'Product Details Not Found'],200);
        }
    }
    public function createorder(Request $request){
        // dd($request);
        $validate = Validator::make($request->all(), [ 
          'name'            => 'required',
          'email'           => 'required',
          'phone'           => 'required',
          'address'         => 'required',
          'shipping_method' => 'required',
          'payment_method'  => 'required',
          'amount'          => 'required',
          'shipping_fee'    => 'required',
          'total_amount'    => 'required',
        ]);
        if ($validate->fails()) {    
            return response()->json($validate->errors(), 400);
        }
        $basic = array(
            'user_id'           => $request->user_id,
            'name'              => $request->name,
            'email'             => $request->email,
            'phone'             => $request->phone,
            'address'           => $request->address,
            'shipping_method'   => $request->shipping_method,
            'payment_method'    => $request->payment_method,
            'amount'            => $request->amount,
            'total_amount'      => $request->total_amount,
            'created_at'        => date('Y-m-d h:i:s'),
        );
        $save = DB::table('orders')->insert($basic);
        $order_id = DB::getPdo()->lastInsertId();
        if (isset($request->item)) {
            foreach ($request->item as $items) {
                $item = array(
                'order_id'     => $order_id,
                'product_id'   => $items['product_id'],
                'variant'      => $items['variant'],
                'size'         => $items['size'],
                'qty'          => $items['qty'],
                'unit_price'   => $items['unit_price'],
                );
                DB::table('order_items')->insert($item);
            }
        }
        if($save){
            return response()->json(['message' => 'Order Created Successfully'],200);
        }else{
            return response()->json("Oops! Something Went Wrong", 400);
        }
    }
      public function demowebnav()
    {
        $getnav = DB::table('categories')
        ->select('*')
        ->where('deleted_at','=',null)
        ->get();
        $nav = array();
        $index = 0;
        foreach ($getnav as $getnavs) {
             $categories = DB::table('sub_categories')
            ->select('*')
            ->where('category_id','=',$getnavs->id)
            ->where('deleted_at','=',null)
            ->get();
            if (isset($categories)) {
                $cat = $categories;
            }else{
                $cat = array();
            }
            $getnav[$index]->subMenu = $cat;
            $inner=0;
            foreach ($categories as $categoriess) {
                $insubnav = DB::table('sub_sub_categories')
                ->select('category_id','subcategory_id','subsubcategory_name as subcategory_name','subsubcategory_slug as subcategory_slug','deleted_at','created_at','updated_at')
                ->where('subcategory_id','=',$categoriess->id )
                ->where('deleted_at','=',null)
                ->get();
                if (isset($insubnav)) {
                    $sub = $insubnav;
                }else{
                    $sub = array();
                }
                $getnav[$index]->subMenu[$inner]->inner = $sub;
                $inner++;
            }
            $nav[$index] = $getnav[$index];
            // dd($nav);
            $index++;
        }
        // dd($nav);
        return response()->json(['menu' => $nav ,'message' => 'Web Nav'],200);
    }
       public function orderlist(Request $request)
    {
        $validate = Validator::make($request->all(), [ 
          'user_id'      => 'required',
        ]);
        if ($validate->fails()) {    
            return response()->json($validate->errors(), 400);
        }
        $orders = DB::table('orders')
        ->select('*')
        ->where('user_id','=',$request->user_id)
        ->orderBy('id', 'DESC')
        ->get();
        return response()->json(['orders' => $orders ,'message' => 'Order List'],200);
    }
        public function orderdetails(Request $request)
    {
        $validate = Validator::make($request->all(), [ 
          'order_id'      => 'required',
        ]);
        if ($validate->fails()) {    
            return response()->json($validate->errors(), 400);
        }
        $items = DB::table('orderdetails')
        ->select('*')
        ->where('order_id','=',$request->order_id)
        ->where('deleted_at','=',null)
        ->get();
        $paymetdetails = DB::table('orders')
        ->select('amount as subtotal', 'shipping_fee', 'payment_method', 'total_amount', 'notes')
        ->where('id','=',$request->order_id)
        ->first();
        return response()->json(['items' => $items, 'paymetdetails' => $paymetdetails, 'message' => 'Order Details'],200);
    }
    public function contactus(Request $request){
        // dd($request);
        $validate = Validator::make($request->all(), [ 
          'contact_name'      => 'required',
          'contact_email'     => 'required',
        ]);
        if ($validate->fails()) {    
            return response()->json($validate->errors(), 400);
        }
        $basic = array(
            'contact_name'      => $request->contact_name,
            'contact_email'     => $request->contact_email,
            'contact_subject'   => $request->contact_subject,
            'contact_message'   => $request->contact_message,
            'status_id'         => 1,
            'created_at'        => date('Y-m-d h:i:s'),
        );
        $save = DB::table('contact')->insert($basic);
        Mail::send('emails.contactus', ['request' => $request], function($message) {
         $message->to('rafey.majid@gmail.com', 'Rafay Khan')
         ->to('murtaza@mrm-soft.com', 'Murtaza Zaheer')
         ->bcc('avidhaus.mehroz@gmail.com', 'Muhammad Mehroz')
         ->subject('Day2Day Conatct Us')
         ->from('contact@day2day.com','Day2Day');
        });
        if($save){
            return response()->json(['message' => 'Thank You'],200);
        }else{
            return response()->json("Oops! Something Went Wrong", 400);
        }
    }
    public function review(Request $request){
        $validate = Validator::make($request->all(), [ 
          'review_rating'   => 'required',
          'review_message'  => 'required',
          'review_name'     => 'required',
          'review_email'    => 'required',
        ]);
        if ($validate->fails()) {    
            return response()->json($validate->errors(), 400);
        }
        $basic = array(
            'review_rating'     => $request->review_rating,
            'review_message'    => $request->review_message,
            'review_name'       => $request->review_name,
            'review_email'      => $request->review_email,
            'status_id'         => 1,
            'created_at'        => date('Y-m-d h:i:s'),
        );
        $save = DB::table('review')->insert($basic);
        if($save){
            return response()->json(['message' => 'Thank You For Submuting Review'],200);
        }else{
            return response()->json("Oops! Something Went Wrong", 400);
        }
    }
    public function subscription(Request $request){
       $basic = array(
            'subscription_email'    => $request->subscription_email,
            'status_id'             => 1,
            'created_at'            => date('Y-m-d h:i:s'),
        );
        $save = DB::table('subscription')->insert($basic);
        $toemail = $request->subscription_email;
          Mail::send('emails.subscription', [],
            function ($message) use ($toemail) {
              $message->to($toemail)
              ->bcc('avidhaus.mehroz@gmail.com')
              ->bcc('murtaza@mrm-soft.com')
            ->subject('Thank You For Subscribing Day2Day');
            });
        if($save){
            return response()->json(['message' => 'Thank You For Subscribing'],200);
        }else{
            return response()->json("Oops! Something Went Wrong", 400);
        }
    }
    public function forgetpassword(Request $request){
        if($request->email == ""){
            return response()->json(['message' => 'Please Enter Email'],200);
        }
      $verify_token =  $this->generateRandomString(100);
      $data = array();
      $data['verify_token'] = $verify_token;
      $cmd = DB::table('users')
             ->where('email', $request->email)
             ->update(['remember_token' => $verify_token]);
      if($cmd){
        $toemail = $request->email;
          Mail::send('emails.forgetpassword', ['verify_token' => $verify_token],
            function ($message) use ($toemail) {
              $message->to($toemail)
              ->bcc('avidhaus.mehroz@gmail.com')
            ->subject('Forget Password');
            });
        return response()->json(['message' => 'Check Your Email'],200);
      } else{
        return response()->json(['message' => 'Oops! Something Went Wrong'],400);
      }
    }
    public function verifycode(Request $request){
        $validate = Validator::make($request->all(), [ 
          'verify_token'   => 'required',
        ]);
        if ($validate->fails()) {    
            return response()->json("Verification Code Required", 400);
        }
        $result =  DB::table('users')
                 ->where('remember_token', '=',$request->verify_token)
                 ->select('remember_token','id')->first();
        if(!empty($result)){
            $verify_token = $result->remember_token;
            $id = $result->id;
            return response()->json(['verify_token' => $verify_token,'id' => $id, 'message' => 'Successfully Verified'],200);
        } else{
             return response()->json(['message' => 'Oops! Something Went Wrong'],400);
        }
    }
    public function resetpassword(Request $request){
        $validate = Validator::make($request->all(), [ 
          'verify_token'    => 'required',
          'id'              => 'required',
          'password'        => 'required',
        ]);
        if ($validate->fails()) {    
            return response()->json($validate->errors(), 400);
        }   
       $cmd = DB::table('users')
             ->where('id', $request->id)
             ->where('remember_token', $request->verify_token)
             ->update(['password' => bcrypt($request->password),'remember_token' => '']);
        if($cmd){
            return response()->json(['message' => 'Successfully Reset'],200);
        } else{
            return response()->json(['message' => 'Oops! Something Went Wrong'],400);
        }   
    }
    public function changepassword(Request $request){
        $validate = Validator::make($request->all(), [ 
          'user_id'       => 'required',
          'password'      => 'required',
          'oldpassword'   => 'required',
        ]);
        if ($validate->fails()) {    
            return response()->json($validate->errors(), 400);
        }   
       $cmd = DB::table('users')
             ->where('id', $request->user_id)
             ->update(['password' => bcrypt($request->password)]);
        if($cmd){
            return response()->json(['message' => 'Successfully Updated'],200);
        } else{
            return response()->json(['message' => 'Oops! Something Went Wrong'],400);
        }   
    }
    public  function generateRandomString($length = 5){
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }
    public function webvisitors(){
        $visit = array(
            'webvisit_at'    => date('Y-m-d h:i:s'),
        );
        $save = DB::table('webvisit')->insert($visit);
        return response()->json(['message' => 'Success'],200);
    }
}