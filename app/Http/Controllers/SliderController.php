<?php

namespace App\Http\Controllers;

use App\Http\Resources\SliderResource;
use App\Models\Slider;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use DB;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $sliders = Slider::latest()->get();
        return view('Slider.index', compact('sliders'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        return view('Slider.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        if($request->file('slider_image')){
            $upload_location = 'public/assets/img/sliders/';
            $file = $request->file('slider_image');
            $name_gen = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
               $filename = $request->slider_image->move(public_path('assets/img/sliders/'),$name_gen);
            // Image::make($file)->resize(1920,900)->save($upload_location.$name_gen);
            // Image::make($file)->resize(690,480)->save($upload_location."m".$name_gen);
            $save_url = $name_gen;
            // dd($request);
            Slider::create([
                'slider_status' => $request->input('slider_status'),
                'slider_name' => $request->input('slider_name'),
                'slider_title' => $request->input('slider_title'),
                'slider_link' => $request->input('slider_link'),
                'slider_type' => $request->slider_type,
                'slider_description' => $request->input('slider_description'),
                'slider_image' => $save_url,
            ]);
        }else{
            Slider::create([
                'slider_status' => $request->input('slider_status'),
                'slider_name' => $request->input('slider_name'),
                'slider_title' => $request->input('slider_title'),
                'slider_link' => $request->input('slider_link'),
                'slider_type' => $request->slider_type,
                'slider_description' => $request->input('slider_description'),
            ]);
        }

        return redirect()->route('slider.index')
            ->with('success','Slider Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\Response
     */
    public function show(Slider $slider)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {
        $slider = Slider::findOrFail($id);
        return view('Slider.edit', compact('slider'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $slider = Slider::findOrFail($id);

        if($request->file('slider_image')){
            if($slider->slider_image !='https://source.unsplash.com/random'){
                // unlink('public/assets/img/sliders/'. $slider->slider_image);
            }
            $upload_location = 'public/assets/img/sliders/';
            $file = $request->file('slider_image');
            $name_gen = hexdec(uniqid()).'.'.$file->getClientOriginalExtension();
            $filename = $request->slider_image->move(public_path('assets/img/sliders/'),$name_gen);
            // Image::make($file)->resize(1920,900)->save($upload_location.$name_gen);
            // Image::make($file)->resize(690,480)->save($upload_location."m".$name_gen);
            $save_url = $name_gen;

            $slider->update([
                'slider_status' => $request->input('slider_status'),
                'slider_name' => $request->input('slider_name'),
                'slider_title' => $request->input('slider_title'),
                'slider_link' => $request->input('slider_link'),
                'slider_type' => $request->slider_type,
                'slider_description' => $request->input('slider_description'),
                'slider_image' => $save_url,
            ]);
        }else{
            $slider->update([
                'slider_status' => $request->input('slider_status'),
                'slider_name' => $request->input('slider_name'),
                'slider_title' => $request->input('slider_title'),
                'slider_link' => $request->input('slider_link'),
                'slider_type' => $request->slider_type,
                'slider_description' => $request->input('slider_description'),
            ]);
        }

        return redirect()->route('slider.index')
            ->with('success','Slider Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Slider  $slider
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $slider = Slider::findOrFail($id);
        // if($slider->slider_image !='https://source.unsplash.com/random'){
        //     unlink('public/assets/img/sliders/'. $slider->slider_image);
        // }

        $slider->delete();

        return redirect()->route('slider.index')
            ->with('success','Slider Deleted Successfully');
    }

    public function changeSliderStatus(Request $request)
    {
        $slider = Slider::findOrFail($request->slider_id);
        $slider->slider_status = $request->status;
        $slider->save();

        $notification = [
            'message' => 'Slider Status Updated Successfully!!!',
            'alert-type' => 'success'
        ];
        return response()->json($notification, 200);
    }
    public function getSliders($type)
    {
        $type = explode('=', $type);
        if ($type[1] == 1) {
            $sliders = Slider::where('slider_status', '=', 1)->where('slider_type', '=', 1)->limit(3)->get();    
        }else{
            $sliders = DB::table('sliders')
            ->select('*')
            ->where('slider_status', '=', 1)
            ->where('slider_type', '=', $type[1])
            ->orderBy('id', 'DESC')
            ->limit(1)
            ->get();
            // $sliders = Slider::where('slider_status', '=', 1)->where('slider_type', '=', $type[1])->orderBy('id', 'DESC')->limit(1)->first();      
        }
        return SliderResource::collection($sliders);
    }
}
