<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::latest('id')->get();
        if (request()->ajax())
        {
            $html = view('admin.brands.list', compact('brands'))->render();
            return response()->json([
                'success' => true,
                'html' => $html
            ]);
        }
        else
        {
            return view('admin.brands.index', compact('brands'));
        }
    }



    public function store(Request $request)
    {
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

    public function update(Request $request, $id)
    {
        try
        {

            $brand = Brand::findOrFail($id);

            $validatedData = $request->validate([
                'name' => 'required|max:255',
                'description' => 'nullable|max:1000',
                'image' => 'nullable|image|max:2048',
            ]);

            $brand->name = $request->name;
            $brand->description = $request->description;

            if ($request->hasFile('image'))
            {

                if ($brand->image)
                {
                    Storage::delete('public/' . $brand->image);
                }

                $imagePath = $request->file('image')->store('brands', 'public');
                $brand->image = $imagePath;
            }

            $brand->save();

            return response()->json([
                'success' => true,
                'message' => 'Brand updated successfully!',
            ]);
        }
        catch (\Exception $e)
        {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred: ' . $e->getMessage(),
            ], 500);
        }
    }


    public function destroy($id)
    {

        $brand = Brand::findOrFail($id);
        $brands = Brand::latest('id')->get();
        $brand->delete();
        if (request()->ajax())
        {
            $html = view('admin.brands.list', compact('brands'))->render();
            return response()->json([
                'success' => true,
                'html' => $html
            ]);
        }
        else
        {
            return view('admin.brands.index', compact('brands'));
        }

        return response()->json([
            'success' => true,
            'message' => 'Brand deleted successfully!'
        ], 200);
    }
}
