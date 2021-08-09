<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Locations;
use App\Imports\LocationImport;
use Excel;

class ImportController extends Controller
{
    public function importData(Request $request){
       $request->validate([
           'import_data'=> ['required', 'mimes:xls,xlsx,csv']
       ]);

        $file = $request->file('import_data');

        $upload = Excel::import(new LocationImport, $file);

        if (!$upload) {
            return ['res'=> 'success', 'message'=> 'Unable to upload file'];
        }

        return ['res'=> 'success', 'message'=> 'upload successful'];
    }

    public function getLocations(Request $request){
        $data = Locations::select('state')->selectRaw('GROUP_CONCAT(DISTINCT lga) as lgas')->groupBy('state')->get();

        $new_states = [];
        $new_data = [];

        foreach ($data as  $values) {
            array_push($new_states, $values["state"]);
        }

        for ($i=0; $i < count($new_states); $i++) { 
            foreach ($data as  $value) {
                if ($new_states[$i] == $value["state"]) {
                    $new_data[$new_states[$i]] = explode(",", $value["lgas"]);
                }
            }
        }

        return ["status"=> "success", "data"=>$new_data];
    }
}
