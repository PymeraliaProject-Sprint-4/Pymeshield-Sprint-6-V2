<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDeviceUserRequest;
use App\Http\Requests\UpdateDeviceUserRequest;
use App\Models\DeviceUser;

class DeviceUserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Http\Requests\StoreDeviceUserRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreDeviceUserRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\DeviceUser  $deviceUser
     * @return \Illuminate\Http\Response
     */
    public function show(DeviceUser $deviceUser)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\DeviceUser  $deviceUser
     * @return \Illuminate\Http\Response
     */
    public function edit(DeviceUser $deviceUser)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateDeviceUserRequest  $request
     * @param  \App\Models\DeviceUser  $deviceUser
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateDeviceUserRequest $request, DeviceUser $deviceUser)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\DeviceUser  $deviceUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(DeviceUser $deviceUser)
    {
        //
    }
}
