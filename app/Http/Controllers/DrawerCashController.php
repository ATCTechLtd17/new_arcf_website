<?php

namespace App\Http\Controllers;

class DrawerCashController extends Controller
{
    public function index()
    {
        return view('drawer-cash.index');
    }

    public function supplierDeposit(){
        return view('drawer-cash.supplier-deposit');
    }

}
