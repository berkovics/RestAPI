<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Type;
use App\Http\Controllers\Api\ResponseController;
use App\Http\Resources\Type as TypeResource;
use App\Http\Requests\TypeChecker;

class TypeController extends ResponseController
{
    public function getTypes(){
        $types = Type::all();

        return $this->sendResponse(TypeResource::collection($types), "Betöltve");
    }

    public function addType(TypeChecker $request){
        $request->validated();
        $input = $request->all();

        $type = new Type;
        $type->type = $input("type");

        $type->save();
        return $this->sendResponse(TypeResource::make($type), "Kiírva");
    }

    public function modifyType(TypeChecker $request){
        $request->validated();
        $input = $request->all();
        $type = Type::find($input["id"]);

        $type = new Type;
        $type->type = $input("type");

        $type->save();
        return $this->sendResponse(TypeResource::make($type), "Módosítva");
    }

    public function destroyType(Request $request){
        $name = $request->get("package");
        $id = $type["id"];

        $type = Type::find($id);

        if (is_null($type)) {
            return $this->sendError("Hiba a lekérdezésnél");
        }

        $type->delete();
        return $this->sendResponse(TypeResource::make($type), "Törölve");
    }

    public function getTypeId($typeName){
        $type = Type::where("type", $typeName)->first();
        $id = $type->id;

        return $id;
    }
}
