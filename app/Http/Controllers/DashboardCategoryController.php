<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class DashboardCategoryController extends Controller
{
    public function index()
    {
        return view('dashboard.categories.index', [
            'categories' => Category::all()
        ]);
    }

    public function create()
    {
        return view('dashboard.categories.create');
    }

    public function store(Request $request)
    {

        $validateData = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:categories',
        ]);

        Category::create($validateData);

        return redirect('/dashboard/categories')->with('success', 'New category has been created');
    }

    public function show(Category $category)
    {
        return view('dashboard.categories.show', [
            'category' => $category
        ]);
    }

    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', [
            'category' => $category
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $rules = [
            'name' => 'required|max:255',
        ];

        if ($request->slug != $category->slug) {
            $rules['slug'] = 'required|unique:posts';
        }

        $validateData = $request->validate($rules);

        Category::where('id', $category->id)->update($validateData);

        return redirect('/dashboard/categories')->with('success', 'Category has been edited');
    }

    public function destroy(Category $category)
    {

        Category::destroy($category->id);  

        return redirect('/dashboard/categories')->with('success', 'Category has been deleted');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Category::class, 'slug', $request->name);
        
        return response()->json(['slug' => $slug]);
    }





}
