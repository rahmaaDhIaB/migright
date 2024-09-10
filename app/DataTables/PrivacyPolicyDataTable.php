<?php

namespace App\DataTables;

use App\Models\PrivacyPolicy;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Str;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;


class PrivacyPolicyDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'privacy-policy.action')

            ->editColumn('description_en', function ($row) {
                return Str::limit(strip_tags($row->description_en), 80);
            })
            ->setRowId('id');
    }


    public function query(PrivacyPolicy $model): QueryBuilder
    {
        return $model->newQuery();
    }


    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->dom('bfrtip')
            ->language(__('datatable'));
    }


    public function getColumns(): array
    {
        return [
            Column::make('id')->title(__('REF'))->addClass('text-center'),
            Column::make('description_en')
                ->title(__('description_en'))
                ->addClass('text-center'),

            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center')
                ->width(150)
                ->addClass('text-center')->orderable(false),

        ];
    }


    protected function filename(): string
    {
        return 'PrivacyPolicy_' . date('YmdHis');
    }
}
