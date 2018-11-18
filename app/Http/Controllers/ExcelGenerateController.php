<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Scheb\YahooFinanceApi\ApiClient;
use Scheb\YahooFinanceApi\ApiClientFactory;

use App\Mail\SendReport;
use Illuminate\Support\Facades\Mail;

class ExcelGenerateController extends Controller
{
    public function generarHistoricos($tiker){
        $client = ApiClientFactory::createApiClient();
        $historicalData = $client->getHistoricalData($tiker, ApiClient::INTERVAL_1_DAY, new \DateTime("-13760 days"), new \DateTime("tomorrow"));
        $quote = $client->getQuote($tiker);

        $jsonString1 = json_encode($quote);
        $arrayFormatQuote = json_decode($jsonString1, true);
        
        $arrayFormatHistory = [];
        $jsonString = json_encode($historicalData);
        $arrayFormatHistory = json_decode($jsonString, true);

        $array = [];
        $arrayTitles = [];
        $j=0;

        for ($i=count($arrayFormatHistory)-1; $i >= 0 ; $i--) { 
            $array[$j] = [
                'date' => $arrayFormatHistory[$i]['date']['date'],
                'open' => $arrayFormatHistory[$i]['open'],
                'high' => $arrayFormatHistory[$i]['high'],
                'low' => $arrayFormatHistory[$i]['low'],
                'close' => $arrayFormatHistory[$i]['close'],
                'adjClose' => $arrayFormatHistory[$i]['adjClose'],
                'volume' => $arrayFormatHistory[$i]['volume']
            ];
            $j=$j+1;
        }

        $arrayTitles = [ 
            [
                "date" => "Fecha",
                "open" => "Abrir",
                "high" => "al Alza",
                "low" => "a la Baja",
                "close" => "Cerrar",
                "adjClose" => "Cierre Ajustado",
                "volume" => "Volumen"
            ]
        ];

        Excel::create($tiker." - ".$arrayFormatQuote['longName'], function($excel) use ($array, $arrayTitles){
            $excel->sheet('Datos Históricos', function($sheet) use ($array, $arrayTitles){
                $sheet->fromArray($arrayTitles, null, 'A1', false, false);
                $sheet->fromArray($array, null, 'A1', false, false);
            });
        })->store('xls', storage_path('excel/exports'));

        Mail::to('jhonazsh.17@gmail.com')->send(new SendReport($tiker." - ".$arrayFormatQuote['longName'].".xls"));

    }
}
