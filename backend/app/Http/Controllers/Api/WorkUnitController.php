<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\WorkUnit;
use Illuminate\Http\Request;

class WorkUnitController extends Controller
{
    /**
     * Ambil semua unit kerja (flat list)
     */
    public function index()
    {
        $units = WorkUnit::all();
        return response()->json($units);
    }

    /**
     * Tambah unit kerja baru
     */
    public function store(Request $request)
    {
        $request->validate([
            'unit_name' => 'required|string|max:255'
        ]);

        $unit = WorkUnit::create($request->only('unit_name'));
        return response()->json($unit, 201);
    }

    /**
     * Ambil detail unit kerja by ID
     */
    public function show($id)
    {
        $unit = WorkUnit::findOrFail($id);
        return response()->json($unit);
    }

    /**
     * Update unit kerja
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'unit_name' => 'required|string|max:255'
        ]);

        $unit = WorkUnit::findOrFail($id);
        $unit->update($request->only('unit_name'));

        return response()->json($unit);
    }

    /**
     * Hapus unit kerja
     */
    public function destroy($id)
    {
        $unit = WorkUnit::findOrFail($id);
        $unit->delete();

        return response()->json(['message' => 'Work unit deleted successfully']);
    }
}
