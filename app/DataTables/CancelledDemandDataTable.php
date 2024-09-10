<?php

namespace App\DataTables;

use App\Models\Demand;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class CancelledDemandDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'cancelled-demands.actions')
            ->addColumn('cancellation_reason_name', function (Demand $demand) {
                return $demand->cancellationReason ? $demand->cancellationReason->name : null;
            })
            ->addColumn('type', function (Demand $demand) {
                switch ($demand->demandable_type) {
                    case 'App\Models\LostPersonDemand' :
                        return 'Lost Person Demand';
                    case 'App\Models\AssistanceDemand' :
                        return 'Assistance Demand';
                    default :
                        return 'Testimony Demand';
                }
            })
            ->setRowId('id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(Demand $model): QueryBuilder
    {
        return $model->newQuery()->where('status', 'cancelled')->with('cancellationReason');
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->dom('bfrtip')
            ->language(__('datatable'));
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title(__('REF'))->addClass('text-center'),
            Column::make('cancellation_reason_name')
                ->title('Name')
                ->addClass('text-center'),
            Column::make('type')
                ->title(__('Type'))
                ->addClass('text-center'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')
                ->width(150)
                ->addClass('text-center')->orderable(false),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'CancelledDemand_' . date('YmdHis');
    }
}
