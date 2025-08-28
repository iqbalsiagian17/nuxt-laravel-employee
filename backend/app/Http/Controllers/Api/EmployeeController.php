<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\EmployeeDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EmployeeController extends Controller
{
    // b. Upload Foto Pegawai
    public function uploadPhoto(Request $request, $id)
    {
        $employee = Employee::findOrFail($id);

        if ($request->hasFile('photo')) {
            // simpan foto ke storage/app/public/employees
            $path = $request->file('photo')->store('employees', 'public');
            $employee->photo = $path;
            $employee->save();

            return response()->json([
                'message' => 'Foto berhasil diupload',
                'data' => $employee
            ]);
        }

        return response()->json(['message' => 'Foto tidak ditemukan'], 400);
    }

    // c. Melihat Daftar Pegawai
    public function index()
    {
        $employees = Employee::with(['religion', 'employeeDetails.position', 'employeeDetails.workUnit'])->get();
        return response()->json($employees);
    }

    // f. Tambah Data Pegawai
    public function store(Request $request)
    {
        $request->validate([
            'employee_number' => 'nullable|unique:t_employees,employee_number',
            'full_name'       => 'nullable|string',
            'birth_place'     => 'nullable|string',
            'birth_date'      => 'nullable|date',
            'gender'          => 'nullable|string',
            'workplace'       => 'nullable|string',
            'rank'            => 'nullable|string',
            'echelon'         => 'nullable|string',
            'address'         => 'nullable|string',
            'religion_id'     => 'nullable|exists:t_religions,id',
            'position_id'     => 'nullable|exists:t_positions,id',
            'work_unit_id'    => 'nullable|exists:t_work_units,id',
            'phone_number'    => 'nullable|string',
            'tax_number'      => 'nullable|string',
        ]);

        $employee = Employee::create($request->only([
            'employee_number',
            'full_name',
            'birth_place',
            'birth_date',
            'gender',
            'address',
            'religion_id',
        ]));

        EmployeeDetail::create([
            'employee_id'   => $employee->id,
            'position_id'   => $request->position_id,
            'work_unit_id'  => $request->work_unit_id,
            'rank'          => $request->rank,
            'echelon'       => $request->echelon,
            'workplace'     => $request->workplace,
            'phone_number'  => $request->phone_number,
            'tax_number'    => $request->tax_number,
        ]);

        return response()->json([
            'message' => 'Pegawai berhasil ditambahkan',
            'data'    => $employee->load(['employeeDetails']),
        ], 201);
    }


    // g. Ubah Data Pegawai
    public function update(Request $request, $id)
    {
        $request->validate([
            'employee_number' => 'nullable|unique:t_employees,employee_number,' . $id,
            'full_name'       => 'nullable|string',
            'birth_place'     => 'nullable|string',
            'birth_date'      => 'nullable|date',
            'gender'          => 'nullable|string',
            'workplace'       => 'nullable|string',
            'rank'            => 'nullable|string',
            'echelon'         => 'nullable|string',
            'address'         => 'nullable|string',
            'religion_id'     => 'nullable|exists:t_religions,id',
            'position_id'     => 'nullable|exists:t_positions,id',
            'work_unit_id'    => 'nullable|exists:t_work_units,id',
            'phone_number'    => 'nullable|string',
            'tax_number'      => 'nullable|string',
        ]);

        $employee = Employee::findOrFail($id);

        $employee->update($request->only([
            'employee_number',
            'full_name',
            'birth_place',
            'birth_date',
            'gender',
            'address',
            'religion_id',
        ]));

        if ($employee->employeeDetails) {
            $employee->employeeDetails->update($request->only([
                'position_id',
                'work_unit_id',
                'rank',
                'echelon',
                'workplace',
                'phone_number',
                'tax_number',
            ]));
        } else {
            // kalau belum ada detail, buat baru
            EmployeeDetail::create(array_merge(
                $request->only([
                    'position_id',
                    'work_unit_id',
                    'rank',
                    'echelon',
                    'workplace',
                    'phone_number',
                    'tax_number',
                ]),
                ['employee_id' => $employee->id]
            ));
        }

        return response()->json([
            'message' => 'Pegawai berhasil diperbarui',
            'data'    => $employee->load(['employeeDetails']),
        ]);
    }


    // h. Hapus Data Pegawai
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        $employee->employeeDetails()->delete();
        $employee->delete();

        return response()->json(['message' => 'Pegawai berhasil dihapus']);
    }

    public function search(Request $request)
    {
        $keyword = $request->query('q');
        $employees = Employee::with(['religion', 'employeeDetails.position', 'employeeDetails.workUnit'])
            ->where('full_name', 'LIKE', "%{$keyword}%")
            ->orWhere('employee_number', 'LIKE', "%{$keyword}%")
            ->get();

        return response()->json($employees);
    }

    public function byUnit($id)
    {
        $employees = Employee::with(['religion', 'employeeDetails.position', 'employeeDetails.workUnit'])
            ->whereHas('employeeDetails', function($q) use ($id) {
                $q->where('work_unit_id', $id);
            })
            ->get();

        return response()->json($employees);
    }

}
