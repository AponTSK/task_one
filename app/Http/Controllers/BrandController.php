<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;

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
        ]);

        $brand = new Brand();
        $brand->name = $request->name;
        $brand->description = $request->description;
        if ($request->hasFile('image'))
        {
            $brand->image = $request->file('image')->store('brands', 'public');
        }

        $brand->save();

        return response()->json([
            'success' => true,
            'message' => 'Brand added successfully!'
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $brand = Brand::find($id);
        if (!$brand)
        {
            return response()->json([
                'success' => false,
                'message' => 'Brand Not found.'
            ], 404);
        }
        $brand->name = $request->name;
        $brand->description = $request->description;
        if ($request->hasFile('image'))
        {
            $brand->image = $request->file('image')->store('brands', 'public');
        }

        $brand->save();

        return response()->json([
            'success' => true,
            'message' => 'Brand updated successfully!'
        ], 200);
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
