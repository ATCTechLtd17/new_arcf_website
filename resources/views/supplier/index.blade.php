@extends('layouts.app')
@section('title', 'Suppliers')
@section('content')
    <div class="dt-content">
        <div>
            <div class="dt-entry__header">
                <div class="dt-entry__heading">
                    <h3 class="dt-entry__title">Suppliers</h3>
                </div>
            </div>
            <livewire:supplier-component/>
        </div>
    </div>
@endsection
