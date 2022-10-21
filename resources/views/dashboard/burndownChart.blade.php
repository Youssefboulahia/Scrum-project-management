@extends('layouts.admin',['projectId'=>$project->id])

@section('projectName')
    {{$project->name}}
@endsection


    
@section('content')

@if ($chart === null)

<div class="container">
    <div class="centered text-center">
        <img src="{{ asset('assets/chart.png') }}" alt="aucun sprint" style="width:22%" class="mb-4">
        <h3 class="text-muted">Un Sprint doit être lancé pour activer le Burndown Chart</h3>
    </div>
</div>

@else


<div class="container" >      
    <div class="card">
        <div class="card-header text-center">
           BurnDown Chart du Sprint:  <span style="font-weight:bold; font-size:13px">{{ $chart->sprint()->name }}</span>
        </div>
    <div class="card-body">
            <canvas id="myAreaChart" width="90%" height="44%" style="m-0 p-0"></canvas>
    </div>
</div>


@endif
@endsection





@section('js')
    
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.min.js" integrity="sha256-R4pqcOYV8lt7snxMQO/HSbVCFRPMdrhAFMH+vr9giYI=" crossorigin="anonymous"></script>
      


<script>
    
    ( function worker( $ ) {

        var charts = {
            init: function () {
                // -- Set new default font family and font color to mimic Bootstrap's default styling
                Chart.defaults.global.defaultFontFamily = '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
                Chart.defaults.global.defaultFontColor = '#292b2c';

                this.ajaxGetPostMonthlyData();
 
            },


            ajaxGetPostMonthlyData: function () {
                var urlPath =  "http://localhost/gestion-projet/public/allData";
                var request = jQuery.ajax( {
                    method: 'GET',
                    url: urlPath
            } );
    
                request.done( function ( response ) {
                    console.log( response );

                    let a1 = response.sommePoints;
                    let a2 = response.days;

                    let a = -a1/a2;

                    let donnees =[];

                    var i;
                    for (i = 0; i < a2+1; i++) {
                        donnees.push(a*i+a1);
                    }


                    charts.createCompletedJobsChart(response,donnees);
                
                });
                request.fail(function(){
                    console.log('fail');
                })
            },

    
            createCompletedJobsChart: function (response,donnees) {
    
                var ctx = document.getElementById("myAreaChart");
                var myLineChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: response.sommeDays, // The response got from the ajax request containing all month names in the database
                        datasets: [{
                            label: "Avancement actuel du Sprint",
                            lineTension: 0.3,
                            backgroundColor: "rgba(2,117,216,0)",
                            borderColor: "rgba(2,117,216,1)",
                            pointRadius: 5,
                            pointBackgroundColor: "rgba(2,117,216,1)",
                            pointBorderColor: "rgba(255,255,255,0.8)",
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgba(2,117,216,1)",
                            pointHitRadius: 20,
                            pointBorderWidth: 2,
                            data: JSON.parse(response.data.replace(/'/g, '"')) , // The response got from the ajax request containing data for the completed jobs in the corresponding months
                        },
                        {
                            label: "Avancement idéal",
                            lineTension: 0.3,
                            backgroundColor: "rgba(2,117,216,0)",
                            borderColor: "rgb(0, 200, 81)",
                            pointRadius: 4,
                            pointBackgroundColor: "rgba(0, 126, 51,0.7)",
                            pointBorderColor: "rgba(255,255,255,0.8)",
                            pointHoverRadius: 5,
                            pointHoverBackgroundColor: "rgb(0, 200, 81)",
                            pointHitRadius: 20,
                            pointBorderWidth: 2,
                            borderWidth:1.2,
                            data: donnees // The response got from the ajax request containing data for the completed jobs in the corresponding months
                             
                        }],
                    },
                    options: {
                        scales: {
                            xAxes: [{
                                time: {
                                    unit: 'jour'
                                },
                                gridLines: {
                                    color: "rgba(0, 0, 0, .125)",
                                },
                                ticks: {
                                    autoSkip: false
                                },
                                scaleLabel: {
                                display: true,
                                labelString: 'Jours',
                                
                            }
                            }],
                            yAxes: [{
                                time: {
                                    unit: 'story point'
                                },
                                ticks: {
                                    min: 0,
                                    max: response.sommePoints, // The response got from the ajax request containing max limit for y axis
                                    autoSkip: false,
                                    stepSize: 20
                                },
                                gridLines: {
                                    color: "rgba(0, 0, 0, .125)",
                                },
                                scaleLabel: {
                                display: true,
                                labelString: 'Story points',
                                
                            }
                            }],
                        },
                        legend: {
                            display: true,
                            position:'bottom'
                        }
                    }
                });
            }
        };
    
        charts.init();
    } )( jQuery );
    

    </script>







@endsection