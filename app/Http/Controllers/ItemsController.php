<?php

namespace App\Http\Controllers;

use App\Models\categories;
use App\Models\item_beverages;
use App\Models\items;
use App\Models\rawMaterial;
use App\Models\sizes;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\gd\Driver;


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
        $materials = rawMaterial::where('catID', 2)->get();
        return view('items.create', compact('cats', 'kitchens', 'materials'));
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
        try
        {
            DB::beginTransaction();
            $filePath = null;

        if ($request->hasFile('img')) {

            $request->validate([
                'img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $image = $request->file('img');
            $filename = time() . '.' . $image->getClientOriginalExtension();

          $image->move('uploads', $filename);

           $manager = new ImageManager(new Driver());

           $resize = $manager->read('uploads/' . $filename);

           $resize->cover(200, 200);

           $resize->save(public_path('uploads/items/'. $filename));
           $filePath = 'uploads/items/' . $filename;
           if (file_exists('uploads/'.$filename)) {
            unlink('uploads/'.$filename);
        }
        }

        $item = items::create(
            [
                'name' => $request->name,
                'catID' => $request->catID,
                'kitchenID' => $request->kitchenID,
                'img' => $filePath,
            ]
        );

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
        if($request->has('rawID'))
        {
            $beverages = $request->rawID;

            foreach($beverages as $key => $beverage)
            {
                item_beverages::create(
                    [
                        'itemID' => $item->id,
                        'rawID' => $beverage,
                    ]
                );
            }
        }

        DB::commit();
        return back()->with('success', 'Product Created');
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }


    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $item = items::find($id);
        $cats = categories::orderBy('name', 'asc')->get();
        $kitchens = User::Kitchens()->get();
        $materials = rawMaterial::where('catID', 2)->get();
        return view('items.edit', compact('cats', 'kitchens', 'item', 'materials'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate(
            [
                'name' => "unique:items,name," . $id,
            ],
            [
            'name.unique' => "Item already Existing",
            ]
        );
        try
        {
            DB::beginTransaction();

        $item = items::find($id);

        $item->update(
            [
                'name' => $request->name,
                'catID' => $request->catID,
                'kitchenID' => $request->kitchenID,
            ]
        );

        foreach($item->sizes as $option)
        {
            $option->delete();
        }
        foreach($item->dealItems as $raw)
        {
            $raw->delete();
        }
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

        $filePath = null;

        if ($request->hasFile('img')) {

            $request->validate([
                'img' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);

            $oldImg = asset($item->img);
            if (file_exists($oldImg)) {
                unlink($oldImg);
            }

            $image = $request->file('img');
            $filename = time() . '.' . $image->getClientOriginalExtension();

          $image->move('uploads', $filename);

           $manager = new ImageManager(new Driver());

           $resize = $manager->read('uploads/' . $filename);

           $resize->cover(200, 200);

           $resize->save(public_path('uploads/items/'. $filename));
           $filePath = 'uploads/items/' . $filename;
           if (file_exists('uploads/'.$filename)) {
            unlink('uploads/'.$filename);
            }

            $item->update(
                [
                    'img' => $filePath,
                ]
            );
        }

        $beverages = $request->rawID;

        foreach($beverages as $key => $beverage)
        {
            item_beverages::create(
                [
                    'itemID' => $item->id,
                    'rawID' => $beverage,
                ]
            );
        }
        DB::commit();
        return back()->with('success', 'Item Updated');
        }
        catch(\Exception $e)
        {
            DB::rollback();
            return back()->with('error', $e->getMessage());
        }




    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(items $products)
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
