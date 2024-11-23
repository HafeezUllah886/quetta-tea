<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\items;
use App\Models\sizes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

use Illuminate\Support\Str;

class ItemsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = items::with('sizes')->orderBy('catID', 'asc')->get();

        return view('items.list', compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $cats = categories::orderBy('name', 'asc')->get();
        $kitchens = User::Kitchens()->get();
        return view('items.create', compact('cats', 'kitchens'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => "unique:items,name",
            ],
            [
            'name.unique' => "Item already Existing",
            ]
        );

        $photo_path1 = null;

        if ($request->hasFile('img')) {

            $request->validate([
                'img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $image = $request->file('img');
            $filename = Str::slug($request->name, '_') . '_' . time() . '.' . $image->getClientOriginalExtension();

            // Resize and save the new image
            $resizedImage = Image::make($image)
                ->fit(300, 300) // Crop or resize to 300x300
                ->encode($image->getClientOriginalExtension(), 80); // Compress to 80% quality

            $photo_path1 = $filename;
            Storage::disk('public')->put($photo_path1, $resizedImage);
        }

        $request->merge([
            'img' => $photo_path1,
        ]);
        $item = items::create($request->except(['title', 'price', 'dprice']));

        $options = $request->title;

        foreach($options as $key => $option)
        {
            sizes::create(
                [
                    'itemID' => $item->id,
                    'title' => $request->title[$key],
                    'price' => $request->price[$key],
                    'dprice' => $request->dprice[$key],

                ]
            );
        }

        return back()->with('success', 'Product Created');
    }

    /**
     * Display the specified resource.
     */
    public function show($all)
    {
        $categories = categories::with('products')->get();
        return view('products.pricelist', compact('categories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(items $products)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => "unique:products,name,".$id,
            ],
            [
            'name.unique' => "Product already Existing",
            ]
        );

        $product = products::find($id);
        $product->update($request->all());

        return back()->with('success', 'Product Updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(products $products)
    {
        //
    }

    public function status($id)
    {
        $item = items::find($id);
        if($item->status == "Active")
        {
           $status = "Inactive";
        }
        else
        {
            $status = "Active";
        }

        $item->update(
            [
                'status' => $status,
            ]
        );

        return back()->with('success', "Status Updated");
    }
}
