
import { Chart, initTE } from "tw-elements";
initTE({ Chart });

const chartElement = document.getElementById('pie-chart');
const labels = window.keysArray;


document.addEventListener('livewire:init', function () {
    Livewire.on('statisticsUpdated', function () {
        let values = window.valuesArray;

        console.log(values);

    });
    
});


const dataPie = {
    type: 'pie',
    data: {
        labels: labels,
        datasets: [
            {
                label: 'Traffic',
                data: [1],
                backgroundColor: [
                    'rgba(63, 81, 181, 0.5)',
                    'rgba(77, 182, 172, 0.5)',
                    'rgba(66, 133, 244, 0.5)',
                    'rgba(156, 39, 176, 0.5)',
                    'rgba(233, 30, 99, 0.5)',
                    'rgba(66, 73, 244, 0.4)',
                    'rgba(66, 133, 244, 0.2)',
                ],
            },
        ],
    },
};

