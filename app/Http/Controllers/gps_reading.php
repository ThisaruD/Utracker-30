<?php

namespace App\Http\Controllers;

use Illuminate\Bus\DatabaseBatchRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use function Sodium\add;

class gps_reading extends Controller
{
    //


    public function getUniqueVehicleGpsData(Request $request){

        $company_id = $request->input('company_id');

        $vehicles = DB::table('vehicles')->where('companies_company_id',$company_id)->pluck('vehicle_id')->toArray();

        $latest=array();
        for($i=0;$i<count($vehicles);$i++){

            $latest=DB::table('gps_readings')

                ->orderByDesc('gps_reading_id')
                ->where('vehicles_vehicle_id',$vehicles[$i])
                ->value('gps_reading_id');
            return $latest;

        }


//        $vehicleGpsData = DB::table('')
//            ->select()
//            ->where()

    }








}
