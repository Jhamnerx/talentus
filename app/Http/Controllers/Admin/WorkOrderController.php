<?php

namespace App\Http\Controllers\Admin;

use App\Models\WorkOrder;
use App\Http\Controllers\Controller;

class WorkOrderController extends Controller
{
    public function index()
    {
        return view('admin.work-orders.index');
    }

    public function show(WorkOrder $workOrder)
    {
        return view('admin.work-orders.show', compact('workOrder'));
    }
}
