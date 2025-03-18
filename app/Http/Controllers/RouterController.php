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

        if ($request->input('mode') == 0)
            $databasePath = "C:\Users\szebi\Documents\\routino\data";
        else
        $databasePath = "C:\Users\szebi\Documents\\routino\data2";

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
        file_put_contents('C:\Users\szebi\Documents\routino\coords.txt', $out);

        // //calculete elevations
        $pyCommand = escapeshellcmd('python.exe C:\Users\szebi\Documents\routino\CalculateElevations.py');
        $pyCommandOut = shell_exec($pyCommand);

        // //convert script output to array
        //$elevations = array_map(fn($num) => number_format((float) $num, 2, '.', ''), explode("\n", trim($pyCommandOut)));
        $elevations = array_map('floatval', explode("\n", trim($pyCommandOut)));

        $i = 0;
        foreach ($xml->trk->trkseg as $trkseg) {
            foreach ($trkseg->trkpt as $trkpt) {
                $trkpt->addChild('ele', $elevations[$i]);
                $i++;
            }
        }
        $routeEle = $xml->asXML();
        //$xml->saveXML('C:\Users\szebi\Documents\routino\routeWithEle.gpx');
        return response()->json([
            'route' => $routeEle,
            //'ele' =>  $elevations,
        ]);
    }
}
