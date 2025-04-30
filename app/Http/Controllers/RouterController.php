<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

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
            $databasePath = Storage::path('routino\data');
        else
        $databasePath = Storage::path('routino\data2');

        $command = "router --dir=$databasePath --shortest --profile=hike $pointsCommand --output-gpx-track --output-stdout";

        $route = shell_exec($command . ' 2>&1');

        //check if the route is valid
        if(str_contains($route, 'Error:'))
        {
            return response()->json([
                'error' => 'Sikertelen tervezés',
            ]);
        }


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

        $filename = Auth::user()->email . "/blueroutes/coords.txt";
        Storage::disk('local')->put($filename, $out);

        // //calculete elevations
        $pythonScript = Storage::path('routino\CalculateElevations.py');
        $srtmPath = Storage::path('routino\hungary_raster.tif');
        $srtmPath = str_replace('\'', '\\', $srtmPath);
        $coordsPath = Storage::path($filename);
        $coordsPath = str_replace('\'', '\\', $coordsPath);

        $pyCommand = "python.exe  $pythonScript $coordsPath $srtmPath";
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
        return response()->json([
            'route' => $routeEle,
            'error' => ''
        ]);
    }
}