@extends('layout.app')

@section('title')
    {{ __('Dashboard') }}
@endsection

@section('content')
    <div class="container">
        <h1>Demands Dashboard</h1>

        <div class="row mb-xl-4 mb-4 mb-sm-4">
            <div class="col-xl-3 col-sm-6">
                <div class="card border-primary mb-3 bg-gradient-primary">
                    <div class="card-header text-bold" style="font-size:12px;">{{__('number_of_demands')}}</div>
                    <div class="card-body text-bold">
                        <h2 class="card-text">{{$numberOfDemands}}</h2>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card border-primary mb-3 bg-gradient-secondary">
                    <div class="card-header text-bold" style="font-size:12px;">{{__('number_of_assistance_demands')}}</div>
                    <div class="card-body text-bold">
                        <h2 class="card-text">{{$numberOfAssistanceDemands}}</h2>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card border-primary mb-3 bg-gradient-info">
                    <div class="card-header text-bold" style="font-size:12px;">{{__('number_of_testimony_demands')}}</div>
                    <div class="card-body text-bold">
                        <h2 class="card-text">{{$numberOfTestimonyDemands}}</h2>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-sm-6">
                <div class="card border-primary mb-3 bg-gradient-warning">
                    <div class="card-header text-bold" style="font-size:12px;">{{__('number_of_lost_person_demands')}}</div>
                    <div class="card-body text-bold">
                        <h2 class="card-text">{{$numberOfLostPersonDemands}}</h2>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts -->
        <div class="charts-container">
            <div class="chart-item">
                <canvas id="demandsChart"></canvas>
            </div>
            <div class="chart-item">
                <canvas id="combinedTypesChart"></canvas>
            </div>
        </div>

        <!-- Smaller Pie Charts -->
        <div class="charts-row">
            <div class="chart-item-small">
                <h3 class="chart-title">{{ __('Demandes de Personnes Perdues par Région') }}</h3>
                <canvas id="lostPersonChart"></canvas>
            </div>
            <div class="chart-item-small">
                <h3 class="chart-title">{{ __('Demandes d’Assistance par Région') }}</h3>
                <canvas id="assistanceChart"></canvas>
            </div>
            <div class="chart-item-small">
                <h3 class="chart-title">{{ __('Demandes par Type') }}</h3>
                <canvas id="demandsByTypeChart"></canvas>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.5.1/chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const labels = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

            const demandsCtx = document.getElementById('demandsChart').getContext('2d');
            new Chart(demandsCtx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Total Demands',
                        data: @json($demandsData),
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1,
                        fill: false
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            const combinedCtx = document.getElementById('combinedTypesChart').getContext('2d');
            new Chart(combinedCtx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Assistance Demands',
                            data: @json($assistanceData),
                            borderColor: 'rgba(54, 162, 235, 1)',
                            borderWidth: 1,
                            fill: false
                        },
                        {
                            label: 'Testimony Demands',
                            data: @json($testimonyData),
                            borderColor: 'rgba(255, 206, 86, 1)',
                            borderWidth: 1,
                            fill: false
                        },
                        {
                            label: 'Lost Person Demands',
                            data: @json($lostPersonData),
                            borderColor: 'rgba(255, 99, 132, 1)',
                            borderWidth: 1,
                            fill: false
                        }
                    ]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });

            function generateColorGradients(ctx, count) {
                const gradients = [];
                for (let i = 0; i < count; i++) {
                    const gradient = ctx.createLinearGradient(0, 0, 0, 400);
                    gradient.addColorStop(0, `hsl(${i * (360 / count)}, 70%, 70%)`);
                    gradient.addColorStop(1, `hsl(${i * (360 / count)}, 70%, 50%)`);
                    gradients.push(gradient);
                }
                return gradients;
            }

            const pieChartOptions = {
                type: 'pie',
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                boxWidth: 20,
                                padding: 10,
                            }
                        },
                        tooltip: {
                            callbacks: {
                                label: function (tooltipItem) {
                                    var label = tooltipItem.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    label += tooltipItem.raw;
                                    return label;
                                }
                            }
                        },
                        title: {
                            display: false,
                            text: ''
                        }
                    }
                }
            };

            const ctxLostPerson = document.getElementById('lostPersonChart').getContext('2d');
            const lostPersonGradients = generateColorGradients(ctxLostPerson, @json($lostPersonRegions).length);
            new Chart(ctxLostPerson, {
                ...pieChartOptions,
                data: {
                    labels: @json($lostPersonRegions),
                    datasets: [{
                        label: 'Demandes de Personnes Perdues par Région',
                        data: @json($lostPersonPieChartData),
                        backgroundColor: lostPersonGradients,
                        borderColor: 'rgba(0, 0, 0, 0.1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    ...pieChartOptions.options,
                    aspectRatio: 1
                }
            });

            const ctxAssistance = document.getElementById('assistanceChart').getContext('2d');
            const assistanceGradients = generateColorGradients(ctxAssistance, @json($assistanceRegions).length);
            new Chart(ctxAssistance, {
                ...pieChartOptions,
                data: {
                    labels: @json($assistanceRegions),
                    datasets: [{
                        label: 'Demandes d’Assistance par Région',
                        data: @json($assistancePieChartData),
                        backgroundColor: assistanceGradients,
                        borderColor: 'rgba(0, 0, 0, 0.1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    ...pieChartOptions.options,
                    aspectRatio: 1
                }
            });

            const ctxDemands = document.getElementById('demandsByTypeChart').getContext('2d');
            const demandsGradients = generateColorGradients(ctxDemands, @json($demandLabels).length);
            new Chart(ctxDemands, {
                ...pieChartOptions,
                data: {
                    labels: @json($demandLabels),
                    datasets: [{
                        label: 'Demandes par Type',
                        data: @json($demandData),
                        backgroundColor: demandsGradients,
                        borderColor: 'rgba(0, 0, 0, 0.1)',
                        borderWidth: 1
                    }]
                },
                options: {
                    ...pieChartOptions.options,
                    aspectRatio: 1
                }
            });
        });
    </script>

    <style>
        .charts-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px; /* Espacement entre les graphiques principaux */
            justify-content: center;
        }

        .chart-item {
            flex: 1 1 calc(50% - 20px);
            max-width: calc(50% - 20px);
            min-width: 300px;
            box-sizing: border-box;
            margin-bottom: 20px; /* Espace sous les graphiques principaux */
        }

        .charts-row {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 20px; /* Espacement entre les petits graphiques */
            margin-top: 20px; /* Espace au-dessus des petits graphiques */
        }

        .chart-item-small {
            flex: 1 1 calc(33.333% - 20px); /* Trois graphiques en ligne */
            max-width: calc(33.333% - 20px);
            height: 300px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px; /* Espace sous les petits graphiques */
        }

        .chart-title {
            margin-bottom: 10px; /* Espace entre le titre et le graphique */
            font-size: 16px;
            font-weight: bold;
        }

        .chart-item-small canvas {
            width: 100% !important;
            height: 100% !important;
        }
    </style>
@endsection
