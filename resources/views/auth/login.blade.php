@extends('layouts.auth', ['title' => 'Login'])
@section('content')
    @push('css')
        <style>
            .fxt-content {
                background: #12970b !important;
            }

            .fxt-header p {
                color: #fff !important;
            }
        </style>
    @endpush
    <livewire:auth.login-component />
@endsection
