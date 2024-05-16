@extends('layouts.app')
@section('title', 'Investments')
@section('content')
    <div class="dt-content">
        <div>
            <div class="dt-entry__header">
                <div class="dt-entry__heading">
                    <h3 class="dt-entry__title">Investments</h3>
                </div>
            </div>
            <livewire:investments-component/>
        </div>
    </div>
@endsection
