<?php

namespace App\Http\Controllers;

use App\Models\Olt;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class OltController extends Controller
{

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Olt::latest()->get();
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

        return view('olt.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
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

        Olt::create($request->all());
        Alert::success('Success', 'Data Berhasil Ditambahkan');
        return redirect()->route('olt.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $olt = Olt::find(decrypt($id));
        return response()->json($olt);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
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

        $olt = Olt::find($id);
        $olt->update($request->all());
        Alert::success('Success', 'Data Berhasil Diubah');
        return redirect()->route('olt.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $olt = Olt::find(decrypt($id));
        $olt->delete();
        return response()->json(['success' => true]);
    }
}
