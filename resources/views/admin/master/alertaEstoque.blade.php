@foreach ($dados as $item)
    @foreach ($item as $prod)
        @php
            $produto = Produto::findProduct($prod->id_produto);
            $periodo = $startDate->diffInDays($endDate);
            $estatisticasAlerta = Estatisticas::estoqueAlerta($prod->total_vendas, $periodo);
        @endphp

        @if (in_array($produto->pluck('id_categoria')->implode(', '), $categoriasPermitidas))
            @if ($produto->pluck('quantidade')->implode(', ') < $estatisticasAlerta)
                <div class="alert              
                {{ $produto->pluck('quantidade')->implode(', ') >= $estatisticasAlerta * 0.5 ? 'alert-warning' : 'alert-danger' }}
                d-flex align-items-center"
                    role="alert">
                    <symbol id="info-fill" viewBox="0 0 16 16">
                        <path
                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z" />
                    </symbol>

                    <div>
                        <h4 class="alert-heading">
                            {!! '<strong>' .
                                $produto->pluck('nome')->implode(', ') .
                                ' ' .
                                $produto->pluck('marca')->implode(', ') .
                                ' ' .
                                $produto->pluck('peso')->implode(', ') .
                                '</strong>' !!}
                        </h4>
                        {!! 'Quantidade em Estoque: ' .
                            $produto->pluck('quantidade')->implode(', ') .
                            '<p>Quantidade vendida no periodo de ' .
                            $periodo .
                            ' Dias: ' .
                            '<strong>' .
                            $prod->total_vendas .
                            '</strong>' !!}
                    </div>
                </div>
            @endif
        @endif
    @endforeach
@endforeach
