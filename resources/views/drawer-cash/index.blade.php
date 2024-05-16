@extends('layouts.app')
@section('title', 'Drawer Cash')
@section('content')
    <div class="dt-content">
        <div>
            <div class="dt-entry__header">
                <div class="dt-entry__heading">
                    <h3 class="dt-entry__title">Drawer Cash</h3>
                </div>
            </div>
            <livewire:drawer-cash-component/>
        </div>
    </div>
@endsection
