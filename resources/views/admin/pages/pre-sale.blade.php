<!-- resources/views/livewire/sales-component.blade.php -->

<div class="w-full">
    @if ($sales)
        <ul>
            @foreach ($sales as $sale)
                @livewire('components.pre-sale-item', ['sale' => $sale])
            @endforeach
        </ul>
    @else
        <p>Nenhuma venda encontrada.</p>
    @endif
</div>
