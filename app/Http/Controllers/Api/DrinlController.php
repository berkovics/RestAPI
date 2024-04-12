<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Drink;
use App\Http\Controllers\Api\ResponseController;
use App\Http\Resources\Drink as DrinkResource;
use App\Http\Requests\DrinkChecker;
use Illuminate\Support\Facades\Gate;

class DrinlController extends Controller
{
    public function getDrinks(){
        $drink=Drink::with("type", "package")->get();

        if (is_null($drink)) {
            return $this->sendError("Hiba a lekérdezésnél");
        }

        return $this->sendResponse(DrinkResource::collection($drink), "Betöltve");
    }

    public function getOneDrink(Request $request){
        $name = $request->get("drink");

        $drink = Drink::with("type", "package")->where("drink", $name)->first();

        if (is_null($drink)) {
            return $this->sendError("Nincs ilyen ital");
        }

        return $this->sendResponse(DrinkResource::make($drink), "Betöltve");
    }

    public function addDrink(DrinkChecker $request){
        if (Gate::allows("is_admin", auth()->user())) {
            $request->validated();
            $input = $request->all();

            $drink = new Drink;
            $drink->drink = $input["drink"];
            $drink->amount = $input["amount"];
            $drink->type_id = (new TypeController)->getTypeId($input["type"]);
            $drink->package_id = (new PackageController)->getPackageId($input["package"]);

            $drink->save();
            return $this->sendResponse(DrinkResource::make($drink), "Kiírva");
        } else {
            return $this->getDrinks();
        }
    }

    public function modifyDrink(DrinkChecker $request){
        $request->validated();
        $input = $request->all();
        $drink = Drink::find($input["id"]);

        $drink->drink = $input["drink"];
        $drink->amount = $input["amount"];
        $drink->type_id = (new TypeController)->getTypeId($input["type"]);
        $drink->package_id = (new PackageController)->getPackageId($input["package"]);

        $drink->save();
        return $this->sendResponse(DrinkResource::make($drink), "Módosítva");
    }

    public function destroyDrink(Request $request) {
        $name = $request->get("drink");
        $id = $drink["id"];

        $drink = Drink::find($id);

        if (is_null($drink)) {
            return $this->sendError("Hiba a lekérdezésnél");
        }

        $drink->delete();
        return $this->sendResponse(DrinkResource::make($drink), "Törölve");
    }
}
