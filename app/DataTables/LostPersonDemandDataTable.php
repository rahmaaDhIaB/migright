<?php

namespace App\DataTables;

use App\Models\AssistanceDemand;
use App\Models\LostPersonDemand;
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

class LostPersonDemandDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
//        return (new EloquentDataTable($query))
//            ->addColumn('action', 'lostPerson.actions')
//            ->setRowId('id');



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
            ->addColumn('action', 'lostPerson.actions')
            ->rawColumns(['status', 'demand.status', 'action'])
            ->setRowId('id');




    }

    /**
     * Get the query source of dataTable.
     */




//    public function query(LostPersonDemand $model): QueryBuilder
//    {
//        if (auth('web')->user()->is_admin == false) {
//            $query = $model->newQuery()->whereRelation('demand','user_id','=',auth('web')->user()->id)->with('demand');
//
//            $status = $this->request()->query('status');
//
//            if ($status === "pending") {
//                return $query->whereHas('demand', function ($query) {
//                    $query->where('status', 'pending')->where('user_id','=',auth('web')->user()->id);
//                });
//            }
//            elseif($status === "refused") {
//                return $query->whereHas('demand', function ($query) {
//                    $query->where('status', 'refused')->where('user_id','=',auth('web')->user()->id);
//                });
//            }
//
////        return $query->where('status','accepted');
//            return $query->whereHas('demand', function ($query) {
//                $query->where('status', 'accepted')->where('user_id','=',auth('web')->user()->id);
//            });
//        }
//        $query = $model->newQuery()->with('demand');
//        $status = $this->request()->query('status');
//        if ($status === "pending") {
//            return $query->whereHas('demand', function ($query) {
//                $query->where('status', 'pending');
//            });
//        }
//        elseif($status === "refused") {
//            return $query->whereHas('demand', function ($query) {
//                $query->where('status', 'refused');
//            });
//        }
//
//        return $query->whereHas('demand', function ($query) {
//            $query->where('status', 'done');
//        });
//    }



    public function query(LostPersonDemand $model): QueryBuilder
    {
        $query = PartnerDecision::query()
            ->select('partner_decision.*', 'demands.first_name', 'demands.last_name', 'demands.first_name','users.name as user_name')
            ->join('demands', 'partner_decision.demand_id', '=', 'demands.id')
            ->join('users', 'partner_decision.user_id', '=', 'users.id')
            ->where('demands.demandable_type', '=', LostPersonDemand::class);
        $status = $this->request()->query('status');

        if (auth('web')->user()->is_admin == false) {
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
//        return [
//            Column::make('id')->title(__('ID')),
//            Column::make('region')->title(__('Region')),
//            Column::make('missing_person_gender')->title(__('Gender')),
//            Column::make('missing_person_age')->title(__('Age')),
////            Column::make('notification_sender')->title(__('Notification Sender')),
//            Column::make('nationality')->title(__('Nationality')),
//            Column::make('demand.status')->title(__('Status')),
//
//            Column::computed('action')
//                ->exportable(false)
//                ->printable(false)
//                ->width(60)
//                ->addClass('text-center'),
//        ];



        $columns = [];
        $status = $this->request()->query('status');

        if ($status === 'pending') {
            $columns = array_merge($columns, [
                Column::make('id')->title(__('ID'))->addClass('text-center'),
                Column::make('created_at')->title(__('Date'))->addClass('text-center'),
                Column::make('demand.first_name')->title(__('first_name'))->addClass('text-center'),
                Column::make('demand.status')->title(__('Status'))->addClass('text-center'),

            ]);
        }
        else {
            $columns = array_merge($columns, [
                Column::make('id')->title(__('ID'))->addClass('text-center'),
                Column::make('created_at')->title(__('Date'))->addClass('text-center'),
                Column::make('first_name')->title(__('first_name'))->addClass('text-center'),

                Column::make('status')->title(__('Status'))->addClass('text-center'),

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
        return 'LostPersonDemand_' . date('YmdHis');
    }
}
