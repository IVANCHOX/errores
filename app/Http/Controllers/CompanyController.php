<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Scheb\YahooFinanceApi\ApiClient;
use Scheb\YahooFinanceApi\ApiClientFactory;
// Use GuzzleHttp for web scraping
use GuzzleHttp\Client;
use Maatwebsite\Excel\Facades\Excel;

use App\Company;
use App\Resumen;
use App\DatosHistoricos;

class CompanyController extends Controller
{
    public function resumen($symbol){
        $client = ApiClientFactory::createApiClient();

        //-----
        $clientOther = new \GuzzleHttp\Client();
        $resEstadisticos = $clientOther->request('GET', 'https://es-us.finanzas.yahoo.com/quote/'.$symbol.'/key-statistics?p='.$symbol.'&.tsrc=fin-srch-v1');
        $htmlEstadisticos = htmlentities($resEstadisticos->getBody()); 
        $resFinancieros = $clientOther->request('GET', 'https://es-us.finanzas.yahoo.com/quote/'.$symbol.'/financials?p='.$symbol);
        $htmlFinancieros = htmlentities($resFinancieros->getBody());
        //----

        $company = Company::where('tiker','=',$symbol)->first();
        $historicos = DatosHistoricos::where('tiker','=',$symbol)->get();
        $resumen = Resumen::where('tiker','=', $symbol)->first();
        

        if($resumen){
            $bool = true;
            $otherArray = $resumen;

            if(count($historicos)>0){
                $bool2 = true;
                $arrayFormatHistory = $historicos;
            }else{
                $bool2 = false;
                $historicalData = $client->getHistoricalData($symbol, ApiClient::INTERVAL_1_DAY, new \DateTime("-13760 days"), new \DateTime("tomorrow"));
                $jsonString1 = json_encode($historicalData);
                $arrayFormatHistory = json_decode($jsonString1, true);

            }

            return view('resumen-oficial', compact('htmlEstadisticos', 'company', 'otherArray', 'arrayFormatHistory', 'bool', 'bool2'));
        }else{
            $bool = false;
            $quote = $client->getQuote($symbol);

            $jsonString = json_encode($quote);
            $arrayFormatQuote = json_decode($jsonString, true);

            $otherArray = [
                'nombre' => $arrayFormatQuote['longName'],
                'tiker' => $arrayFormatQuote['symbol'],
                'cierreAnterior' => $arrayFormatQuote['regularMarketPreviousClose'],
                'abrir' => $arrayFormatQuote['regularMarketOpen'],
                'oferta' => $arrayFormatQuote['bid']." x ".$arrayFormatQuote['bidSize']*100,
                'demanda' => $arrayFormatQuote['ask']." x ".$arrayFormatQuote['askSize']*100,
                'rangoDiarioLow' => $arrayFormatQuote['regularMarketDayLow'],
                'rangoDiarioHigh' => $arrayFormatQuote['regularMarketDayHigh'],
                'rango52SemanasLow' => $arrayFormatQuote['fiftyTwoWeekLow'],
                'rango52SemanasHigh' => $arrayFormatQuote['fiftyTwoWeekHigh'],
                'volumen' => $arrayFormatQuote['regularMarketVolume'],
                'mediaVolumen' => $arrayFormatQuote['averageDailyVolume3Month'],
                'tmtm' => $arrayFormatQuote['trailingPE'],
                'ttm' => $arrayFormatQuote['epsTrailingTwelveMonths'],
                'fechaBeneficios' => substr($arrayFormatQuote['earningsTimestamp']['date'], 0, 10),
                'prevision' => $arrayFormatQuote['trailingAnnualDividendRate']." (".($arrayFormatQuote['trailingAnnualDividendYield']*100)." %)"

            ];

            if(count($historicos)>0){
                $bool2 = true;
                $arrayFormatHistory = $historicos;
            }else{
                $bool2 = false;
                $historicalData = $client->getHistoricalData($symbol, ApiClient::INTERVAL_1_DAY, new \DateTime("-13760 days"), new \DateTime("tomorrow"));
                $jsonString1 = json_encode($historicalData);
                $arrayFormatHistory = json_decode($jsonString1, true);

                $n=2;
                $resta55 = count($arrayFormatHistory) - 55;
                $resta200 = count($arrayFormatHistory) - 200;
                $suma55 = 0;
                $suma200 = 0;

                
                for ($i=0; $i < count($arrayFormatHistory) ; $i++) { 
                    $arrayFormatHistory[$i]['date']['date'] = substr($arrayFormatHistory[$i]['date']['date'], 0, 10);
                    //promedio pms 55
                    if($resta55==$i){
                        $suma55=0;
                        for ($j=$resta55; $j > $resta55-55; $j--) { 
                            $suma55 = $suma55 + $arrayFormatHistory[$j]['close'];
                        }
                        $promedio55 = $suma55/55; 

                        $arrayFormatHistory[$i]['pms55'] = $promedio55;
                        $resta55=$resta55+1;
                        
                    }else{  
                        $arrayFormatHistory[$i]['pms55'] = 0;
                    }  

                    //promedio pms 200
                    if($resta200==$i){
                        $suma200=0;
                        for ($j=$resta200; $j > $resta200-200; $j--) { 
                            $suma200 = $suma200 + $arrayFormatHistory[$j]['close'];
                        }
                        $promedio200 = $suma200/200; 

                        $arrayFormatHistory[$i]['pms200'] = $promedio200;
                        $resta200=$resta200+1;
                        
                    }else{  
                        $arrayFormatHistory[$i]['pms200'] = 0;
                    } 
                    
                }

                
            }

            return view('resumen-oficial', compact('htmlEstadisticos', 'htmlFinancieros', 'company', 'otherArray', 'arrayFormatHistory', 'bool', 'bool2'));
        }

        
    }

    public function saveResumen($symbol){
        $client = ApiClientFactory::createApiClient();
        $quote = $client->getQuote($symbol);

        $jsonString = json_encode($quote);
        $arrayFormatQuote = json_decode($jsonString, true);

        Resumen::create([
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
        ]);

        return json_encode(1);
    }

    public function saveHistory($symbol){
        $client = ApiClientFactory::createApiClient();
        $historicalData = $client->getHistoricalData($symbol, ApiClient::INTERVAL_1_DAY, new \DateTime("-13760 days"), new \DateTime("tomorrow"));

        $jsonString1 = json_encode($historicalData);
        $arrayFormatHistory = json_decode($jsonString1, true);

        foreach ($arrayFormatHistory as $item) {
            DatosHistoricos::create([
                'tiker'=>$symbol,
                'date'=>$item['date']['date'],
                'open'=>$item['open'],
                'high'=>$item['high'],
                'low'=>$item['low'],
                'close'=>$item['close'],
                'adjClose'=>$item['adjClose'],
                'volume'=>$item['volume']
            ]);
        }

        return json_encode(1);
    }

    /**
    *   Function that make scraping to finviz.com/screener.ashx*** 
    *   for get all symbols of companies
    */
    public function getFirstCompanies(){
        //make a new client GuzzleHttp
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://finviz.com/screener.ashx?v=111');
        $cadHTML = $res->getBody();
        
        return view('all', compact('cadHTML'));
    }

    public function getRestCompanies($cantidad){
        $client = new \GuzzleHttp\Client();
        $res = $client->request('GET', 'https://finviz.com/screener.ashx?v=111&r='.$cantidad);
        $cadHTML = $res->getBody();
        return view('all-rest', compact('cadHTML'));
    }

    //metodos provisionales
    public function saveCompanies(Request $request){
        $arreglo = $request['arreglo'][0];
        $arreglo_limpio = array_shift($arreglo);
        
        foreach ($arreglo as $item) {
            $filtro = Company::where('tiker','=', $item[0])->first();

            if(!$filtro){
                Company::create([
                    'nro'=>$item[4], 
                    'tiker'=>$item[0], 
                    'company'=>$item[1], 
                    'sector'=>$item[5], 
                    'industry'=>$item[3], 
                    'country'=>$item[2]
                ]);
            }else{
                return json_encode('ya esta registrado');
            }
            
        }
    }
}
