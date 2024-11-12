<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $brands = Brand::with('category')->get();
        return view('admin.brands.index', compact('brands', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        return view('admin.brands.create', compact('categories'));
    }


    public function store(Request $request)
    {
        // $request->validate([
        //     'name' => 'required|string|max:255',
        //     'description' => 'nullable|string',
        //     'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        //     'category_id' => 'required|exists:categories,id',
        // ]);

        // if ($request->hasFile('image'))
        // {
        //     $imagePath = $request->file('image')->store('brands', 'public');
        // }
        // else
        // {
        //     $imagePath = null;
        // }

        // Brand::create([
        //     'name' => $request->input('name'),
        //     'description' => $request->input('description'),
        //     'image' => $imagePath,
        //     'category_id' => $request->input('category_id'),
        // ]);
        // return redirect()->route('admin.brands.index');


        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        try
        {

            if ($request->hasFile('image'))
            {
                $imagePath = $request->file('image')->store('brands', 'public');
            }
            else
            {
                $imagePath = null;
            }

            Brand::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'image' => $imagePath,
                'category_id' => $request->input('category_id'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Brand added successfully!'
            ], 200);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'There was an error processing your request. Please try again.'
            ], 500);
        }
    }

    public function edit($id)
    {
        $brand = Brand::findOrFail($id);
        $categories = Category::all();
        return view('admin.brands.edit', compact('brand', 'categories'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('image'))
        {
            if ($brand->image)
            {
                Storage::disk('public')->delete($brand->image);
            }
            $imagePath = $request->file('image')->store('brands', 'public');
        }
        else
        {
            $imagePath = $brand->image;
        }

        $brand->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
            'image' => $imagePath,
            'category_id' => $request->input('category_id'),
        ]);

        return redirect()->route('admin.brands.index');
    }


    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('admin.brands.index');
    }
}
