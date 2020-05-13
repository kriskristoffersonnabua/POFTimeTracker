<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\SubProject;
use Illuminate\Http\Request;

class SubProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sub_projects.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\SubProject  $subProject
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\SubProject  $subProject
     * @return \Illuminate\Http\Response
     */
    public function edit(SubProject $subProject)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SubProject  $subProject
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SubProject $subProject)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SubProject  $subProject
     * @return \Illuminate\Http\Response
     */
    public function destroy(SubProject $subProject)
    {
        //
    }
}
