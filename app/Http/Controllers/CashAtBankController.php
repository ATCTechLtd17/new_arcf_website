<?php

namespace App\Http\Controllers;

class CashAtBankController extends Controller
{
    public function index()
    {
        return view('cash-at-bank.index');
    }

    public function deposit(){
        return view('cash-at-bank.deposit');
    }

    public function drawer(){
        return view('cash-at-bank.drawer');
    }

    public function drawerCashToBank(){
        return view('cash-at-bank.drawer-to-bank');
    }

}
