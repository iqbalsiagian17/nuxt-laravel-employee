<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkUnit;
use Illuminate\Http\Request;

class WorkUnitController extends Controller
{
    public function index()
    {
        $units = WorkUnit::all();
        return response()->json($units);
    }

    public function store(Request $request)
    {
        $request->validate([
            'unit_name' => 'required|string|max:255',
        ]);

        $unit = WorkUnit::create($request->all());
        return response()->json($unit, 201);
    }

    public function show($id)
    {
        $unit = WorkUnit::findOrFail($id);
        return response()->json($unit);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'unit_name' => 'required|string|max:255',
        ]);

        $unit = WorkUnit::findOrFail($id);
        $unit->update($request->all());

        return response()->json($unit);
    }

    public function destroy($id)
    {
        $unit = WorkUnit::findOrFail($id);
        $unit->delete();

        return response()->json(['message' => 'Work unit deleted successfully']);
    }
}
