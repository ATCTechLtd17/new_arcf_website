@extends('layouts.app')
@section('title', 'Agents')
@section('content')
    <div class="dt-content">
        <div>
            <div class="dt-entry__header">
                <div class="dt-entry__heading">
                    <h3 class="dt-entry__title">Agents</h3>
                </div>
            </div>
            <livewire:agent-component/>
        </div>
    </div>
@endsection
