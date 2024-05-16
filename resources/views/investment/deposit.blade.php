@extends('layouts.app')
@section('title', 'Investment to Deposit')
@section('content')
    <div class="dt-content">
        <div>
            <div class="dt-entry__header">
                <div class="dt-entry__heading">
                    <h3 class="dt-entry__title">Investment to Deposit</h3>
                </div>
            </div>
            <livewire:investment-deposit-component/>
        </div>
    </div>
@endsection
