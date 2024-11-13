<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all()
            ]);
        }

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
        ]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
        if ($validator->fails())
        {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->all()
            ]);
        }
        $brand = Brand::find($id);
        if (!$brand)
        {
            return response()->json([
                'success' => false,
                'message' => 'Brand Not found.'
            ]);
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
        ]);
    }

    public function destroy($id)
    {

        $brand = Brand::findOrFail($id);
        $brands = Brand::latest('id')->get();
        $brand->delete();
        return redirect()->route('admin.brands.index')->with('success', 'Brands deleted successfully.');
    }
}
