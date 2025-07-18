<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMenuItemRequest;
use App\Models\MenuItem;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'data' => MenuItem::with('category')->get()
        ]);
    }

    public function store(StoreMenuItemRequest $request)
    {
        $menuItem = MenuItem::create($request->validated());

        return response()->json([
            'success' => true,
            'data' => $menuItem
        ], 201);
    }

    public function show(MenuItem $menuItem)
    {
        return response()->json([
            'success' => true,
            'data' => $menuItem->load('category')
        ]);
    }

    public function update(StoreMenuItemRequest $request, MenuItem $menuItem)
    {
        $menuItem->update($request->validated());

        return response()->json([
            'success' => true,
            'data' => $menuItem
        ]);
    }

    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();

        return response()->json([
            'success' => true,
            'message' => 'Menu item deleted successfully.'
        ]);
    }
}
