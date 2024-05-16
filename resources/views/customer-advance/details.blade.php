@extends('layouts.app')
@section('title', 'Manage Customer Advance Details')
@section('content')
    <div class="dt-content">
        <div>
            <div class="dt-entry__header">
                <div class="dt-entry__heading">
                    <h3 class="dt-entry__title">Customer Advance Details</h3>
                </div>
            </div>
            <livewire:customer-advance-details-component/>
        </div>
    </div>
@endsection
