{{-- <!DOCTYPE html>
<html>
<head>
    <title>Laravel Livewire Test Setup</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @livewireStyles
</head>
<body> --}}
    @extends('livewire.admin.layouts.base')
    {{-- @livewire('hello-world') --}}
    @yield('content')
    <nav>
        <a href="/" wire:navigate>Dashboard</a>
        <a href="/emplist" wire:navigate>Employee Management</a>
    </nav>
    @livewire('emp-list')

    @livewireScripts


