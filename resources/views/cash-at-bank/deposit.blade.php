@extends('layouts.app')
@section('title', 'Cash at Bank to Supplier')
@section('content')
    <div class="dt-content">
        <div>
            <div class="dt-entry__header">
                <div class="dt-entry__heading">
                    <h3 class="dt-entry__title">Cash at Bank to Supplier</h3>
                </div>
            </div>
            <livewire:cash-at-bank-deposits-component/>
        </div>
    </div>
@endsection
