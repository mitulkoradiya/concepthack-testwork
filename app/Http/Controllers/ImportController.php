<?php

namespace App\Http\Controllers;

use App\Imports\QuestionsImport;
use Illuminate\Http\Request;

class ImportController extends Controller
{
    public function index(Request $request) {
        return view('import');
    }

    public function store(Request $request) {
            $import = new QuestionsImport();
            $import->import($request->file('import'), \Maatwebsite\Excel\Excel::XLSX);
            $failures = $import->failures();
//            dd($failures);

//            foreach ($failures as $failure) {
//                $failure->row(); // row that went wrong
//                $failure->attribute(); // either heading key (if using heading row concern) or column index
//                $failure->errors(); // Actual error messages from Laravel validator
//                $failure->values(); // The values of the row that has failed.
//            }
        return redirect()->back()->with('failures', $failures);
    }
}
