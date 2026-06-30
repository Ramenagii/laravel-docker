<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\Attributes\Layout;

#[Layout('layouts.app')]
class Dashboard extends Component
{
    public function render()
    {
        $totalProjects = Project::count();
        $tasksByStatus = Task::select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        $myTasks = Task::where('assigned_to', auth()->id())->count();
        $myPendingTasks = Task::where('assigned_to', auth()->id())
            ->whereIn('status', ['todo', 'in_progress', 'review'])
            ->count();

        $recentActivity = \Spatie\Activitylog\Models\Activity::with('causer')
            ->latest()
            ->take(10)
            ->get();

        return view('livewire.dashboard', [
            'totalProjects' => $totalProjects,
            'tasksByStatus' => $tasksByStatus,
            'myTasks' => $myTasks,
            'myPendingTasks' => $myPendingTasks,
            'recentActivity' => $recentActivity,
        ]);
    }
}
