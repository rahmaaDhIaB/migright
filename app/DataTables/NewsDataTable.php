<?php

namespace App\DataTables;

use App\Models\News;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Illuminate\Support\Str;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class NewsDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', function ($row) {
                return view('news.actions', ['id' => $row->id, 'is_archive' => $row->is_archive])->render();
            })
            ->editColumn('description', function ($row) {
                return Str::limit($row->description, 20);
            })
            ->escapeColumns(['*'])
            ->setRowId('id');
    }


    /**
     * Get the query source of dataTable.
     */


    public function query(News $model): QueryBuilder
    {
        $query = $model->newQuery();

        if ($this->request()->query('is_archive')) {
            $query->where('is_archive', true);
        } else {
            $query->where('is_archive', false);
        }
        return $query;
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
            Column::make('title_fr')
                ->title('Title')
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
        return 'News_' . date('YmdHis');
    }
}
