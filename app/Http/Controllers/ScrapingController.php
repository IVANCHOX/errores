<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Scheb\YahooFinanceApi\ApiClient;
use Scheb\YahooFinanceApi\ApiClientFactory;
use GuzzleHttp\Client;

use PHPHtmlParser\Dom;

use App\Company;

class ScrapingController extends Controller
{
   
    public function generar($tiker){
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

        $array2 = [
            [
                "title" => $arrayFormatQuote['longName']." ( ".$arrayFormatQuote['symbol'].")"
            ],
            [
                "title" => "Cierre Anterior",
                "value" => $arrayFormatQuote['regularMarketPreviousClose']
            ],
            [
                "title" => "Abrir",
                "value" => $arrayFormatQuote['regularMarketOpen']
            ],
            [
                "title" => "Oferta",
                "value" => $arrayFormatQuote['bid']." x ".$arrayFormatQuote['bidSize']*100,
            ],
            [
                "title" => "Precio de Compra",
                "value" => $arrayFormatQuote['ask']." x ".$arrayFormatQuote['askSize']*100,
            ],
            [
                "title" => "Rango Diario",
                "value" => $arrayFormatQuote['regularMarketDayLow']." - ".$arrayFormatQuote['regularMarketDayHigh']
            ],
            [
                "title" => "Intervalo de 52 Semanas",
                "value" => $arrayFormatQuote['fiftyTwoWeekLow']." - ".$arrayFormatQuote['fiftyTwoWeekHigh']
            ],
            [
                "title" => "Volumen",
                "value" => $arrayFormatQuote['regularMarketVolume']
            ],
            [
                "title" => "Media Volumen",
                "value" => $arrayFormatQuote['averageDailyVolume3Month']
            ],
            [
                "title" => "Ratio precio/beneficio (TMTM)",
                "value" => $arrayFormatQuote['trailingPE']
            ],
            [
                "title" => "BPA (TTM)",
                "value" => $arrayFormatQuote['epsTrailingTwelveMonths']
            ],
            [
                "title" => "Fecha de beneficios",
                "value" => $arrayFormatQuote['earningsTimestamp']['date']
            ],
            [
                "title" => "Previsión de rentabilidad y dividendo",
                "value" => $arrayFormatQuote['trailingAnnualDividendRate']." (".($arrayFormatQuote['trailingAnnualDividendYield']*100)." %)"
            ]

        ];
        

        Excel::create($tiker." - ".$arrayFormatQuote['longName'], function($excel) use ($array, $arrayTitles, $array2){
            $excel->sheet('Resumen', function($sheet) use ($array2){
                $sheet->fromArray($array2, null, 'A1', false, false);
            });
            //una hoja
            $excel->sheet('Datos Históricos', function($sheet) use ($array, $arrayTitles){
                $sheet->fromArray($arrayTitles, null, 'A1', false, false);
                $sheet->fromArray($array, null, 'A1', false, false);
            });
        })->download('xlsx');

    }

    public function index(){
        //$client = ApiClientFactory::createApiClient();
        $companies = Company::all();
        return view('index', compact('companies'));
    }

    public function getAllCompanies($searchWord){
        $client = ApiClientFactory::createApiClient();
        $searchResult = $client->search($searchWord);

        return json_encode($searchResult);
    }

    
    public function getDataCompany($tiker){
        $client = ApiClientFactory::createApiClient();
        $quote = $client->getQuote($tiker);

        $historicalData = $client->getHistoricalData($tiker, ApiClient::INTERVAL_1_DAY, new \DateTime("-13760 days"), new \DateTime("tomorrow"));

        $jsonString = json_encode($quote);
        $arrayFormatQuote = json_decode($jsonString, true);

        $jsonString1 = json_encode($historicalData);
        $arrayFormatHistory = json_decode($jsonString1, true);

        $otherArray = [
            'nombre' => $arrayFormatQuote['longName'],
            'tiker' => $arrayFormatQuote['symbol'],
            'cierreAnterior' => $arrayFormatQuote['regularMarketPreviousClose'],
            'abrir' => $arrayFormatQuote['regularMarketOpen'],
            'oferta' => $arrayFormatQuote['bid']." x ".$arrayFormatQuote['bidSize']*100,
            'demanda' => $arrayFormatQuote['ask']." x ".$arrayFormatQuote['askSize']*100,
            'rangoDiario' => $arrayFormatQuote['regularMarketDayLow']." - ".$arrayFormatQuote['regularMarketDayHigh'],
            'rango52Semanas' => $arrayFormatQuote['fiftyTwoWeekLow']." - ".$arrayFormatQuote['fiftyTwoWeekHigh'],
            'volumen' => $arrayFormatQuote['regularMarketVolume'],
            'mediaVolumen' => $arrayFormatQuote['averageDailyVolume3Month'],
            'tmtm' => $arrayFormatQuote['trailingPE'],
            'ttm' => $arrayFormatQuote['epsTrailingTwelveMonths'],
            'fechaBeneficios' => $arrayFormatQuote['earningsTimestamp']['date'],
            'prevision' => $arrayFormatQuote['trailingAnnualDividendRate']." (".($arrayFormatQuote['trailingAnnualDividendYield']*100)." %)"

        ];

        return view('resumen', compact('otherArray','arrayFormatHistory'));
    }

    public function getDataFinancial($tiker){
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://finance.yahoo.com/quote/'.$tiker.'/financials?p='.$tiker);
        $html = htmlentities($res->getBody()); 
        
        $client1 = ApiClientFactory::createApiClient();
        
        $quote = $client1->getQuote($tiker);
        $jsonString = json_encode($quote);
        $arrayFormatQuote = json_decode($jsonString, true);

        //return $html;
        return view('financieros', compact('html','arrayFormatQuote'));
    }

    public function getDataEstadisticos($tiker){
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://finance.yahoo.com/quote/'.$tiker.'/key-statistics?p='.$tiker);
        $html = htmlentities($res->getBody()); 
        
        $client1 = ApiClientFactory::createApiClient();
        
        $quote = $client1->getQuote($tiker);
        $jsonString = json_encode($quote);
        $arrayFormatQuote = json_decode($jsonString, true);

        //return $html;
        return view('estadisticos', compact('html','arrayFormatQuote'));
    }

    


}
