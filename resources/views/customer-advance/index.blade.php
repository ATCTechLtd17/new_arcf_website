@extends('layouts.app')
@section('title', 'Manage Customer Advance')
@section('content')
    <div class="dt-content">
        <div>
            <div class="dt-entry__header">
                <div class="dt-entry__heading">
                    <h3 class="dt-entry__title">Customer Advance</h3>
                </div>
            </div>
            <livewire:customer-advance-component/>
        </div>
    </div>
@endsection
