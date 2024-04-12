<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Package;
use App\Http\Controllers\Api\ResponseController;
use App\Http\Resources\Package as PackageResource;
use App\Http\Requests\PackageChecker;

class PackageController extends ResponseController
{
    public function getPackages(){
        $packages = Package::all();

        return $this->sendResponse(PackageResource::collection($packages), "Betöltve");
    }

    public function addPackage(PackageChecker $request){
        $request->validated();
        $input = $request->all();

        $package = new Package;
        $package->package = $input("package");

        $package->save();
        return $this->sendResponse(PackageResource::make($package), "Kiírva");
    }

    public function modifyPackage(PackageChecker $request){
        $request->validated();
        $input = $request->all();
        $package = Package::find($input["id"]);

        $package = new Package;
        $package->package = $input("package");

        $package->save();
        return $this->sendResponse(PackageResource::make($package), "Módosítva");
    }

    public function destroyPackage(Request $request){
        $name = $request->get("package");
        $id = $package["id"];

        $package = Package::find($id);

        if (is_null($package)) {
            return $this->sendError("Hiba a lekérdezésnél");
        }

        $package->delete();
        return $this->sendResponse(PackageResource::make($package), "Törölve");
    }

    public function getPackageId($packageName){
        $package = Package::where("package", $packageName)->first();
        $id = $package->id;

        return $id;
    }
}
