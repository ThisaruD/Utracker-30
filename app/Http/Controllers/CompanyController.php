<?php

namespace App\Http\Controllers;

use App\Models\company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CompanyController extends Controller
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
     * @param  \App\Models\company  $company
     * @return \Illuminate\Http\Response
     */
    public function show(company $company)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\company  $company
     * @return \Illuminate\Http\Response
     */
    public function edit(company $company)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\company  $company
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, company $company)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\company  $company
     * @return \Illuminate\Http\Response
     */
    public function destroy(company $company)
    {
        //
    }


    public function saveCompany(Request $request){
       $company = new company;
        //error_log($request);
        $company->company_name=$request->company_name;
        $company->company_location=$request->company_location;
        $company->company_address=$request ->company_address;
        $company->save();

//        $company = company::create([
//            'company_name'=>$request->company_name,
//            'company_location'=>$request->company_location,
//            'company_address'=>$request->company_address
//        ]);



//        error_log($company);
////        $company->save();
        return response()->json([
            'reply'=>'company added successfully'
        ],200);


    }

    public function getCompanyDetails(Request $request){

        $company = DB::table('companies')
            ->where('company_name',$request->company_name)
            ->first();

////should code conditional checking using $company

        if($company) {
            return response()->json([
                'company_name' => $company->company_name,
                'company_location' => $company->company_location,
                'company_address' => $company->company_address
            ], 200);
        }else{
            return response() -> json([
                'message' => 'companies not found'
            ],400);
        }

    }


    public function updateCompanyDetails(Request $request){

        err_log($request);
        $vehicles = DB::table('companies')
            ->where('company_id',$request->company_id)
            ->update(
              ['company_name'=>$request->company_name],
                ['company_location'=>$request->company_location],
                ['company_address'=>$request->company_address]

            );

        if($vehicles) {
            return response()->json([
                'message' => 'successfully updated',
            ], 200);
        }else{
            return response()->json([
                'update' => 'Update fail'
            ],400);
        }
    }


    public function getAllCompanies(Request $request){

        $companies = DB::table('companies')->pluck('company_name')->toArray();



        return response() ->json([
            'companies'=>$companies
        ],200);



    }


    public function deleteCompany(Request $request){


        $company_id = DB::table('companies')
            ->where('company_name',$request->company_name)
            ->value('company_id');

        if($company_id){
            $user = DB::table('users')->where('companies_company_id',$company_id)->pluck('id')->toArray();
            $vehicle = DB::table('vehicles')->where('companies_company_id',$company_id)->pluck('vehicle_id')->toArray();
            if(count($user)>0 || count($vehicle)>0) {
                return response()->json([
                    'message' => 'Delete Existing Users or Vehicles first '
                ], 400);

            }
            else{

                DB::table('companies')->where('company_id',$company_id)->delete();
                return response()->json([
                    'message' => 'Deleted Successfully '
                ], 200);

                }


        }else{
            return response()->json([
                'message' => 'Not found '
            ], 404);
        }

    }


    ///for super admin-no send any requested data
    public function getCompanyCount(Request $request){

        $companyCount = DB::table('companies')
            ->get('company_name')
            ->count();

        if($companyCount) {
            return response()->json([
                'numberOfCompanies' => $companyCount
            ],200);

        }else{
            return response()->json([
                'message'=>'Not Found any Vehicle'
            ],404);
        }

    }






}
