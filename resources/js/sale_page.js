
$(document).ready(function () {
    let row_number = 1;

    let amount = $("#amount");
    let product = $("#product");

    $("#adicionar").click(function (e) {
        e.preventDefault();

        let precoAttr = ($("#product option:selected").attr('sale'));
        let quantAttr = $("#amount").val();

        if (amount.val() && product.val()) {
            let new_row_number = row_number - 1;
            $('#product' + row_number)
                .html($('#product' + new_row_number).html())
                .find('ul li:first-child');
            jQuery('<li>', {
                id: 'product' + row_number,
                class: 'listaVenda item',
                text: $("#amount").val() +
                    " - " +
                    $("#product option:selected")
                        .attr(
                            'nome') +
                    " - " +
                    $("#product option:selected").attr('brand') +
                    " - " +
                    $("#product option:selected").attr('weight'),
                sale: parseFloat(precoAttr) * parseFloat(quantAttr),

            }).appendTo('#lista');

            jQuery('<input>', {
                id: 'product_id' + row_number,
                name: 'product' + row_number,
                value: $("#product option:selected").val(),
            }).attr('type', 'hidden').appendTo('#lista');

            jQuery('<input>', {
                id: 'item_amount' + row_number,
                name: 'amount' + row_number,
                value: quantAttr,
            }).attr('type', 'hidden').appendTo('#lista');
            row_number++;


        }
        $('#amount').val("");
    });

    $("#remover").click(function (e) {
        e.preventDefault();
        if (row_number > 1) {
            $("#product" + (row_number - 1)).remove();
            $("#product_id" + (row_number - 1)).remove();
            row_number--;
        }
    });
});

const calcularTotal = () => {
    const total = document.getElementById('total_price');
    const qtdProdutos = document.getElementById('item_amount');


    let resultado = 0;

    Array.from(document.getElementsByClassName("item")).forEach(function (item) {
        resultado = parseFloat(resultado) + parseFloat(item.getAttribute("sale"))

    });
    total.value = resultado.toFixed(2);
    qtdProdutos.value = $(".ulProduto li").length;
}

const lista = document.querySelector("#lista");
const discount = document.getElementById("discount")

const observer = new MutationObserver(function () {
    calcularTotal();

});

observer.observe(lista, {
    childList: true
});

$(discount).keypress(function(){
    calcularValor();
});
const calcularValor = () => {
    let discount = document.getElementById("discount").value;

    const total = document.getElementById('total_price');

    const resultado = parseFloat(total.value) - (discount);

    total.value = resultado.toFixed(2);

}
$(document).ready(function () {
    $("#categoria").change(function () {
        const url = $('#personForm').attr("data-url");
        let categoria = $(this).val();
        $.ajax({
            url: url,
            data: {
                'categoria': categoria,
            },
            success: function (data) {
                $("#product").html(data);
            }
        });
    });
});
