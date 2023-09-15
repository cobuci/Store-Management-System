const changeUnitValue = () => {
    const cost = document.getElementById("cost");
    const cost_total = parseFloat(
        document.getElementById("cost_total").value
    );
    const amount = document.getElementById("amount").value;

    const result = cost_total / amount;

    cost.value = result.toFixed(2);
};

function changeTotalValue() {
    const cost = parseFloat(document.getElementById("cost").value);
    const cost_total = document.getElementById("cost_total");
    const amount = document.getElementById("amount").value;

    let result = cost * amount;

    cost_total.value = result.toFixed(2);
}

function valorRadio() {
    radioCalculo();
    insere();
}

const insere = () => {
    const cost = parseFloat(document.getElementById("cost").value);
    const sale_value = parseFloat(document.getElementById("sale").value);
    const profit = document.getElementById("profit");

    const profit_value = sale_value - cost;
    const result = (profit_value / sale_value) * 100;

    profit.textContent = result >= 0 ? `+ ${result.toFixed(2)}%` : "";
};


const radioCalculo = () => {
    const sale_price = document.getElementById("sale");
    const radioBtn25 = document.getElementById("radio1");
    const radioBtn50 = document.getElementById("radio2");
    const radioBtn75 = document.getElementById("radio3");
    const radioBtn100 = document.getElementById("radio4");
    const cost = parseFloat(document.getElementById("cost").value);

    if (cost !== 0) {
        let percent, z, x, y, result;

        switch (true) {
            case radioBtn25.checked:
                percent = 25;
                break;
            case radioBtn50.checked:
                percent = 50;
                break;
            case radioBtn75.checked:
                percent = 75;
                break;
            case radioBtn100.checked:
                percent = 90;
                break;
            default:

                break;
        }

        if (percent !== undefined) {
            z = 100;
            x = parseFloat(percent / z);
            y = 1 - x;

            result = cost / y;
            sale_price.value = result.toFixed(2);
        }
    }
};


