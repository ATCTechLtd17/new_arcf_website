@extends('layouts.app')
@section('title', 'Banks')
@section('content')
    <div class="dt-content">
        <div>
            <div class="dt-entry__header">
                <div class="dt-entry__heading">
                    <h3 class="dt-entry__title">Banks</h3>
                </div>
            </div>
            <livewire:bank-component/>
        </div>
    </div>
@endsection
