<div>
    <div class="img-container" x-ref="container">

        <div>
            Temporary URL: {{ $temporaryUrl }}
        </div>

        <div style="position: relative;" x-ref="wrapper">
            @if ($image)
                <img
                    class="object-contain"
                    src="{{ $image->temporaryUrl() }}"
                    alt="Select points on this image"
                    id="targetImage"
                    x-ref="image"
                >
            @endif

            <flux:input type="file" wire:model="image" label="Image"/>
            <flux:button wire:click="resize">Resize</flux:button>
        </div>
    </div>
</div>
