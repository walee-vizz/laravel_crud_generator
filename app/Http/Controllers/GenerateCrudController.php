<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class GenerateCrudController extends Controller
{

    public function generateCrudView()
    {

        $db_types = [
            'string',
            'char',
            'text',
            'integer',
            'bigInteger',
            'float',
            'double',
            'decimal',
            'boolean',
            'date',
            'datetime',
            'time',
            'timestamp',
            // Add more column types as needed
        ];
        $html_types = [
            'text',
            'password',
            'email',
            'number',
            'date',
            'checkbox',
            'radio',
            'file',
            'hidden',
            // Add more input types as needed
        ];
        return view('backend.generate-crud.create', compact('db_types', 'html_types'));
    }



    public function generateCrudCommand(Request $request)
    {
        $request->validate([
            'model_name' => 'required',

        ]);

        $fields = '';
        $view = '';
        $required = '';
        $view_path = '';
        if (strpos($request->model_name, ' ') !== false) {
            $parts = explode(' ', $request->model_name);

            $capitalizedParts = array_map(function ($part) {
                return Str::singular(ucfirst($part));
            }, $parts);

            // Join the capitalized parts back together with an underscore
            $modelName = implode('_', $capitalizedParts);
        } else {
            $modelName = $request->model_name;
        }

        if (count($request->fields)) {
            $fieldsArray = [];

            foreach ($request->fields as $field) {

                if ($field['name'] == '') {
                    return redirect()->back()->with('error', 'The Field  name cannot be empty!');
                } elseif ($field['types']['db_type'] == '') {
                    return redirect()->back()->with('error', 'The db_type field cannot be empty!');
                } elseif ($field['types']['html_type'] == '') {
                    return redirect()->back()->with('error', 'The html_type field cannot be empty!');
                } elseif ($request->view_path != '') {
                    $view_path = $request->view_path;
                }

                if (isset($field['types']['view_show'])) {
                    $view = 'true';
                } else {
                    $view = 'false';
                }
                if (isset($field['types']['validation'])) {
                    $required = 'true';
                } else {
                    $required = 'false';
                }

                if (strpos($field['name'], ' ') !== false) {
                    $field_name = str_replace(' ', '_', $field['name']);
                    $field_name = strtolower($field_name);
                } else {
                    $field_name = strtolower($field['name']);
                }
                if($request->create_views){
                    $create_views = true;
                }else{
                    $create_views = false;
                }

                $fieldInfo = $field_name . ':' . $field['types']['db_type'] . ':' . $field['types']['html_type'] . ':' . $view  . ':' . str_replace(':', '(}', $field['types']['validation']);
                $fieldsArray[] = $fieldInfo;
            }

            $fields = implode(',', $fieldsArray);
        } else {
            return redirect()->back()->with('error', 'Atleast one field should be added for the model!');
        }



        // Generate the command string with dynamic data
        $command = 'generate:crud ' . $modelName . ' --fields="' . $fields . '" --viewPath="'.$view_path.'"'. '" --createViws="'.$create_views.'"';

        Artisan::call($command);

        return redirect()->route('admin.crud_generation_success');

    }

    public function crud_generation_success(){

        return view('backend.generate-crud.success');
    }


    public function run_migration()
    {
        Artisan::call('migrate');
        return redirect()->route('admin.dashboard');
    }
}
