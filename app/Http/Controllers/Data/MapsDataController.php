<?php

namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Map;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class MapsDataController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Map::latest()->get();
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

        return view('data.maps.index');
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
            'type' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $request->file('image');
        $image->store('public/maps');

        Map::create([
            'name' => $request->name,
            'type' => $request->type,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'image' => $image->hashName(),
        ]);
        Alert::success('Success', 'Data Berhasil Ditambahkan');
        return redirect()->route('mapsdata.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $map = Map::find(decrypt($id));
        return response()->json($map);
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
        $request->validate([
            'name' => 'required',
            'type' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $map = Map::find(decrypt($id));
        $map->update([
            'name' => $request->name,
            'type' => $request->type,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
        ]);
        if ($request->hasFile('image')) {
            if ($map->image) {
                Storage::delete('public/maps/' . $map->image);
            }
            $image = $request->file('image');
            $image->store('public/maps');
            $map->update(['image' => $image->hashName()]);
        }
        Alert::success('Success', 'Data Berhasil Diubah');
        return redirect()->route('mapsdata.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $map = Map::find(decrypt($id));
        if ($map->image) {
            Storage::delete('public/maps/' . $map->image);
        }
        $map->delete();
        return response()->json(['success' => true]);
    }
}
