@foreach ($produtos as $produto)
  
        <option value="{{ $produto->id }}" preco="{{ $produto->venda }}">
            #{{ $produto->id . ' - ' . $produto->nome . ' - ' . $produto->marca . ' ( ' . $produto->peso . ' ) ' }}
        </option>
  
@endforeach
