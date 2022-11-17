<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class SubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
        $subCategories = DB::table('subcategorydetails')
        ->select('*')
        ->where('deleted_at','=',null)
        ->get();
        // $subCategories = SubCategory::with(['category'])->latest()->get();
        return view('SubCategory.index', compact('subCategories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::latest()->get();
//        dd($categories);
        return view('SubCategory.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        SubCategory::create([
            'category_id' => $request->input('category_id'),
            'subcategory_name' => $request->input('subcategory_name'),
            'subcategory_slug' => Str::slug($request->input('subcategory_name')),
        ]);

        return redirect()->route('sub_category.index')->with('success', 'Sub Category Created Successfully!!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubCategory $subCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit(SubCategory $subCategory)
    {
        $categories = Category::latest()->get();
        return view('SubCategory.edit', compact('subCategory', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, SubCategory $subCategory)
    {
        $subCategory->update([
            'category_id' => $request->category_id,
            'subcategory_name' => $request->input('subcategory_name'),
            'subcategory_slug' => Str::slug($request->input('subcategory_name')),
        ]);
        return redirect()->route('sub_category.index')->with('success', 'Sub Category Updated Successfully!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubCategory  $subCategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(SubCategory $subCategory)
    {
        $subCategory->delete();


        return redirect()->route('sub_category.index')->with('success', 'Sub Category Deleted Successfully!!!');
    }
}
