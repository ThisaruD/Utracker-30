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


    public function getUniqueVehicleGpsData(Request $request){

        $company_id = $request->input('company_id');

        $vehicles = DB::table('vehicles')->where('companies_company_id',$company_id)->pluck('vehicle_id')->toArray();

        $latest=array();
        $vehiclenumbers= array();
        for($i=0;$i<count($vehicles);$i++){

            $gps=DB::table('gps_readings')

                ->orderByDesc('gps_reading_id')
                ->where('vehicles_vehicle_id',$vehicles[$i])
                ->value('gps_reading_id');

            $longinlati = DB::table('gps_readings')
                ->select('latitude as lat','longitude as lng')
                ->where('gps_reading_id',$gps)
                ->get();


            array_push( $latest,$longinlati);


            $vehiclenumber= DB::table('vehicles')
                ->where('vehicle_id',$vehicles[$i])
                ->value('vehicle_number');
                array_push($vehiclenumbers,$vehiclenumber);

        }


        $data= array();
        for($i=0;$i<count($latest);$i++){
            array_push($data,$vehiclenumbers[$i],$latest[$i]);

        }
        //return $data;

        return response()->json([
            'GPS_DATA'=>$data
        ]);


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








}
