<!-- resources/views/livewire/sales-component.blade.php -->

<div>
    @if($sales)
        <ul>
            @foreach($sales as $sale)
                <li>
                    <strong>Cliente: </strong>{{ $sale['customer'] }} <br>
                    <strong>Data da Venda:</strong> {{ $sale['date'] }} <br>
                    <strong>Ultima atualização: </strong> {{ $sale['updated'] }} <br>
                    <strong>Itens:</strong>
                    <ul>
                        @foreach($sale['items'] as $item)
                            <li>{{ $item['name'] }} - R$ {{ $item['sale'] }} - Qt. {{ $item['amount'] }}  </li>
                        @endforeach
                    </ul>
                </li>
                <hr>
            @endforeach
        </ul>
    @else
        <p>Nenhuma venda encontrada.</p>
    @endif
</div>
