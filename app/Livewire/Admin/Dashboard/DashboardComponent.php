<?php

namespace App\Livewire\Admin\Dashboard;

use Livewire\Component;

class DashboardComponent extends Component
{
    public function render()
    {
        $data1 = [
            'labels' => ['New Consumer', 'Active Consumer'],
            'data' => [25, 30],
        ];
        $data2 = [
            'labels' => ['New Consumer', 'Active Consumer'],
            'data' => [25, 30],
        ];

        return view('livewire.admin.dashboard.dashboard-component', compact('data1', 'data2'));
    }
}
