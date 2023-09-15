<div class="row">
    <div class="col-md-6 ">
        <table class="table table-responsive">
            <thead>
            <th>
                <div class="alert alert-danger" role="alert">
                    Estoque ira durar menos de 7 dias
                </div>
            </th>
            </thead>


            @foreach ($data as $prod)
                @php
                    $product = Product::findProduct($prod->product_id);
                    $periodo = $startDate->diffInDays($endDate);
                    $estatisticasAlerta = Statistics::estoqueAlerta($prod->total_amount, $periodo);
                @endphp
                <tbody>
                @if (in_array($product->pluck('category_id')->implode(', '), $allowed_categories))
                    @if ($product->pluck('amount')->implode(', ') < $estatisticasAlerta * 0.5)
                        <tr>
                            <td>
                                <div class="alert alert-danger d-flex align-items-center" role="alert">
                                    <symbol id="info-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                    </symbol>

                                    <div>
                                        <h4 class="alert-heading">
                                            {!! '<strong>' .
                                                $product->pluck('name')->implode(', ') .
                                                ' ' .
                                                $product->pluck('brand')->implode(', ') .
                                                ' ' .
                                                $product->pluck('weight')->implode(', ') .
                                                '</strong>' !!}
                                        </h4>
                                        {!! 'Quantidade em Estoque: ' .
                                            $product->pluck('amount')->implode(', ') .
                                            '<p>Quantidade vendida no periodo de ' .
                                            $periodo .
                                            ' Dias: ' .
                                            '<strong>' .
                                            $prod->total_amount .
                                            '</strong>' !!}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endif
                </tbody>
            @endforeach

        </table>
    </div>
    <div class="col-md-6">
        <table class="table table-responsive">
            <thead>
            <th>
                <div class="alert alert-warning" role="alert">
                    Estoque ira durar de 7 á 14 dias
                </div>

            </th>
            </thead>

            @foreach ($data as $prod)
                @php
                    $product = Product::findProduct($prod->product_id);
                    $periodo = $startDate->diffInDays($endDate);
                    $estatisticasAlerta = Statistics::estoqueAlerta($prod->total_amount, $periodo);
                @endphp
                <tbody>
                @if (in_array($product->pluck('category_id')->implode(', '), $allowed_categories))
                    @if (
                        $product->pluck('amount')->implode(', ') <= $estatisticasAlerta &&
                            $product->pluck('amount')->implode(', ') > $estatisticasAlerta * 0.5)
                        <tr>
                            <td>
                                <div class="alert alert-warning d-flex align-items-center" role="alert">
                                    <symbol id="info-fill" viewBox="0 0 16 16">
                                        <path
                                            d="M8 16A8 8 0 1 0 8 0a8 8 0 0 0 0 16zm.93-9.412-1 4.705c-.07.34.029.533.304.533.194 0 .487-.07.686-.246l-.088.416c-.287.346-.92.598-1.465.598-.703 0-1.002-.422-.808-1.319l.738-3.468c.064-.293.006-.399-.287-.47l-.451-.081.082-.381 2.29-.287zM8 5.5a1 1 0 1 1 0-2 1 1 0 0 1 0 2z"/>
                                    </symbol>

                                    <div>
                                        <h4 class="alert-heading">
                                            {!! '<strong>' .
                                                $product->pluck('name')->implode(', ') .
                                                ' ' .
                                                $product->pluck('brand')->implode(', ') .
                                                ' ' .
                                                $product->pluck('weight')->implode(', ') .
                                                '</strong>' !!}
                                        </h4>
                                        {!! 'Quantidade em Estoque: ' .
                                            $product->pluck('amount')->implode(', ') .
                                            '<p>Quantidade vendida no periodo de ' .
                                            $periodo .
                                            ' Dias: ' .
                                            '<strong>' .
                                            $prod->total_amount .
                                            '</strong>' !!}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endif
                @endif
                </tbody>
            @endforeach

        </table>
    </div>
</div>
