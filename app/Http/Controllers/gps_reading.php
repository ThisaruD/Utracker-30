<?php

namespace App\Http\Controllers;

use Illuminate\Bus\DatabaseBatchRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use function Sodium\add;

class gps_reading extends Controller
{
    //


    public function getUniqueVehicleGpsData(Request $request)
    {

        $company_id = $request->input('company_id');

        $vehicles = DB::table('vehicles')->where('companies_company_id', $company_id)->pluck('vehicle_id')->toArray();

        $latest = array();
        $vehiclenumbers = array();
        for ($i = 0; $i < count($vehicles); $i++) {

            $gps = DB::table('gps_readings')
                ->orderByDesc('gps_reading_id')
                ->where('vehicles_vehicle_id', $vehicles[$i])
                ->value('gps_reading_id');

            $longinlati = DB::table('gps_readings')
                ->select('latitude as lat', 'longitude as lng')
                ->where('gps_reading_id', $gps)
                ->get();


            array_push($latest, $longinlati);


            $vehiclenumber = DB::table('vehicles')
                ->where('vehicle_id', $vehicles[$i])
                ->value('vehicle_number');
            array_push($vehiclenumbers, $vehiclenumber);

        }


        $data = array();
        for ($i = 0; $i < count($latest); $i++) {
            array_push($data, $vehiclenumbers[$i], $latest[$i]);

        }
        //return $data;

        return response()->json([
            'GPS_DATA' => $data
        ],200);


//        $i=0;
//        foreach ($data as $key=>$value){
//
//            $data[$vehiclenumbers[$i]]= $value->$latest[$i];
//            $i++;
//        }
//        return $data;


//        $vehicleGpsData = DB::table('')
//            ->select()
//            ->where()

    }
public function getVehiclePath(Request $request){
        $vehcile_id = DB::table('vehicles')
            ->where('vehicle_number',$request->input('vehicle_number'))
            ->value('vehicle_id');
        if($vehcile_id) {

            $data = DB::table('gps_readings')
                //->select('latitude','longitude')
                ->where('vehicles_vehicle_id', $vehcile_id)
                ->whereBetween('date', [$request->input('from_date'), $request->input('to_date')])
                ->whereBetween('time', [$request->input('from_time'), $request->input('to_time')])
                ->get();
            return response()->json([
                'GPS_PATH_DATA' => $data
            ],200);

        }else{
            return response()->json([
                'message' => 'Vehicle not found'
            ],404);
        }
}








}
