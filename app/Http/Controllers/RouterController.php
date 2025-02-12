<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RouterController extends Controller
{
    public function getRoute(Request $request)
    {
        //Plan route
        $points = $request->input('points');
        $pointsCommand = "";

        for ($i = 0; $i < count($points); $i++) {
            $pointsCommand .= "--lat" . $i + 1 . "=" . $points[$i][0] . " --lon" . $i + 1 . "=" . $points[$i][1] . " ";
        }

        $databasePath = "C:\Users\szebi\OneDrive\Dokumentumok\\routino\data";

        $command = "router --dir=$databasePath --shortest --profile=hike $pointsCommand --output-gpx-track --output-stdout";

        $route = shell_exec($command . ' 2>&1');


        $xml = simplexml_load_string($route);
        $out = '';

        //write lat and long values to a file
        foreach ($xml->trk->trkseg as $trkseg) {
            foreach ($trkseg->trkpt as $trkpt) {
                $lat = (float) $trkpt['lat'];
                $lon = (float) $trkpt['lon'];
                $out .= $lat . ' ' . $lon . PHP_EOL;
            }
        }
        file_put_contents('C:\Users\szebi\OneDrive\Dokumentumok\routino\coords.txt', $out);

        //calculete elevations
        $pyCommand = escapeshellcmd('C:\Users\szebi\anaconda3\python.exe C:\Users\szebi\OneDrive\Dokumentumok\routino\CalculateElevation.py');
        $pyCommandOut = shell_exec($pyCommand);

        //convert script output to array
        $elevations = array_map(fn($num) => number_format((float) $num, 0, '.', ''), explode("\n", trim($pyCommandOut)));
        
        // $eleGain = 0;
        // $eleLoss = 0;
        // for( $i = 0; $i < count($elevations) - 1; $i++){
        //     if($elevations[$i] < $elevations[$i + 1]){
        //         $eleGain += $elevations[$i + 1] - $elevations[$i];
        //     } else {
        //         $eleLoss += $elevations[$i] - $elevations[$i + 1];
        //     }
        // }

        $i = 0;
        foreach ($xml->trk->trkseg as $trkseg) {
            foreach ($trkseg->trkpt as $trkpt) {
                $trkpt->addChild('ele', $elevations[$i]);
                $i++;
            }
        }
        $routeEle = $xml->asXML();
        //$xml->saveXML('C:/Users/szebi/OneDrive/Dokumentumok/routino/routeWithEle.gpx');
        return response()->json([
            'route' => $routeEle,
            // 'eleGain' => $eleGain,
            // 'eleLoss' => $eleLoss
        ]);
    }
}
