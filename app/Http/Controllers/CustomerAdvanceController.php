<?php

namespace App\Http\Controllers;

use App\Models\CustomerAdvance;

class CustomerAdvanceController extends Controller
{
    public function index()
    {
        return view('customer-advance.index');
    }

    public function print($id)
    {
        $advance = CustomerAdvance::findOrFail($id);

        return view('customer-advance.print', compact('advance'));
    }

    public function details()
    {
        return view('customer-advance.details');
    }
}
