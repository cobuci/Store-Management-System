const mudarValorUnitario = () => {
    let custo = document.getElementById("cost");
    let custoTotal = parseFloat(
        document.getElementById("cost_total").value
    );
    let quantidade = document.getElementById("amount").value;

    let resultado = custoTotal / quantidade;

    custo.value = resultado.toFixed(2);
};

function mudarValorTotal() {
    let custo = parseFloat(document.getElementById("cost").value);
    let custoTotal = document.getElementById("cost_total");
    let quantidade = document.getElementById("amount").value;

    let resultado = custo * quantidade;

    custoTotal.value = resultado.toFixed(2);
}

function calcularValorQuantidade() {
    mudarValorTotal();
}

function valorRadio() {
    radioCalculo();

    insere();
}

const insere = () => {
    var custo = parseFloat(document.getElementById("cost").value);
    var valorVenda = document.getElementById("sale").value;
    var lucro = document.getElementById("profit");

    valorLucro = valorVenda - custo;

    calculo = valorLucro / valorVenda;
    calculo = calculo * 100;

    if (calculo >= 0) {
        lucro.innerHTML = " + " + calculo.toFixed(2) + "%";
    } else {
        lucro.innerHTML = "";
    }
};

const radioCalculo = () => {
    var valorVenda = document.getElementById("sale");
    var radioBtn25 = document.getElementById("radio1");
    var radioBtn50 = document.getElementById("radio2");
    var radioBtn75 = document.getElementById("radio3");
    var radioBtn100 = document.getElementById("radio4");

    if (radioBtn25.checked) {
        var custo = document.getElementById("cost").value;
        if (custo != 0) {
            var custo = document.getElementById("cost").value;
            if (custo != 0) {
                porcentagem = 25;
                z = 100;
                x = parseFloat(porcentagem / z);
                y = 1 - x;

                resultadoCalc = custo / y;
                valorVenda.value = resultadoCalc.toFixed(2);
            }
        }
    } else if (radioBtn50.checked) {
        var custo = document.getElementById("cost").value;

        if (custo != 0) {
            porcentagem = 50;
            z = 100;
            x = parseFloat(porcentagem / z);
            y = 1 - x;

            resultadoCalc = custo / y;
            valorVenda.value = resultadoCalc.toFixed(2);
        }
    } else if (radioBtn75.checked) {
        var custo = document.getElementById("cost").value;

        if (custo != 0) {
            porcentagem = 75;
            z = 100;
            x = parseFloat(porcentagem / z);
            y = 1 - x;

            resultadoCalc = custo / y;
            valorVenda.value = resultadoCalc.toFixed(2);
        }
    } else if (radioBtn100.checked) {
        var custo = document.getElementById("cost").value;

        if (custo != 0) {
            porcentagem = 90;
            z = 100;
            x = parseFloat(porcentagem / z);
            y = 1 - x;

            resultadoCalc = custo / y;
            valorVenda.value = resultadoCalc.toFixed(2);
        }
    }
};


