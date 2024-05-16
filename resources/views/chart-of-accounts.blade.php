@extends('layouts.app')
@section('title', 'Chart of Accounts')
@section('content')
    <div class="dt-content">
        <div>
            <div class="dt-entry__header">
                <div class="dt-entry__heading">
                    <h3 class="dt-entry__title">Chart of Accounts</h3>
                </div>
            </div>
            <livewire:chart-of-account-component/>
        </div>
    </div>
@endsection
