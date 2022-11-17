<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductPhotos;
use App\Models\ProductVariant;
use App\Models\ProductVariantSize;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;
use DB;
use Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with(['brand', 'category', 'subcategory', 'subsubcategory', 'photos', 'variant', 'variant_size'])->latest()->paginate(30);
        $variant = ['asd', 'asd'];
        return view('Product.index',compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();
        $subsubcategories = SubSubCategory::latest()->get();
        return view('Product.create', compact(
            'brands',
            'categories',
            'subcategories',
            'subsubcategories'
        ));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
       // dd($request->all());
        if ($request->hot_deals == 'on') {
            $request->merge(['hot_deals' => true]);
        }
        else {
            $request->merge(['hot_deals' => false]);
        }
        if ($request->featured == 'on') {
            $request->merge(['featured' => true]);
        }
        else {
            $request->merge(['featured' => false]);
        }
        if ($request->new_arrival == 'on') {
            $request->merge(['new_arrival' => true]);
        }
        else {
            $request->merge(['new_arrival' => false]);
        }
        if ($request->special_offer == 'on') {
            $request->merge(['special_offer' => true]);
        }
        else {
            $request->merge(['special_offer' => false]);
        }
        if ($request->special_deals == 'on') {
            $request->merge(['special_deals' => true]);
        }
        else {
            $request->merge(['special_deals' => false]);
        }
        if ($request->status == 'on') {
            $request->merge(['status' => true]);
        }
        else {
            $request->merge(['status' => false]);
        }

        if($request->file('product_thumbnail')){
            $upload_location = 'assets/img/products/thumb/';
            $file = $request->file('product_thumbnail');
            $name_gen = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $filename = $request->file('product_thumbnail')->move(public_path($upload_location),$name_gen);
            // Image::make($file)->save($upload_location.$name_gen);
            $save_url = $name_gen;
        }
        else{
            $save_url = null;
        }
        $generateslug = Str::slug($request->product_name).rand();
        $product = Product::create([
            'product_name'  => $request->product_name,
            'product_slug'  => $generateslug,
            'product_sku'   => $request->product_sku,
            'product_code'  => $request->product_code,
            'product_qty'   => $request->product_qty,
            'product_tags'  => $request->product_tags,
            'brand_id' => $request->brand_id,
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'sub_subcategory_id' => $request->sub_subcategory_id,
            'short_description' => $request->short_description,
            'long_description' => $request->long_description,
            'additional_info' => $request->additional_info,
            'product_thumbnail' => $save_url,
            'purchase_price' => $request->purchase_price,
            'selling_price' => $request->selling_price,
            'discount_price' => $request->discount_price,
            'tier1_price' => $request->tier1_price,
            'tier2_price' => $request->tier2_price,
            'tier3_price' => $request->tier3_price,
            'tier4_price' => $request->tier4_price,
            'hot_deals' => $request->hot_deals,
            'featured' => $request->featured,
            'new_arrival' => $request->new_arrival,
            'special_offer' => $request->special_offer,
            'special_deals' => $request->special_deals,
            'status' => $request->status,
        ]);


        if($request->file('images'))
        {
            $images = $request->file('images');
            foreach ($images as $single_image) {
                $upload_location = 'assets/img/products/';
                $name_gen = hexdec(uniqid()).'.'.$single_image->getClientOriginalExtension();
                $filename = $single_image->move(public_path($upload_location),$name_gen);
                // Image::make($single_image)->encode('png', 75)->save($upload_location.$name_gen);
                $save_url = $name_gen;
                ProductPhotos::create([
                    'product_id' => $product->id,
                    'pictures' => $save_url,
                ]);
            }
        }
        $var_imgs = $request->file('var_img');
            $count = 0;
        foreach ($request->variant as $variant) {
            if($var_imgs != null){
                $upload_location = 'assets/img/variants/';
                $name_gen = hexdec(uniqid()).'.'.$var_imgs[$count]->getClientOriginalExtension();
                $filename = $var_imgs[$count]->move(public_path($upload_location),$name_gen);
                // Image::make($single_image)->save($upload_location.$name_gen);
                // $save_url = $name_gen;
            }
            else{
                $save_url = null;
            }
            $productvar = ProductVariant::create([
                'product_id' => strval($product->id),
                'name' => $variant,
                'picture' => $save_url,
            ]);
            if ($productvar->id != null) {
            $count2 = 0;
            foreach ($request->size[$count] as $size) {
                // dd($size);
                if (isset($size)) {
                ProductVariantSize::create([
                    'product_id' => $product->id,
                    'variant_id' => $productvar->id,
                    'size' => $size,
                    'quantity' => $request->quantity[$count][$count2],
                    'variantprice' => $request->variantprice[$count][$count2],
                ]);
                $count2++;
                }
            }
            }
            $count++;
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return ProductResource
     */
    public function show($id)
    {
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();
        $subsubcategories = SubSubCategory::latest()->get();
        $product = Product::with(['brand', 'category', 'subcategory', 'subsubcategory', 'photos'])->findOrFail($id);
            return view('Product.view', compact('product', 'brands', 'categories', 'subcategories', 'subsubcategories'));
        // $product = Product::find($id);
        // return new ProductResource($product);

//        $product = Product::with(['brand', 'category', 'subcategory', 'subsubcategory', 'photos'])->findOrFail($id);
//        return response()->json($product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $brands = Brand::latest()->get();
        $categories = Category::latest()->get();
        $subcategories = SubCategory::latest()->get();
        $subsubcategories = SubSubCategory::latest()->get();
        $product = Product::with(['brand', 'category', 'subcategory', 'subsubcategory', 'photos'])->findOrFail($id);
        return view('Product.edit', compact('product', 'brands', 'categories', 'subcategories', 'subsubcategories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // dd($request);
        if($request->file('product_thumbnail')){
            $upload_location = 'assets/img/products/thumb/';
            $file = $request->file('product_thumbnail');
            $name_gen = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $filename = $file->move(public_path($upload_location),$name_gen);
            $save_url = $name_gen;
            $thumb = [
                'product_thumbnail'    => $save_url,
            ];
            DB::table('products')
            ->where('id','=',$id)
            ->update($thumb);
            }
        else{
            $save_url = null;
        }
        if (isset($request->featured)) {
            $featured = $request->featured;
        }else{
            $featured = 0;
        }
        if (isset($request->new_arrival)) {
            $new_arrival = $request->new_arrival;
        }else{
            $new_arrival = 0;
        }
        if (isset($request->special_offer)) {
            $special_offer = $request->special_offer;
        }else{
            $special_offer = 0;
        }
        if (isset($request->special_deals)) {
            $special_deals = $request->special_deals;
        }else{
            $special_deals = 0;
        }
        if (isset($request->hot_deals)) {
            $hot_deals = $request->hot_deals;
        }else{
            $hot_deals = 0;
        }
        $adds = [
            'brand_id'             => $request->brand_id,
            'category_id'          => $request->category_id,
            'subcategory_id'       => $request->subcategory_id,
            'sub_subcategory_id'   => $request->sub_subcategory_id,
            'product_name'         => $request->product_name,
            'product_sku'          => $request->product_sku,
            'product_qty'          => $request->product_qty,
            'purchase_price'       => $request->purchase_price,
            'selling_price'        => $request->selling_price,
            'discount_price'       => $request->discount_price,
            'tier1_price'          => $request->tier1_price,
            'tier2_price'          => $request->tier2_price,
            'tier3_price'          => $request->tier3_price,
            'tier4_price'          => $request->tier4_price,
            'short_description'    => $request->short_description_en,
            'long_description'     => $request->long_description_en,
            'additional_info'      => $request->additional_info,
            'hot_deals'            => $hot_deals,
            'featured'             => $featured,
            'new_arrival'          => $new_arrival,
            'special_offer'        => $special_offer,
            'special_deals'        => $special_deals,
            'status'               => $request->status,
        ];
        $save = DB::table('products')
        ->where('id','=',$id)
        ->update($adds);
        if($save){
            return redirect()->route('products.index')->with('success', 'Product Updated successfully.');    
        }else{
            return redirect()->route('products.index')->with('success', 'Oops! Something Went Wrong.');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }


    // public function getAll()
    // {
    //     $products = Product::where('status', 1)->get();
    //     return ProductResource::collection($products);
    // }

       public function getsale($type)
    {
        $saletype = explode('=', $type);
        if ($saletype[1] == "Flash") {
            $products = Product::where('status', 1)->where('hot_deals','=',1)->paginate(30);
            $filtername = "Flash Sale";
        }elseif ($saletype[1] == "New") {
            $products = Product::where('status', 1)->where('new_arrival','=',1)->paginate(30);
            $filtername = "New Arrival";
        }elseif ($saletype[1] == "Specialoffer") {
            $products = Product::where('status', 1)->where('special_offer','=',1)->paginate(30);
            $filtername = "Special Offer";
        }elseif ($saletype[1] == "Specialdeal") {
            $products = Product::where('status', 1)->where('special_deals','=',1)->paginate(30);
            $filtername = "Special Deal";
        }elseif ($saletype[1] == "Featured"){
            $products = Product::where('status', 1)->where('featured','=',1)->paginate(30);
            $filtername = "Featured Product";
        }else{
            $products = Product::where('status', 1)->paginate(30);
            $filtername = "All Product";
        }
        return ['data' => ProductResource::collection($products), 'filtername' => $filtername];
    }

    public function getAll($product_id)
    {
        $id = explode('=', $product_id);
        if ($id[1] == "all") {
            $products = Product::where('status', 1)->paginate(24);    
            $filtername = "All";
        }else{
            $getid = DB::table('categories')
            ->select('id')
            ->where('category_slug','=',$id[1])
            ->first();
            $filtername = DB::table('categories')
            ->select('category_name')
            ->where('id','=',$getid->id)
            ->first();
            $filtername->category_name;
            $products = Product::where('status', 1)->where('category_id','=',$getid->id)->paginate(24);
        }
        return ['data' => ProductResource::collection($products), 'filtername' => $filtername];
    }
        public function getsub($product_id)
    {
        $id = explode('=', $product_id);
        $getid = DB::table('sub_categories')
        ->select('id')
        ->where('subcategory_slug','=',$id[1])
        ->first();
        $filtername = DB::table('sub_categories')
        ->select('subcategory_name')
        ->where('id','=',$getid->id)
        ->first();
        $products = Product::where('status', 1)->where('subcategory_id','=',$getid->id)->paginate(24);
        return ['data' => ProductResource::collection($products), 'filtername' => $filtername->subcategory_name];
    }
        public function getinner($product_id)
    {
        $id = explode('=', $product_id);
        $getid = DB::table('sub_sub_categories')
        ->select('id')
        ->where('subsubcategory_slug','=',$id[1])
        ->first();
        $filtername = DB::table('sub_sub_categories')
        ->select('subsubcategory_name')
        ->where('id','=',$getid->id)
        ->first();
        $products = Product::where('status', 1)->where('sub_subcategory_id', $getid->id)->paginate(24);
        return ['data' => ProductResource::collection($products), 'filtername' => $filtername->subsubcategory_name];
    }
        public function brandproduct($brand_id)
    {
        $id = explode('=', $brand_id);
        $getid = DB::table('brands')
        ->select('id')
        ->where('brand_slug','=',$id[1])
        ->first();
        $filtername = DB::table('brands')
        ->select('brand_name')
        ->where('id','=',$getid->id)
        ->first();
        $products = Product::where('status', 1)->where('brand_id', $getid->id)->paginate(24);
        return ['data' => ProductResource::collection($products), 'brandname' => $filtername->brand_name];
    }
        public function searchproduct($searchname)
    {
        $id = explode('=', $searchname);
        $products = Product::where('status', 1)->where('product_name','like', '%'.$id[1].'%')->limit(50)->get();
        return ['data' => ProductResource::collection($products)];
    }
        public function tagproduct($tagname)
    {
        $id = explode('=', $tagname);
        $products = Product::where('status', 1)->where('product_tags','like', '%'.$id[1].'%')->paginate(24);
        return ['data' => ProductResource::collection($products), 'filtername' => $id[1]];
    }
        public function getmultifilter(Request $request)
    {
        $catslug = explode(',', $request->cat_slug);
        $getcat = DB::table('categories')
        ->select('id')
        ->whereIn('category_slug',$catslug)
        ->get();
        $catid = array();
        foreach ($getcat as $getcats) {
            $catid[] = $getcats->id;
        }
        $subslug = explode(',', $request->sub_slug);
        $getsub = DB::table('sub_categories')
        ->select('id')
        ->whereIn('subcategory_slug',$subslug)
        ->get();
        $subid = array();
        foreach ($getsub as $getsubs) {
            $subid[] = $getsubs->id;
        }
        $innerslug = explode(',', $request->inner_slug);
        $getinner = DB::table('sub_sub_categories')
        ->select('id')
        ->whereIn('subsubcategory_slug',$innerslug)
        ->get();
        $innerid = array();
        foreach ($getinner as $getinners) {
            $innerid[] = $getinners->id;
        }
        $products = Product::where('status', 1)
        ->whereIn('category_id',$catid)
        ->orwhereIn('subcategory_id',$subid)
        ->orwhereIn('sub_subcategory_id',$subid)
        ->paginate(24);
        return ['data' => ProductResource::collection($products), 'filtername' => "Multi Product"];
    }
        public function getmultibrand(Request $request)
    {
        $validate = Validator::make($request->all(), [ 
          'brand_slug'     => 'required',
        ]);
        if ($validate->fails()) {    
            return response()->json($validate->errors(), 400);
        }
        $brandslug = explode(',', $request->brand_slug);
        $getbrand = DB::table('brands')
        ->select('id')
        ->whereIn('brand_slug',$brandslug)
        ->get();
        $brandid = array();
        foreach ($getbrand as $getbrands) {
            $brandid[] = $getbrands->id;
        }
        $products = Product::where('status', 1)->whereIn('brand_id', $brandid)->paginate(24);
        // dd($products);
        return ['data' => ProductResource::collection($products), 'filtername' => "Multi Brand Product"];
    }
    public function MultiImageUpdate(Request $request)
    {
        $imgs = $request->multi_img;

        foreach ($imgs as $id => $img) {
            $imgDel = ProductPhotos::findOrFail($id);
            unlink($imgDel->photo_name);

            $make_name = hexdec(uniqid()).'.'.$img->getClientOriginalExtension();
            $upload_location = 'upload/products/multi_images/';
            Image::make($img)->resize(600,600)->save($upload_location.$make_name);
            $uploadPath = $upload_location.$make_name;

            ProductPhotos::where('id',$id)->update([
                'photo_name' => $uploadPath,
            ]);

        } // end foreach

        $notification = array(
            'message' => 'Product Image Updated Successfully',
            'alert-type' => 'info'
        );

        return redirect()->back()->with($notification);
    }
     public function addproduct(Request $request)
    {
        
        foreach ($request->product as $products) {
            $generateslug = Str::slug($products['product_name']).rand();
            Product::create([
                'product_slug'          => $generateslug,
                'product_name'          => $products['product_name'],
                'product_sku'           => $products['product_sku'],
                'product_qty'           => $products['product_qty'],
                'brand_id'              => $products['brand_id'],
                'category_id'           => $products['category_id'],
                'subcategory_id'        => $products['subcategory_id'],
                'short_description'     => $products['short_description'],
                'product_thumbnail'     => $products['product_thumbnail'],
                'purchase_price'        => $products['purchase_price'],
                'selling_price'         => $products['selling_price'],
                'discount_price'        => $products['discount_price'],
                'product_tags'          => $products['product_tags'],
                'product_code'          => "-",
                'long_description'      => "-",
                'additional_info'       => "-",
                'tier1_price'           => 0,
                'tier2_price'           => 0,
                'tier3_price'           => 0,
                'tier4_price'           => 0,
                'hot_deals'             => 0,
                'featured'              => 0,
                'new_arrival'           => 0,
                'special_offer'         => 0,
                'special_deals'         => 0,
                'status'                => 1,
            ]);
        }
        return response()->json(['message' => 'Product Added successfully.'],200);
    }
     public function productlookup()
    {
         $products = array();
        return view('Product.lookup',compact('products'));
    }
     public function submitlookup(Request $request)
    {
         $products = Product::with(['brand', 'category', 'subcategory', 'subsubcategory', 'photos', 'variant', 'variant_size'])->latest()->where('product_name','like', '%'.$request->search.'%')->where('status', 1)->get();
        return view('Product.lookup',compact('products'));
    }
}