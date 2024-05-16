@extends('layouts.app')
@section('title', 'Profile')
@section('content')
    <div class="dt-content">
        <div>
            <div class="dt-entry__header">
                <!-- Entry Heading -->
                <div class="dt-entry__heading">
                    <h3 class="dt-entry__title">Profile </h3>
                </div>
                <!-- /entry heading -->
                <h4>Approval: Approved/Not Approved</h4>
            </div>
            <!-- /entry header -->
            <livewire:agent.agent-profile-component />
        </div>
    </div>
@endsection
