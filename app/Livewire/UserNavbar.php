<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Auth;

class UserNavbar extends Component
{
    public $search = '';
    public $showSearchResults = false;
    public $searchResults = [];
    public $hideSearch = false;

    public function mount()
    {
        
    }

    public function updatedSearch()
    {
        
    }

    public function redirectToSearch()
    {
        
    }

    public function render()
    {
        return view('livewire.user-navbar', [
            'user' => Auth::user()
        ]);
    }
} 