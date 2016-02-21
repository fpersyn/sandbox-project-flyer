<?php

namespace App\Http\Controllers;

use App\Flyer;
use App\Photo;
use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Http\Requests\FlyerRequest;
use App\Http\Requests\AddPhotoRequest;
use Illuminate\Http\UploadedFile;

class FlyersController extends Controller
{
    public function __construct()
    {
        // block access to all methods unless logged in
    	$this->middleware('auth', ['except' => ['show']]);

        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('flyers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store(FlyerRequest $request)
    {
        $this->user->publish(
            new Flyer($request->all())
        );

        flash()->success('Success!', 'Your flyer has been created.');

        return redirect()->back(); //temporary
    }

    /**
     * Display the specified resource.
     *
     * @return Response
     */
    public function show($zip, $street)
    {
        $flyer = Flyer::locatedAt($zip, $street);

        return view('flyers.show', compact('flyer'));
    }

    /**
     * Apply a photo to the referenced flyer.
     *
     * @param $zip
     * @param $street
     * @param AddPhotoRequest $request
     */
    public function addPhoto($zip, $street, AddPhotoRequest $request)
    {
        $photo = $this->makePhoto($request->file('photo'));

        Flyer::locatedAt($zip, $street)->addPhoto($photo);
    }

    /**
     * Create a new Photo instance and move it.
     *
     * @param UploadedFile $file
     * @return mixed
     */
    public function makePhoto(UploadedFile $file)
    {
        return Photo::named($file->getClientOriginalName())
            ->move($file);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
