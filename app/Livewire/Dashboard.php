<?php

namespace App\Livewire;

use App\Http\Controllers\CaixaController;
use App\Models\Caixa;
use Livewire\Component;
use WireUi\Traits\Actions;

class Dashboard extends Component
{
    use Actions;

    public string $monthsChart = '';
    public string $goal = '';

    public function goalDialog()
    {
        $this->dialog()->id('goalDialog')->confirm([
            'icon' => 'document-report',
            'accept' => [
                'label' => 'Definir',
                'color' => 'positive',
                'method' => 'changeGoal',
            ],
            'reject' => [
                'label' => 'Cancelar',
                'color' => 'negative',
            ],
        ]);
    }

    public function changeGoal()
    {
        $goalFind = Caixa::find(4);
        $goalFind->saldo = $this->goal;
        $goalFind->save();
        $this->notification()->success(
            title: 'Valor da meta atualizado com sucesso!',

        );
    }

    public function render()
    {

        $getConfig = json_decode(file_get_contents('../config/app_settings.json'));
        $this->monthsChart = $getConfig->monthsChart->value;
        $this->goal = CaixaController::meta();

        return view('admin.dashboard');
    }
}
