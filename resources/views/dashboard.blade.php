@extends('layouts.app')
@section('title', 'Dashboard')
@section('content')
    <div class="dt-content">
        <div>
            <div class="dt-entry__header">
                <div class="dt-entry__heading">
                    <h3 class="dt-entry__title">Dashboard</h3>
                </div>
            </div>
            <livewire:dashboard-component/>
        </div>
    </div>
@endsection
