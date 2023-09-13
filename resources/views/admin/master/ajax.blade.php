@foreach ($produtos as $product)
    <option value="{{ $product->id }}" sale="{{ $product->sale }}" nome="{{ $product->name }}"
        weight="{{ $product->weight }}" brand="{{ $product->brand }}">
        #{{ $product->id . ' - ' . $product->name . ' - ' . $product->brand . ' ( ' . $product->weight . ' ) ' . '-' . $product->amount }}
    </option>
@endforeach
