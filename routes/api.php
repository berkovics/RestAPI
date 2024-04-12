<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DrinlController;
use App\Http\Controllers\Api\PackageController;
use App\Http\Controllers\Api\TypeController;
use App\Http\Controllers\Api\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::group(["middleware" => "auth:sanctum"], function(){
    Route::post("/newdrinks", [DrinlController::class, "addDrink"]);
    Route::put("/modifydrinks", [DrinlController::class, "modifyDrink"]);
    Route::delete("/destroy", [DrinlController::class, "destroyDrink"]);

    Route::post("/newpackage", [PackageController::class, "addPackage"]);
    Route::put("/modifypackage", [PackageController::class, "modifyPackage"]);
    Route::delete("/destroypackage", [PackageController::class, "destroyPackage"]);

    Route::post("/newtype", [TypeController::class, "addType"]);
    Route::put("/modifytype", [TypeController::class, "modifyType"]);
    Route::delete("/destroytype", [TypeController::class, "destroyType"]);

    Route::post("/logout", [AuthController::class, "logout"]);
});

Route::get("/drinks", [DrinlController::class, "getDrinks"]);
Route::get("/onedrinks", [DrinlController::class, "getOneDrink"]);
Route::get("/packages", [PackageController::class, "getPackages"]);
Route::get("/types", [TypeController::class, "getTypes"]);

Route::post("/register", [AuthController::class, "register"]);//->middleware("throttle:100,43200");
Route::post("/login", [AuthController::class, "login"]);//->middleware("throttle:100,43200");
