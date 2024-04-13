<?php

namespace App\Http\Controllers;

use App\Models\Major;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MajorController extends Controller
{
    const PATH_VIEW = 'majors.';
    const PATH_UPLOAD = 'majors';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Major::query()->latest()->paginate(5);

        return view(self::PATH_VIEW . __FUNCTION__ , compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(self::PATH_VIEW . __FUNCTION__ );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = \request()->except('img');

        if (\request()->hasFile('img')){
            $data['img'] = Storage::put(self::PATH_UPLOAD, \request()->file('img'));
        }

        Major::query()->create($data);

        return back()->with('msg', 'Successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(Major $major)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('major') );
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Major $major)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('major') );

        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Major $major)
    {
        $data = \request()->except('img');

        if (\request()->hasFile('img')){
            $data['img'] = Storage::put(self::PATH_UPLOAD, \request()->file('img'));
        }

        $oldImg = $major->img;
        $major->update($data);

        if (\request()->hasFile('img') && Storage::exists($oldImg)){
            Storage::delete($oldImg);
        }

        return back()->with('msg', 'Successfully created');

        }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Major $major)
    {
        $major->delete();

        if (Storage::exists($major->img)) {
            Storage::delete($major->img);
        }
    }
}
