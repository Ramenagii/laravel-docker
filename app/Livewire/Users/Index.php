<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\Attributes\Layout;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

#[Layout('layouts.app')]
class Index extends Component
{
    use WithPagination;

    public $search = '';
    public $editingRole = null;
    public $selectedRole = '';

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function editRole($userId)
    {
        $this->editingRole = $userId;
        $user = User::find($userId);
        $this->selectedRole = $user?->roles()->first()?->name ?? '';
    }

    public function saveRole()
    {
        $this->authorize('users.manage');

        $this->validate([
            'selectedRole' => ['required', Rule::in(Role::pluck('name')->toArray())],
        ]);

        $user = User::findOrFail($this->editingRole);
        $user->syncRoles([$this->selectedRole]);

        $this->editingRole = null;
        $this->selectedRole = '';
        session()->flash('message', 'Role updated successfully.');
    }

    public function cancelEdit()
    {
        $this->editingRole = null;
        $this->selectedRole = '';
    }

    public function render()
    {
        $users = User::with('roles')
            ->when($this->search, fn($q) => $q->where('name', 'like', "%{$this->search}%")->orWhere('email', 'like', "%{$this->search}%"))
            ->paginate(10);

        $roles = Role::all();

        return view('livewire.users.index', [
            'users' => $users,
            'roles' => $roles,
        ]);
    }
}
