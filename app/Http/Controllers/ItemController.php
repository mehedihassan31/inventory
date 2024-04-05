<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use App\Http\Requests\ItemRequest;
use App\Http\Resources\ItemResource;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ItemResource::collection(Item::all());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ItemRequest $request)
    {

        $validatedData = $request->validated();

        // Handle image upload
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items/images', 'public');
            $basePath = config('app.url') . '/storage/'; 
            $validatedData['image'] = $basePath . $imagePath;
            // $validatedData['image'] = $imagePath;
        }

        $item = Item::create($validatedData);
        return new ItemResource($item);
    }


    public function updateData(Request $request, Item $item)
    {


        $validator = Validator::make($request->all(), [
            'inventory_id' => 'sometimes|required|exists:inventories,id',
            'name' => 'sometimes|required|string|max:255',
            'description' => 'nullable|string',
            'image' => 'nullable',
            'quantity' => 'sometimes|required|integer|min:0',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $validatedData = $validator->validated();
        if ($request->hasFile('image')) {

            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            // Store the new image and update the image URL
            $imagePath = $request->file('image')->store('items/images', 'public');
            $basePath = config('app.url') . '/storage/'; // Retrieve base URL from config
            $validatedData['image'] = $basePath . $imagePath;
        }

        $item->update($validatedData);
        return new ItemResource($item);
    }


    /**
     * Display the specified resource.
     */
    public function show(Item $item)
    {
        return new ItemResource($item);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Item $item)
    {
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Item $item)
    {
        $item->delete();
        return response()->noContent();
    }
}
