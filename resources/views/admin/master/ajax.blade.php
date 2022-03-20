@foreach ($produtos as $produto)
  
        <option value="{{ $produto->id }}" preco="{{ $produto->venda }}" nome="{{$produto->nome}}"  peso="{{$produto->peso}}"  marca="{{$produto->marca}}">
            #{{ $produto->id . ' - ' . $produto->nome . ' - ' . $produto->marca . ' ( ' . $produto->peso . ' ) ' }}
        </option>
  
@endforeach
