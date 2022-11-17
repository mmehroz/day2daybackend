<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $brands = Brand::latest()->get();
        return view('brand.index', compact('brands'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        if($request->file('brand_image')){
            $upload_location = 'public/assets/img/brands/';
            $file = $request->file('brand_image');
            $name_gen = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            Image::make($file)->resize(600,600)->save($upload_location.$name_gen);
            $save_url = $name_gen;

            Brand::create([
                'brand_name' => $request->input('brand_name'),
                'brand_slug' => Str::slug($request->input('brand_name')),
                'brand_image' => $save_url
            ]);
        }else{
            Brand::create([
                'brand_name' => $request->input('brand_name'),
                'brand_slug' => Str::slug($request->input('brand_name')),
            ]);
        }

        return redirect()->route('brands.index')->with('success','Brand Created Successfully!!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\Response
     */
    public function show(Brand $brand)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(Brand $brand)
    {
        return view('brand.edit', compact('brand'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Brand $brand)
    {

        if($request->file('brand_image')){
            // if($brand->brand_image !='default.jpg'){
            //     unlink($brand->brand_image);
            // }
            $upload_location = 'public/assets/img/brands/';
            $file = $request->file('brand_image');
            $name_gen = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            Image::make($file)->resize(600,600)->save($upload_location.$name_gen);
            $save_url = $name_gen;
            $brand->update([
                'brand_name' => $request->input('brand_name'),
                'brand_slug' => Str::slug($request->input('brand_name')),
                'brand_image' => $save_url
            ]);
        }else{
            $brand->update([
                'brand_name' => $request->input('brand_name'),
                'brand_slug' => Str::slug($request->input('brand_name')),
            ]);
        }

        return redirect()->route('brands.index')->with('success','Brand Updated Successfully!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Brand  $brand
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Brand $brand)
    {
        //dd($brand);
        if($brand->brand_image !='default.jpg'){
            // unlink($brand->brand_image);
        }
        $brand->delete();

        return redirect()->route('brands.index')->with('success','Brand Deleted Successfully!!!');
    }
}
