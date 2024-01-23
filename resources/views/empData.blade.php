<!DOCTYPE html>
<html>
<head>
    <title>Employee Datak </title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    @livewireStyles
</head>
<body>
<div class="container-fluid">
    <h2>Welcome To LiveWire</h2>
    <nav>
        <a href="/" wire:navigate>Dashboard</a>
        <a href="/emplist" wire:navigate>Employee Management</a>
    </nav>
    @livewire('emp-list')
</div>
    @livewireScripts
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

