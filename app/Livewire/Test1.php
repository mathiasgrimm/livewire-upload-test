<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Image;

class Test1 extends Component
{
    use WithFileUploads;

    public $image;

    public function render()
    {
        return view('livewire.test1')->layout('components.layouts.auth.simple');
    }

    public function resize()
    {
        $t0 = microtime(true);
        $image = Image::load($this->image->getPathname());
        $image->fit(Fit::Contain, desiredWidth: 330, desiredHeight: 162, backgroundColor: 'transparent')
            ->save('/tmp/result.gif');

        logger('memory:'.(memory_get_usage(true) / 1024 / 1024).' MB time:'.round(microtime(true) - $t0).' seconds');
    }
}
