@extends('layouts.app')
@section('title', 'Customers')
@section('content')
    <div class="dt-content">
        <div>
            <div class="dt-entry__header">
                <div class="dt-entry__heading">
                    <h3 class="dt-entry__title">Customers</h3>
                </div>
            </div>
            <livewire:customer-component/>
        </div>
    </div>
@endsection
