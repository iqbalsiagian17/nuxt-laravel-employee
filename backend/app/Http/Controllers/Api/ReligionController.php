<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Religion;
use Illuminate\Http\Request;

class ReligionController extends Controller
{
    public function index()
    {
        return response()->json(Religion::all(), 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|max:50|unique:t_religions,name',
        ]);

        $religion = Religion::create([
            'name' => $request->name,
        ]);

        return response()->json($religion, 201);
    }

    public function show($id)
    {
        $religion = Religion::find($id);

        if (!$religion) {
            return response()->json(['message' => 'Religion not found'], 404);
        }

        return response()->json($religion, 200);
    }

    public function update(Request $request, $id)
    {
        $religion = Religion::find($id);

        if (!$religion) {
            return response()->json(['message' => 'Religion not found'], 404);
        }

        $request->validate([
            'name' => 'required|max:50|unique:t_religions,name,' . $id,
        ]);

        $religion->update([
            'name' => $request->name,
        ]);

        return response()->json($religion, 200);
    }

    public function destroy($id)
    {
        $religion = Religion::find($id);

        if (!$religion) {
            return response()->json(['message' => 'Religion not found'], 404);
        }

        $religion->delete();

        return response()->json(['message' => 'Religion deleted successfully'], 200);
    }
}
