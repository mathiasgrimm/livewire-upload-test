<div>
    <div class="img-container" x-ref="container">
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
        </div>
    </div>
</div>
