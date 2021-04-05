<?php

namespace App\Http\Controllers;

use App\Models\vehicle;
use App\Models\Vehicle_driver;
use App\Models\vehicle_gps_device;
use App\Models\Vehicle_owner;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(vehicle $vehicle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function edit(vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, vehicle $vehicle)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(vehicle $vehicle)
    {
        //
    }


    public function saveVehicle(Request $request,$id)
    {


        $registerOwner = new Vehicle_owner();
        //error_log($request);

        if($registerOwner) {


            $registerOwner->owner_name = $request->input('owner_name');
            $registerOwner->owner_contact_no = $request->input('owner_contact_number');
            $registerOwner->save();
            $ownername = request('owner_name');

            $owner_id = DB::table('vehicle_owners')->where('owner_name', $ownername)->value('owner_id');
            //error_log($owner_id);
            $registerVehicle = new Vehicle();

            $registerVehicle->users_id = $id;
            $registerVehicle->vehicle_number = $request->input('vehicle_number');
            $registerVehicle->type = $request->input('type');
            $registerVehicle->unit_per_1km = $request->input('unit_per_1km');
            $registerVehicle->companies_company_id = $request->input('companies_company_id');
            $registerVehicle->vehicle_owners_owner_id = $owner_id;

            $vehiclenumber = request('vehicle_number');

            $registerVehicle->save();

            $vehicle_id = DB::table('vehicles')->where('vehicle_number', $vehiclenumber)->value('vehicle_id');
            $registerDriver = new Vehicle_driver();

            $registerDriver->driver_name = $request->input('driver_name');
            $registerDriver->driver_contact_no = $request->input('driver_contact_number');
            $registerDriver->vehicles_vehicle_id = $vehicle_id;

            $registerDriver->save();

            $registerDevice = new vehicle_gps_device();

            $registerDevice->serial_number = $request->input('serial_number');
            $registerDevice->status = $request->input('status');
            $registerDevice->vehicles_vehicle_id = $vehicle_id;

            $registerDevice->save();


            return response()->json([
                'reply'=>'vehicle added successfully'
            ],200);

        }else{
            return response()->json([
                'reply'=>'Operation Fail'
            ],404);
        }


    }


    public function getAllVehicleNumbers(Request $request,$id){
        $company_id = DB::table('users')->where('id',$id)->value('companies_company_id');

        $vehicles = DB::table('vehicles')->where('companies_company_id',$company_id)->pluck('vehicle_number')->toArray();

            if($vehicles) {
                return response()->json([
                    'vehicles' => $vehicles
                ], 200);
            }else {

                return response()->json([
                    'message' => 'Not Found'
                ], 404);

            }

    }


    public function getVehicleDetails(Request $request)
    {

//get vehicle details from db


        $vehicles = DB::table('vehicles')
            ->where('vehicle_number', $request->vehicle_number)
            ->first();

        $driver = DB::table('vehicle_drivers')
                ->where('vehicles_vehicle_id',$vehicles->vehicle_id)
                ->first();

        $owner = DB::table('vehicle_owners')
            ->where('owner_id',$vehicles->vehicle_owners_owner_id)
            ->first();


        $device = DB::table('vehicle_gps_devices')
            ->where('vehicles_vehicle_id',$vehicles->vehicle_id)
            ->first();

        if ($vehicles) {
            return response()->json([

                'vehicle_num' => $vehicles->vehicle_number,
                'type1' => $vehicles->type,
                'unit_per_1km' => $vehicles->unit_per_1km,
                'driver_name'=>$driver->driver_name,
                'driver_contact_no'=>$driver->driver_contact_no,
                'owner_name'=>$owner->owner_name,
                'owner_contact_no'=>$owner->owner_contact_no,
                'serial_number'=>$device->serial_number,
                'status1'=>$device->status

            ], 200);
        } else {
            return response() ->json([
                    'message' => 'Cannot find vehicle'
                ],404);
        }

    }



    public function updateVehicleDetails(Request $request){


            $vehicle_number = $request->input('vehicle_number');
            $vehicle_id = DB::table('vehicles')->where('vehicle_number',$vehicle_number)->value('vehicle_id');

            if($vehicle_id){
            DB::table('vehicles')
                        ->where('vehicle_id',$vehicle_id)
                        ->update(['type'=>($request->type),'unit_per_1km'=> ($request->unit_per_1km)]

                        );

                $driver_id = DB::table('vehicle_drivers')->where('vehicles_vehicle_id',$vehicle_id)->value('driver_id');

                if($driver_id) {
                DB::table('vehicle_drivers')
                        ->where('driver_id', $driver_id)
                        ->update(['driver_name'=>($request->driver_name), 'driver_contact_no'=>($request->driver_contact_no)]);

                }

                $owner_id= DB::table('vehicles')->where('vehicle_id',$vehicle_id)->value('vehicle_owners_owner_id');

                if($owner_id){
                    DB::table('vehicle_owners')
                        ->where('owner_id',$owner_id)
                        ->update(['owner_name'=>($request->owner_name),'owner_contact_no'=>$request->owner_name]);
                }

                return response()->json([
                    'message' => 'successfully updated',
               ], 200);

            }else{
                return response()->json([
                    'message' => 'Not Found',
                ], 404);
            }


    }


    public function deleteVehicle(Request $request){

//        $company = DB::table('vehicles')
//            ->where('vehicle_name',$request->vehicle_name)
//            ->delete();
        $vehicle_number = $request->input('vehicle_number');
        if($vehicle_number) {
            $vehicle_id = DB::table('vehicles')->where('vehicle_number', $vehicle_number)->value('vehicle_id');

            DB::table('vehicle_drivers')->where('vehicles_vehicle_id', $vehicle_id)->delete();
            DB::table('gps_readings')->where('vehicles_vehicle_id', $vehicle_id)->delete();
            DB::table('vehicle_gps_devices')->where('vehicles_vehicle_id', $vehicle_id)->delete();
            DB::table('vehicles')->where('vehicle_number', $vehicle_number)->delete();

            return response()->json([
                'message' => 'successfully deleted',
            ], 200);
        }else{
            return response()->json([
                'message' => 'Not found',
            ], 404);
        }


    }



    ///for super admin-no send any requested data
    public function getVehicleCount(Request $request){

        $vehicleCount = DB::table('vehicles')
            ->get('vehicle_number')
            ->count();


        return response()->json([
            'vehiclesCount'=>$vehicleCount
        ]);
    }


    //for transport manager and staff
    public function getUniqueCompanyVehicleCount(Request $request){

    $companyVehicleCount = DB::table('vehicles')
                ->get('companies_company_id',$request->company_id)
                ->count();

    if($companyVehicleCount){
        return response()->json([
            'companyVehicleCount'=>$companyVehicleCount
        ],200);
    }else{
        return response()->json([
            'message'=>'Not Found'
        ],404);
    }

    }

}
