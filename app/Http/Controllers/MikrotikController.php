<?php

namespace App\Http\Controllers;

use App\Models\Mikrotik;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class MikrotikController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Mikrotik::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<a href="javascript:void(0)" class="edit btn btn-primary btn-sm" data-id="' . encrypt($row->id) . '">Edit</a>';
                    $btn .= ' <a href="javascript:void(0)" class="delete btn btn-danger btn-sm" data-id="' . encrypt($row->id) . '">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('mikrotik.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users',
            'password' => 'required',
            'address' => 'required',
            'port' => 'required',
        ]);

        Mikrotik::create($request->all());
        Alert::success('Success', 'Data Berhasil Ditambahkan');
        return redirect()->route('mikrotik.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $mikrotik = Mikrotik::find(decrypt($id));
        return response()->json($mikrotik);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $id = decrypt($id);
        $request->validate([
            'name' => 'required',
            'username' => 'required|unique:users,username,' . $id,
            'password' => $request->password ? 'required' : '',
            'address' => 'required',
            'port' => 'required',
        ]);

        $mikrotik = Mikrotik::find($id);
        $mikrotik->update($request->all());
        Alert::success('Success', 'Data Berhasil Diubah');
        return redirect()->route('mikrotik.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $mikrotik = Mikrotik::find(decrypt($id));
        $mikrotik->delete();
        return response()->json(['success' => true]);
    }
}
