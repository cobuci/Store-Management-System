@foreach ($produtos as $produto)
    <option value="{{ $produto->id }}" sale="{{ $produto->sale }}" nome="{{ $produto->name }}"
        weight="{{ $produto->weight }}" brand="{{ $produto->brand }}">
        #{{ $produto->id . ' - ' . $produto->name . ' - ' . $produto->brand . ' ( ' . $produto->weight . ' ) ' . '-' . $produto->amount }}
    </option>
@endforeach
