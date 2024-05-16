@extends('layouts.app')
@section('title', 'Manage Cash at Bank')
@section('content')
    <div class="dt-content">
        <div>
            <div class="dt-entry__header">
                <div class="dt-entry__heading">
                    <h3 class="dt-entry__title">Cash at Bank</h3>
                </div>
            </div>
            <livewire:cash-at-bank-component/>
        </div>
    </div>
@endsection
