<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;

class Test1 extends Component
{
    use WithFileUploads;

    public $image;

    public function render()
    {
        return view('livewire.test1')->layout('components.layouts.auth.simple');
    }
}
