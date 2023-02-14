<?php
namespace App\Repositories;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Yajra\DataTables\DataTables;
use Yajra\DataTables\Html\Column;

class Patients
{
    private Patient $model;
    public static function init(Patient $model): Patients
    {
        $instance = new self;
        $instance->model = $model;
        return $instance;
    }

    public static function store(object $data): Patient
    {
        $model = new Patient((array) $data);
                // Save Relationships
            

        if (isset($data->family_history)) {
            $model->familyHistory()
                ->associate($data->family_history->id);
        }
        if (isset($data->chronic_disease)) {
            $model->chronicDisease()
                ->associate($data->chronic_disease->id);
        }
        if (isset($data->allergy)) {
            $model->allergy()
                ->associate($data->allergy->id);
        }
                    

        $model->saveOrFail();
        return $model;
    }

    public function show(Request $request): Patient {
        //Fetch relationships
                $this->model->load([
            'familyHistory',
            'chronicDisease',
            'allergy',
        ]);
    return $this->model;
    }
    public function update(object $data): Patient
    {
        $this->model->update((array) $data);
        
        // Save Relationships
                

        if (isset($data->family_history)) {
            $this->model->familyHistory()
                ->associate($data->family_history->id);
        }


        if (isset($data->chronic_disease)) {
            $this->model->chronicDisease()
                ->associate($data->chronic_disease->id);
        }


        if (isset($data->allergy)) {
            $this->model->allergy()
                ->associate($data->allergy->id);
        }
                

        $this->model->saveOrFail();
        return $this->model;
    }

    public function destroy(): bool
    {
        return !!$this->model->delete();
    }
    public static function dtColumns() {
        $columns = [
            Column::make('id')->title('ID')->className('all text-right'),
            Column::make("full_name")->className('min-desktop-lg'),
            Column::make("birth_date")->className('min-desktop-lg'),
            Column::make("thumbnail")->className('min-desktop-lg'),
            Column::make("phone_number")->className('min-desktop-lg'),
            Column::make("otp_verification_code")->className('min-desktop-lg'),
            Column::make("gender")->className('min-desktop-lg'),
            Column::make("address")->className('min-desktop-lg'),
            Column::make("height")->className('min-desktop-lg'),
            Column::make("weight")->className('min-desktop-lg'),
            Column::make("otp_expire_at")->className('min-desktop-lg'),
            Column::make("notification_status")->className('min-desktop-lg'),
            Column::make("has_physical_activity")->className('min-desktop-lg'),
            Column::make("has_cancer_screening")->className('min-desktop-lg'),
            Column::make("has_depression_screening")->className('min-desktop-lg'),
            Column::make("account_status")->className('min-desktop-lg'),
            Column::make("age")->className('min-desktop-lg'),
            Column::make("created_at")->className('min-tv'),
            Column::make("updated_at")->className('min-tv'),
            Column::make('actions')->className('min-desktop text-right')->orderable(false)->searchable(false),
        ];
        return $columns;
    }
    public static function dt($query) {
        return DataTables::of($query)
            ->editColumn('actions', function (Patient $model) {
                $actions = '';
                if (\Auth::user()->can('view',$model)) $actions .= '<button class="bg-primary hover:bg-primary-600 p-2 px-3 focus:ring-0 focus:outline-none text-white action-button" title="View Details" data-action="show-model" data-tag="button" data-id="'.$model->id.'"><i class="fas fa-eye"></i></button>';
                if (\Auth::user()->can('update',$model)) $actions .= '<button class="bg-secondary hover:bg-secondary-600 p-2 px-3 focus:ring-0 focus:outline-none action-button" title="Edit Record" data-action="edit-model" data-tag="button" data-id="'.$model->id.'"><i class="fas fa-edit"></i></button>';
                if (\Auth::user()->can('delete',$model)) $actions .= '<button class="bg-danger hover:bg-danger-600 p-2 px-3 text-white focus:ring-0 focus:outline-none action-button" title="Delete Record" data-action="delete-model" data-tag="button" data-id="'.$model->id.'"><i class="fas fa-trash"></i></button>';
                return "<div class='gap-x-1 flex w-full justify-end'>".$actions."</div>";
            })
            ->rawColumns(['actions'])
            ->make();
    }
}
