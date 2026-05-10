<?php

namespace App\Http\Controllers\Admin\WhatsFleep;

use App\Http\Controllers\Controller;
use App\Models\WhatsFleep\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    public function index()
    {
        return view('admin.whats-fleep.devices.index');
    }

    public function scan(string $body)
    {
        $device = Device::where('body', $body)->firstOrFail();

        return view('admin.whats-fleep.devices.scan', compact('device'));
    }

    public function setSelectedDeviceSession(Request $request)
    {
        $device = $request->user()->waDevices()->whereId($request->device)->first();

        if (!$device) {
            session()->forget('selectedDevice');

            return response()->json(['error' => true, 'msg' => 'Device not found!']);
        }

        session()->put('selectedDevice', [
            'device_id'   => $device->id,
            'device_body' => $device->body,
        ]);

        return response()->json(['error' => false, 'msg' => 'Device selected!']);
    }
}
