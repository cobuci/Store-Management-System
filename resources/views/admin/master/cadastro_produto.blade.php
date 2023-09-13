<select class="form-select" id="categoria"
        style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color:rgb(0, 0, 0);"
        name="categoria">
    <optgroup label="Categoria">
        @foreach (Category::listar() as $cat)
            <option value="{{ $cat->id }}">{{ $cat->nome }}</option>
        @endforeach
    </optgroup>
</select>
<input class="form-control" type="text" id="nome" placeholder="Nome (*)" value="{{ $product->nome }}" name="nome"
       style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"/>
<input class="form-control" type="text" id="marca" placeholder="Marca" name="marca"
       style="color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);"
       inputmode="tel"/>
<input class="form-control" type="text" id="peso" placeholder="Unidade (*)" name="peso"
       style="background: rgba(255, 255, 255, 0);color: var(--bs-white);border-radius: 10px;margin-bottom: 10px;border-color: rgba(255, 255, 255, 0.17);"
       inputmode="numeric"/>
<select class="form-select" id="tipoPeso"
        style="border-radius: 10px;margin-bottom: 10px;background: rgba(255, 255, 255, 0);border-color: rgba(255, 255, 255, 0.17);color:rgb(0, 0, 0);"
        name="tipoPeso">
    <optgroup label="Unidade">
        <option value="">Peso</option>
        <option value="ml">Mililitros</option>
        <option value="L">Litros</option>
        <option value="KG">Kg</option>
        <option value="g">Gramas</option>
        <option value="un">Unidade</option>
    </optgroup>
</select>
