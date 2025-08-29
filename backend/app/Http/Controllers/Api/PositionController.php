<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Position;

class PositionController extends Controller
{
    // Get all positions
    public function index()
    {
        $positions = Position::all();
        return response()->json([
            'success' => true,
            'data' => $positions
        ]);
    }

    // Store new position
    public function store(Request $request)
    {
        $request->validate([
            'position_name' => 'required|string|max:255'
        ]);

        $position = Position::create([
            'position_name' => $request->position_name
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Position created successfully',
            'data' => $position
        ], 201);
    }

    // Show specific position
    public function show($id)
    {
        $position = Position::find($id);

        if (!$position) {
            return response()->json([
                'success' => false,
                'message' => 'Position not found'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'data' => $position
        ]);
    }

    // Update position
    public function update(Request $request, $id)
    {
        $request->validate([
            'position_name' => 'required|string|max:255'
        ]);

        $position = Position::find($id);

        if (!$position) {
            return response()->json([
                'success' => false,
                'message' => 'Position not found'
            ], 404);
        }

        $position->update([
            'position_name' => $request->position_name
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Position updated successfully',
            'data' => $position
        ]);
    }

    // Delete position
    public function destroy($id)
    {
        $position = Position::find($id);

        if (!$position) {
            return response()->json([
                'success' => false,
                'message' => 'Position not found'
            ], 404);
        }

        $position->delete();

        return response()->json([
            'success' => true,
            'message' => 'Position deleted successfully'
        ]);
    }
}
