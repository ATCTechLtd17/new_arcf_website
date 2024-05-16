@extends('layouts.app')
@section('title', 'Income vs Expense')
@section('content')
    <div class="dt-content">
        <div>
            <div class="dt-entry__header">
                <div class="dt-entry__heading">
                    <h3 class="dt-entry__title">Income vs Expense</h3>
                </div>
            </div>
            <livewire:income-vs-expense-component/>
        </div>
    </div>
@endsection
