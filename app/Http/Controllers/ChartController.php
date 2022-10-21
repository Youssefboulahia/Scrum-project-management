<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chart;

class ChartController extends Controller
{
    public function getData()
    {
        $chart = Chart::all()->first();

        $sommeDays = array();

        if($chart->sommeDays === 14)
        {
            for ($x = 0; $x <= 14; $x++) {
                array_push($sommeDays,$x);
              }
        }
        elseif($chart->sommeDays === 21)
        {
            for ($x = 0; $x <= 21; $x++) {
                array_push($sommeDays,$x);
              }
        }
        elseif($chart->sommeDays === 28)
        {
            for ($x = 0; $x <= 28; $x++) {
                array_push($sommeDays,$x);
              }
        }

        $sommePoints = $chart->sommePoints;
        $data = "[$chart->data]";


        $allData = array(
            'days' => $chart->sommeDays,
			'sommeDays' => $sommeDays,
			'sommePoints' => $sommePoints,
			'data' => $data,
        );
        
        return $allData;


    }



}
