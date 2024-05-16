@extends('layouts.app')
@section('title', 'Expense Details Report')
@section('content')
    <div class="dt-content">
        <div>
            <div class="dt-entry__header">
                <div class="dt-entry__heading">
                    <h3 class="dt-entry__title">Expense Details Report</h3>
                </div>
            </div>
            <livewire:expense-details-report-component/>
        </div>
    </div>
@endsection
