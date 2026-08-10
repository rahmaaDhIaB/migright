<?php

namespace App\DataTables;

use App\Models\AssistanceDemand;
use App\Models\PartnerDecision;
use App\Models\TestimonyDemand;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class TestimonyDemandDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->editColumn('status', function ($row) {
                $badgeClass = 'badge-secondary';
                if ($row->status === 'accepted') {
                    $badgeClass = 'badge bg-gradient-success';
                } elseif ($row->status === 'refused') {
                    $badgeClass = 'badge bg-gradient-danger';
                } elseif ($row->status === 'closed') {
                    $badgeClass = 'badge bg-gradient-primary';
                } else {
                    $badgeClass = 'badge bg-gradient-secondary';

                }
                return '<span class="badge ' . $badgeClass . '">' . ucfirst($row->status) . '</span>';
            })



            ->editColumn('demand.status', function ($row) {
                $badgeClass = 'badge-secondary'; // Default badge class
                if ($row->demand->status === 'pending') {
                    $badgeClass = 'badge bg-gradient-secondary';
                }
                return '<span class="badge ' . $badgeClass . '">' . ucfirst($row->demand->status) . '</span>';
            })


            ->editColumn('created_at', function ($row) {
                return Carbon::parse($row->created_at)->format('Y-m-d'); // Format the date
            })
            ->addColumn('action', 'testimony.actions')
            ->rawColumns(['status', 'demand.status', 'action'])
            ->setRowId('id');


    }

    /**
     * Get the query source of dataTable.
     */
    public function query(TestimonyDemand $model): QueryBuilder
    {
        $query = PartnerDecision::query()
            ->select('partner_decision.*', 'demands.first_name', 'demands.last_name', 'demands.phone_number','users.name as user_name')
            ->join('demands', 'partner_decision.demand_id', '=', 'demands.id')
            ->join('users', 'partner_decision.user_id', '=', 'users.id')
             ->where('demands.demandable_type', '=', TestimonyDemand::class);
        $status = $this->request()->query('status');

        if (auth('web')->user()->is_admin == false) {
            // Partners may only ever see the decisions assigned to them.
            $query->where('partner_decision.user_id', auth('web')->id());
            if ($status === "refused") {
                return $query->where('partner_decision.status', 'refused');
            } elseif ($status === "accepted") {
                return $query->where('partner_decision.status', 'accepted');
            } else {
                return $query->where('partner_decision.status', 'awaiting');
            }
        } else {
            if ($status === "closed") {
                return $query->where('partner_decision.status', 'closed');
            }
            if ($status === 'pending') {
                $status = $this->request()->query('status');
                $query = $model->newQuery()
                    ->whereRelation('demand', 'status', $status)
                    ->with('demand');
                return $query;
            }
            return $query->where('partner_decision.status', '!=', 'closed');
        }
    }









    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->columns($this->getColumns())
            ->dom('bfrtip')
            ->language(__('datatable'))
           ;
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        $columns = [];
        $status = $this->request()->query('status');

        if ($status === 'pending') {
            $columns = array_merge($columns, [
                Column::make('id')->title(__('ID')),
                Column::make('created_at')->title(__('Date')),
                Column::make('demand.phone_number')->title(__('phone number')),
                Column::make('demand.status')->title(__('Status')),

            ]);
        }
        else {
            $columns = array_merge($columns, [
                Column::make('id')->title(__('ID')),
                Column::make('created_at')->title(__('Date')),
                Column::make('phone_number')->title(__('phone_number')),

                Column::make('status')->title(__('Status')),

            ]);
        }
        $columns[] = Column::computed('action')
            ->exportable(false)
            ->printable(false)
            ->width(60)
            ->addClass('text-center');
        return $columns;



    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'TestimonyDemand_' . date('YmdHis');
    }
}
