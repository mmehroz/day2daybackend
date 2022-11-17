<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\SubCategory;
use App\Models\SubSubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use DB;

class SubSubCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function index()
    {
         $subsubCategories = DB::table('subsubcatdetails')
        ->select('*')
        ->where('deleted_at','=',null)
        ->get();
        // $subsubCategories = SubSubCategory::with(['category','subcategory'])->latest()->get();
        return view('SubSubCategory.index', ['subsubCategories' => $subsubCategories]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::with('subcategory')->latest()->get();
        return view('SubSubCategory.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        SubSubCategory::create([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_name' => $request->input('subsubcategory_name'),
            'subsubcategory_slug' => Str::slug($request->input('subsubcategory_name')),
        ]);

        return redirect()->route('sub_sub_category.index')->with('success', 'Sub Sub Category Created Successfully!!!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\SubSubCategory  $subSubCategory
     * @return \Illuminate\Http\Response
     */
    public function show(SubSubCategory $subSubCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\SubSubCategory  $subSubCategory
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
     */
    public function edit($id)
    {

        $subsubCategory = SubSubCategory::findOrFail($id);
        $categories = Category::latest()->get();
        $subcategories = SubCategory::where('category_id', $subsubCategory->category_id)->get();
        return view('SubSubCategory.edit', compact('categories','subcategories','subsubCategory'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SubSubCategory  $subSubCategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $subsubCategory = SubSubCategory::findOrFail($id);
        $subsubCategory->update([
            'category_id' => $request->category_id,
            'subcategory_id' => $request->subcategory_id,
            'subsubcategory_name' => $request->subsubcategory_name,
            'subsubcategory_slug' => Str::slug($request->subsubcategory_name),
        ]);

        return redirect()->route('sub_sub_category.index')->with('success', 'Sub Sub Category Updated Successfully!!!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SubSubCategory  $subSubCategory
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(SubSubCategory $subSubCategory)
    {
        $subSubCategory->delete();
        return redirect()->route('sub_sub_category.index')->with('success', 'Sub Sub Category Deleted Successfully!!!');
    }

    public function getSubCategory($category_id)
    {
        $subCategory = SubCategory::where('category_id','=', $category_id)->orderBy('subcategory_name','ASC')->get();
        return json_encode($subCategory);
    }

    public function getSubSubCategory($subcategory_id)
    {
        $subsubCategory = SubSubCategory::where('subcategory_id', '=', $subcategory_id)->orderBy('subsubcategory_name', 'ASC')->get();
        return json_encode($subsubCategory);
    }
}
