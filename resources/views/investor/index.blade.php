@extends('layouts.app')
@section('title', 'Investors')
@section('content')
    <div class="dt-content">
        <div>
            <div class="dt-entry__header">
                <div class="dt-entry__heading">
                    <h3 class="dt-entry__title">Investors</h3>
                </div>
            </div>
            <livewire:investor-component/>
        </div>
    </div>
@endsection
