@extends('layouts.app')
@section('title', 'Services')
@section('content')
    <div class="dt-content">
        <div>
            <div class="dt-entry__header">
                <div class="dt-entry__heading">
                    <h3 class="dt-entry__title">Services</h3>
                </div>
            </div>
            <livewire:service-component/>
        </div>
    </div>
@endsection
