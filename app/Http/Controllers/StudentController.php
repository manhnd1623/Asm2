<?php

namespace App\Http\Controllers;

use App\Models\student;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class studentController extends Controller
{
    const PATH_VIEW = 'students.';
    const PATH_UPLOAD = 'students';

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = student::query()->with('major')->paginate(5);

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

        student::query()->create($data);

        return back()->with('msg', 'Successfully created');
    }

    /**
     * Display the specified resource.
     */
    public function show(student $student)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('student') );
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(student $student)
    {
        return view(self::PATH_VIEW . __FUNCTION__, compact('student') );

        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, student $student)
    {
        $data = \request()->except('img');

        if (\request()->hasFile('img')){
            $data['img'] = Storage::put(self::PATH_UPLOAD, \request()->file('img'));
        }

        $oldImg = $student->img;
        $student->update($data);

        if (\request()->hasFile('img') && Storage::exists($oldImg)){
            Storage::delete($oldImg);
        }

        return back()->with('msg', 'Successfully created');

        }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(student $student)
    {
        $student->delete();

        if (Storage::exists($student->img)) {
            Storage::delete($student->img);
        }
    }
}
