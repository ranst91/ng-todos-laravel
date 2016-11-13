<?php

namespace App\Http\Controllers;

use App\Exceptions\Handler;
use Illuminate\Http\Request;
use App\Label;
use App\Http\Requests;
use League\Flysystem\Exception;
use Tymon\JWTAuth\Facades\JWTAuth;

class LabelsController extends Controller
{
    private function getUser() {
        $user = JWTAuth::parseToken()->authenticate();
        if (!$user)
            return response()->json(['message' => 'User not authenticated'], 401);
        return $user;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $user = $this->getUser();
        $labels = $user->labels->all();
        if (!$labels)
            return response()->json(['message' => 'Error getting the labels'], 404);

        return response()->json(['labels' => $labels], 200);
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
        $user = $this->getUser();

        $label = new Label();
        $label->title = $request->input('title');

        $user->labels()->save($label);

        return response()->json(['message' => 'Label created'], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $label
     * @return \Illuminate\Http\Response
     */
    public function show(Label $label)
    {
        $user = $this->getUser();
        $label = $user->labels->find($label);
        $list = $label->tasks->all();

        if (!$label or !$list)
            return response()->json(['message' => 'Error getting the data you requested'], 404);

        return response()->json(['data' => ['labels'=>$label]], 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $label
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Label $label)
    {
        $user = $this->getUser();
        $label->title = $request->input('title');

        $user->labels()->save($label);

        return response()->json(['message' => 'Label updated successfully'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $label
     * @return \Illuminate\Http\Response
     */
    public function destroy(Label $label)
    {
        $user = $this->getUser();
        $label = $user->labels->find($label);

        if (!$label)
            return response()->json(['message' => 'Error getting the labels'], 404);

        $label->delete();

        return response()->json(['message' => 'delete success'], 200);
    }
}
