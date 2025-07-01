<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Spatie\Image\Enums\Fit;
use Spatie\Image\Image;

class Test1 extends Component
{
    use WithFileUploads;

    public $image;
    public $temporaryUrl = '';

    public function render()
    {
        return view('livewire.test1')->layout('components.layouts.auth.simple');
    }

    public function resize()
    {
        $this->temporaryUrl = Storage::temporaryUrl('diagram.png', now()->addMinutes(5));

        // logger('starting...');
        //
        // $path = $this->image->getPathname();
        //
        // $t0 = microtime(true);
        //
        // logger('path: '.$path);
        // $image = Image::load($path);
        // logger('loaded...');
        //
        // $image->fit(Fit::Contain, desiredWidth: 330, desiredHeight: 162, backgroundColor: 'transparent');
        // logger('fit...');
        //
        // $image->save('/tmp/result.gif');
        // logger('saved...');
        //
        // logger('memory:'.(memory_get_usage(true) / 1024 / 1024).' MB time:'.round(microtime(true) - $t0).' seconds');
    }
}
