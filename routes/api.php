<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// routes/api.php
use App\Http\Controllers\AuthController;

Route::post('/login', [AuthController::class, 'login']);
Route::post('/me', [AuthController::class, 'me'])->middleware('auth:sanctum');
Route::post('/register', [AuthController::class, 'register']);

Route::get('/unAuthenticate',[AuthController::class,'unAuthenticate'])->name('unAuthenticate');
Route::delete('/deleteuserdetails/{id}',[AuthController::class, 'deleteProfile']);
Route::get('/getuserdetails/{id}',[AuthController::class, 'getUserDetails'])->middleware('auth:sanctum');

//update user profile details
Route::put('/updateuserdetails/{id}',[AuthController::class, 'updateUserDetails']);

//Delete user Details
Route::delete('/deleteuserdetails/{id}',[AuthController::class,'deleteUserDetails']);

//forgot password
Route::post('/forgot',[\App\Http\Controllers\ForgotController::class,'Forgot']);

//reset password
Route::post('/reset',[\App\Http\Controllers\ForgotController::class,'reset']);

//get user count for Transport Manager
Route::get('/getusercount/{id}',[AuthController::class,'getUserCount']);

//get users details for Transport Manager
Route::get('/getusersdetails',[AuthController::class,'getUsersDetails']);





//==========================================company routes=====================================================================

//save company details
Route::post('/savecompanydetails', [\App\Http\Controllers\CompanyController::class, 'saveCompany']);

//get company details, for super admin
Route::get('/getcompanydetails',[\App\Http\Controllers\CompanyController::class, 'getCompanyDetails']);

//get all companies, for super admin
Route::get('/getallcompanies',[\App\Http\Controllers\CompanyController::class, 'getAllCompanies']);

//update company details
Route::put('/updatecompanydetails',[\App\Http\Controllers\CompanyController::class,'updateCompanyDetails']);

//Delete  a company
Route::delete('/deletecompanydetails/{id}',[\App\Http\Controllers\CompanyController::class,'deleteCompany']);

//get all company count
Route::get('/getcompanycount',[\App\Http\Controllers\CompanyController::class,'getCompanyCount']);

//get all companies all details, for super admin
Route::get('/getallcompaniesdetails',[\App\Http\Controllers\CompanyController::class, 'getAllCompaniesDetails']);

//get company name for transport manager add-user function
Route::get('/getcompanyname/{id}',[\App\Http\Controllers\CompanyController::class, 'getCompanyName']);







//============================================================vehicle routes====================================================

//save new vehicle
Route::post('/savevehicledetails/{id}',[\App\Http\Controllers\VehicleController::class,'saveVehicle']);

//get unique company all vehicles
Route::get('/allvehiclenumbers/{id}',[\App\Http\Controllers\VehicleController::class,'getAllVehicleNumbers']);

//get vehicle details for unique vehicle number
Route::get('/getvehicledetails',[\App\Http\Controllers\VehicleController::class,'getVehicleDetails']);

//update vehicle details for selected vehicle number
Route::put('/updatevehicledetails',[\App\Http\Controllers\VehicleController::class,'updateVehicleDetails']);

//Delete a vehicle
Route::delete('/deletevehicledetails/{id}',[\App\Http\Controllers\VehicleController::class,'deleteVehicle']);

//get all vehicle count
Route::get('/getvehiclecount',[App\Http\Controllers\VehicleController::class,'getVehicleCount' ]);

////get unique company vehicle count
//Route::get('/getuniquecompanyvehiclecount',[App\Http\Controllers\VehicleController::class,'getUniqueCompanyVehicleCount' ]);

//get all vehicle details, for super admin
Route::get('/getallvehiclesdetails',[App\Http\Controllers\VehicleController::class,'getAllVehiclesDetails' ]);


//one company vehicle count(for transport manager)
Route::get('/onecompanyvehiclecount/{id}',[App\Http\Controllers\VehicleController::class, 'oneCompanyVehicleCount']);

//TM vehicle details
Route::get('/tmvehicledetails/{id}',[App\Http\Controllers\VehicleController::class, 'getVehicleDetailsForTM']);







//===================================================gps readings routes====================================================
//vehicles live location
Route::get('/getuniquedata',[\App\Http\Controllers\gps_reading::class,'getUniqueVehicleGpsData']);


//previous path
Route::get('/getvehiclepath',[\App\Http\Controllers\gps_reading::class,'getVehiclePath']);


//previous location
Route::get('/previouslocation',[\App\Http\Controllers\gps_reading::class,'previousLocation']);
