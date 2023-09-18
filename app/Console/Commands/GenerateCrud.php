<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Spatie\Permission\Models\Permission;

class GenerateCrud extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'generate:crud {modelName : The name of the model}
                        {--fields= : Fields with their db and html types (e.g., name:string, email:email, age:integer)}
                        {--viewPath= : View files path  (e.g., views/backend/)}
                        {--createViews= : Yes/No}';


    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate a CRUD for a given model with specified fields.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $modelName = ucfirst($this->argument('modelName'));
        $fields = $this->option('fields');
        $view_path = $this->option('viewPath');
        $create_views = $this->option('createViews');
        $modelName = Str::singular($modelName);
        // Validate and parse the fields input
        $parsedFields = $this->parseFields($fields);

        // Generate the model file
        $this->generateModel($modelName, $parsedFields);

        // Generate the migration file
        $this->generateMigration($modelName, $parsedFields, $fields);
        // $this->runMigration();
        // Generate the controller file
        $this->generateController($modelName, $fields, $view_path);
        if ($create_views) {
            $this->generateViews($modelName, $fields, $parsedFields, $view_path);
        }
        $this->makePermissions($modelName);
        $this->appendRoutes($modelName);
        // Generate the link using the generateLink() method
        // $link = $this->generateLink($modelName);
        // Create the link HTML for the sidebar
        $linkHtml = '<li class="nav-item"><a class="nav-link" href="' . route('home') . '/' . strtolower(str_replace('_', '-', $modelName)) . '"><i class="fas fa-fw fa-chart-area"></i><span>' . Str::plural(str_replace('_', ' ', $modelName)) . '</span></a></li>';


        // Call the method to add the link to the sidebar at a specific location
        $this->appendToSidebar($linkHtml);
    }



    private function parseFields($fields)
    {
        $parsedFields = [];
        $fields = explode(',', $fields);

        foreach ($fields as $field) {
            [$name, $type] = explode(':', $field);
            $parsedFields[$name] = $type;
        }

        return $parsedFields;
    }

    private function generateModel($modelName, $fields)
    {
        $modelTemplate = '<?php

                            namespace App\Models;

                            use Illuminate\Database\Eloquent\Model;

                            class ModelName extends Model
                            {

                                protected $table = \'TableName\';

                                protected $fillable = [
                                    {fields}
                                ];

                                // Define relationships and other methods related to the model
                            }
                            ';

        // Replace placeholders in the template with actual values
        $modelTemplate = str_replace('ModelName', str_replace('_', '', $modelName), $modelTemplate);
        $modelTemplate = str_replace('TableName', Str::plural(strtolower($modelName)), $modelTemplate);
        $fieldsTemplate = '';
        foreach ($fields as $fieldName => $fieldType) {
            $fieldsTemplate .= "'$fieldName',";
        }

        $modelTemplate = str_replace('{fields}', $fieldsTemplate, $modelTemplate);
        file_put_contents(app_path("Models/" . str_replace('_', '', $modelName) . ".php"), $modelTemplate);
    }

    private function generateMigration($modelName, $parsedFields, $fields)
    {
        // Migration Template
        $migrationTemplate = "<?php
                    use Illuminate\Database\Migrations\Migration;
                    use Illuminate\Database\Schema\Blueprint;
                    use Illuminate\Support\Facades\Schema;

                    return new class extends Migration
                    {
                        /**
                         * Run the migrations.
                         *
                         *
                         */
                        public function up(): void
                        {
                            Schema::create('{tableNames}', function (Blueprint \$table) {
                                \$table->id();
                                // Define the fields for the table
                                {fields}
                                \$table->timestamps();
                            });
                        }

                        /**
                         * Reverse the migrations.
                         *
                         *
                         */
                        public function down(): void
                        {
                            Schema::dropIfExists('{tableNames}');
                        }
                    };
        ";
        $required_fields = [];
        $items = explode(',', $fields);
        foreach ($items as $item) {
            list($name, $type, $text, $view, $validation) = explode(':', $item);
            $newfields[$name] = [$type, $text, $view, $validation];
            if ($newfields[$name][3]) {
                $required_fields[] = $name;
            }
        }
        // Replace placeholders in the template with actual values and fields
        $migrationTemplate = str_replace('{ModelName}', $modelName, $migrationTemplate);

        $tableName = Str::plural(strtolower($modelName));
        $migrationTemplate = str_replace('{tableNames}', $tableName, $migrationTemplate);

        $fieldsTemplate = '';
        $nullable = '';
        foreach ($parsedFields as $fieldName => $fieldType) {
            if (!in_array($fieldName, $required_fields)) {
                $fieldsTemplate .= "\n\t\t\t\$table->$fieldType('$fieldName')->nullable();";
            } else {
                $fieldsTemplate .= "\n\t\t\t\$table->$fieldType('$fieldName');";
            }
        }

        $migrationTemplate = str_replace('{fields}', $fieldsTemplate, $migrationTemplate);

        $timestamp = date('Y_m_d_His');
        $filename = "{$timestamp}_create_" . $tableName . "_table.php";
        file_put_contents(database_path("migrations/{$filename}"), $migrationTemplate);
    }





    private function generateController($modelName, $fields, $view_path)
    {
        $newfields = [];
        $required_fields = [];
        $viewable_fields = [];
        $items = explode(',', $fields);
        $modelname = strtolower($modelName);
        $viewsPath = '';
        if ($view_path) {
            $viewsPath = str_replace(' ', '_', strtolower($view_path) . '.' . strtolower($modelName));
        } else {
            $viewsPath = strtolower($modelName);
        }
        foreach ($items as $item) {
            list($name, $type, $text, $view, $validation) = explode(':', $item);
            $newfields[$name] = [$type, $text, $view, $validation];
            if ($newfields[$name][3]) {
                $required_fields[$name] = $newfields[$name][3];
            }
            if ($newfields[$name][2] == 'true') {
                $viewable_fields[] = $name;
            }
        }

        $fields_required = '';
        if (count($required_fields)) {
            foreach ($required_fields as $key => $value) {
                $fields_required .= "'$key' => '" . str_replace('(}', ':', $value) . "',";
            }
        }

        $controllerTemplate = "<?php

            namespace App\Http\Controllers;

            use App\Models\\" . str_replace('_', '', $modelName) . ";
            use Illuminate\Http\Request;

            class " . str_replace('_', '', $modelName) . "Controller extends Controller
            {
                public function index()
                {
                    \$data = " . str_replace('_', '', $modelName) . "::all();
                    \$fields = " . var_export($viewable_fields, true) . ";
                    return view('{$viewsPath}.index', compact('data','fields'));
                }

                public function create()
                {
                    return view('{$viewsPath}.create');
                }

                public function store(Request \$request)
                {
                    // Validate the input
                    \$validatedData = \$request->validate([
                        // Define validation rules based on your model\'s fields
                        // Example: \'field_name\' => \'required|string|max:255\',
                        {$fields_required}
                    ]);

                    \$created = " . str_replace('_', '', $modelName) . "::create(\$validatedData);
                    return redirect()->route('{$modelname}.index')->with('success', '" . ucfirst(str_replace('_', '', $modelName)) . " item created successfully');
                }

                public function show(" . str_replace('_', '', $modelName) . "  \${$modelname})
                {
                    return view('{$viewsPath}.show', compact('{$modelname}'));
                }

                public function edit(" . str_replace('_', '', $modelName) . " \${$modelname})
                {
                    return view('{$viewsPath}.edit', compact('{$modelname}'));
                }

                public function update(Request \$request, " . str_replace('_', '', $modelName) . " \${$modelname})
                {
                    // Validate the input
                    \$validatedData = \$request->validate([
                        // Define validation rules based on your model\'s fields
                        // Example: \'field_name\' => \'required|string|max:255\',
                        {$fields_required}
                    ]);

                    \$updated = " . str_replace('_', '', $modelName) . "::find(\${$modelname}->id)->update(\$validatedData);
                    return redirect()->route('{$modelname}.index')->with('success', '" . ucfirst(str_replace('_', '', $modelName)) . " item updated successfully');
                }

                public function destroy(" . str_replace('_', '', $modelName) . " \${$modelname})
                {

                    \$deleted = " . str_replace('_', '', $modelName) . "::find(\${$modelname}->id)->delete();
                    return redirect()->route('{$modelname}.index')->with('success', '" . ucfirst(str_replace('_', '', $modelName)) . " item deleted successfully');
                }
            }
        ";

        file_put_contents(app_path("Http/Controllers/" . str_replace('_', '', $modelName) . "Controller.php"), $controllerTemplate);
    }


    private function runMigration()
    {
        $this->call('migrate');
    }


    private function generateViews($modelName, $fields, $parsedFields, $view_path)
    {
        // Create the views directory if it doesn't exist
        if ($view_path) {
            $viewsPath = resource_path("views/" . str_replace(' ', '_',  strtolower($view_path)) . '/' . strtolower($modelName));
        } else {
            $viewsPath = resource_path("views/" . strtolower($modelName));
        }
        if (!is_dir($viewsPath)) {
            mkdir($viewsPath, 0755, true);
        }
        $newfields = [];
        $view_fields = [];
        $create_input_fields = '';
        $edit_input_fields = '';
        $items = explode(',', $fields);
        $modelname = strtolower($modelName);
        foreach ($items as $item) {
            list($name, $type, $text, $true, $false) = explode(':', $item);
            $newfields[$name] = [$type, $text, $true, $false];
            if ($newfields[$name][2] == 'true') {
                $view_fields[$name] = [$type, $text, $true, $false];
            }
        }

        // $view_fields = array_keys($view_fields);

        // View files

        // \$fieldsNamesWithValues = " . var_export($newfields, true) . ";
        $fieldsTd = '';
        foreach ($view_fields as $fieldName => $fieldType) {
            $fieldsTd .= "\n\t\t\t<th>" . ucfirst(str_replace('_', ' ', $fieldName)) . "</th>";
        }
        $indexView = "@extends('layouts.backend.main')
            @section('title', 'View-" . ucfirst(str_replace('_', ' ', $modelname)) . "')
            @section('styles')\n\t\t\t \n\t\t\t  @endsection
            @section('admin-content')
                <div class=\"row\">
                    <div class=\"col\">
                            <div class=\"card\">
                                <div class=\"card-header\">
                                    <div class=\"row\">
                                        <div class=\"col \"><h1 class=\"card-title \">" . ucfirst(str_replace('_', ' ', $modelname)) . " List</h1></div>
                                        <div class=\"col \" style=\"text-align:end;\"><a href=\"{{ route('{$modelname}.create') }}\" class=\"btn btn-outline-primary\">Add New</a></div>
                                    </div>
                                </div>
                                <div class=\"card-body\">
                                    @include('partials.backend.messages')
                                    <table class=\"table table-bordered \" id=\"datatable\">
                                        <thead>
                                            <tr>
                                                <!-- Define table headers based on your model fields -->
                                                $fieldsTd
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach(\$data as \$row)
                                                    <tr>
                                                        <!-- Display the table data based on your model fields -->
                                                        @foreach(\$fields as \$fieldName)
                                                            <td>{{ \$row->{\$fieldName} }}</td>
                                                        @endforeach
                                                        <td><a href=\"{{ route('{$modelname}.edit', \$row) }}\" class=\"btn btn-primary btn-sm\">Edit </a> <a href=\"{{ route('{$modelname}.destroy', \$row) }} \" class=\"btn btn-danger btn-sm\">Delete </a></td>
                                                    </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                    </div>
                </div>
            @endsection\n\t\t\t
            @section('scripts')\n\t\t\t
            <script>\n\t\t\t

                $(document).ready(function(){\n\t\t\t

                    $('#datatable').DataTable();


                    \n\t\t\t
                });\n\t\t\t
                </script>\n\t\t\t
                @endsection\n\t\t\t
        ";
        foreach ($newfields as $key => $value) {
            $create_input_fields .= "<label for=\"$key\">" . ucfirst(str_replace('_', ' ', $key)) . "</label> \n\t\t\t";
            $create_input_fields .= "<input type=\"$value[1]\" class=\"form-control @error('$key') is-invalid @enderror \" name=\"$key\" id=\"$key\" value=\"{{ old('" . $key . "') }}\">\n\t\t\t";
            $create_input_fields .= "@error('$key')\n\t\t\t <div class=\"alert alert-danger\"> {{ \$message }} </div>\n\t\t\t @enderror";
        }
        $createView = "@extends('layouts.backend.main')
            @section('title', 'Create-" . ucfirst(str_replace('_', ' ', $modelname)) . "')
            @section('styles')\n\t\t\t \n\t\t\t  @endsection
            @section('admin-content')
                <div class=\"row\">
                    <div class=\"col\">
                        <div class=\"card\">
                            <div class=\"card-header\">
                                <div class=\"row\">
                                    <div class=\"col\"><h1 class=\"card-title\">Create " . ucfirst(str_replace('_', ' ', $modelname)) . "</h1></div>
                                    <div class=\"col \"  style=\"text-align:end;\"><a href=\"{{ route('{$modelname}.index') }}\" class=\"btn btn-outline-dark\">Back</a></div>
                                </div>
                            </div>
                            <div class=\"card-body\">
                                    @include('partials.backend.messages')
                                    <form action=\"{{ route('{$modelname}.store') }}\" method=\"POST\">
                                    @csrf
                                    $create_input_fields
                                    <button type=\"submit\" class=\"btn btn-outline-primary \">Submit</button>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endsection
        ";

        foreach ($newfields as $key => $value) {
            $edit_input_fields .= "<label for=\"$key\">" . ucfirst(str_replace('_', ' ', $key)) . "</label> \n\t\t\t";
            $edit_input_fields .= "<input type=\"$value[1]\" class=\"form-control @error('$key') is-invalid @enderror \" name=\"$key\" id=\"$key\" value=\"{{ old('" . $key . "') ? old('" . $key . "') : $" . $modelname . "->$key }}\">\n\t\t\t";
            $edit_input_fields .= "@error('$key')\n\t\t\t <div class=\"alert alert-danger\"> {{ \$message }} </div>\n\t\t\t @enderror";
        }
        $editView = "@extends('layouts.backend.main')
            @section('title', 'Edit-" . ucfirst(str_replace('_', ' ', $modelname)) . "')
            @section('styles')\n\t\t\t \n\t\t\t  @endsection
            @section('admin-content')
                <div class=\"row\">
                    <div class=\"col\">
                        <div class=\"card\">
                            <div class=\"card-header\">
                                    <div class=\"row\">
                                        <div class=\"col\"><h1 class=\"card-title\">Edit " . ucfirst(str_replace('_', ' ', $modelname)) . "</h1></div>
                                        <div class=\"col\" style=\"text-align:end;\"><a href=\"{{ route('{$modelname}.index') }}\" class=\"btn btn-outline-dark\">Back</a></div>
                                    </div>
                            </div>
                            <div class=\"card-body\">
                                    @include('partials.backend.messages')
                                    <form action=\"{{ route('{$modelname}.update', \${$modelname}) }}\" method=\"POST\">
                                    @csrf
                                    $edit_input_fields
                                    <button type=\"submit\" class=\"btn btn-outline-primary \">Submit</button>
                                    </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endsection
        ";






        // $indexView = str_replace('{fields}', $fieldsTd, $indexView);
        // $createView = str_replace('{InputFields}', $create_input_fields, $createView);

        file_put_contents($viewsPath . '/index.blade.php', $indexView);
        file_put_contents($viewsPath . '/create.blade.php', $createView);
        file_put_contents($viewsPath . '/edit.blade.php', $editView);
    }


    private function generateLink($modelName)
    {
        // Your implementation to generate the link URL based on the $modelName.
        // For example:
        $link = strtolower($modelName);
        return route('changeLang', ['lang' => $modelName]);
    }


    protected function appendToSidebar($link)
    {
        // Path to the sidebar.blade.php file
        $sidebarFile = resource_path('views/partials/backend/sidebar.blade.php');

        // Load the content of the sidebar.blade.php file
        $sidebarContent = File::get($sidebarFile);

        // Append the new link HTML to the sidebar content
        // $modifiedContent = $sidebarContent . "\n" . $link;

        // Find the position where we want to insert the link inside the ul element
        // For example, let's say you want to add it after the last li element
        $position = strrpos($sidebarContent, '<!-- Sidebar Toggler (Sidebar) -->');

        // If the position is found, insert the link HTML after the last li element
        if ($position !== false) {
            $modifiedContent = substr_replace($sidebarContent, $link, $position, 0);
            // Save the modified content back to the sidebar.blade.php file
            File::put($sidebarFile, $modifiedContent);
        } else {
            // The position was not found, handle the error or add the link to a default location
            $this->error('Position not found in the sidebar.');
        }
    }


    private function generateRoutes($modelName)
    {


        $routes = `Route::resource('` . strtolower($modelName) . `',$modelName.Controller::class);`;

        return $routes;
    }


    private function appendRoutes($modelName)
    {
        $class = "use App\Http\Controllers\\" . str_replace('_', '', $modelName) . "Controller;";
        $routes = '';
        $apiroutes = '';
        // Path to the web.php file
        $webphpPath = base_path('routes/web.php');
        $apiphpPath = base_path('routes/api.php');

        // Load the content of the web.php file
        $webphpContent = File::get($webphpPath);
        $apiphpContent = File::get($apiphpPath);
        $modelname = strtolower($modelName);
        $routes .= "Route::controller(" . str_replace('_', '', $modelName) . "Controller::class)->prefix('" . str_replace('_', '-', $modelname) . "')->name('$modelname.')->group(function(){
            Route::get('/', 'index')->middleware('permission:read ".Str::replace('_','',Str::plural($modelname))."')->name('index');
            Route::get('/create', 'create')->middleware('permission:create ".Str::replace('_','',Str::plural($modelname))."')->name('create');
            Route::post('/store', 'store')->middleware('permission:create ".Str::replace('_','',Str::plural($modelname))."')->name('store');
            Route::get('/edit/{" . $modelname . "}', 'edit')->middleware('permission:edit ".Str::replace('_','',Str::plural($modelname))."')->name('edit');
            Route::post('/update/{" . $modelname . "}', 'update')->middleware('permission:edit ".Str::replace('_','',Str::plural($modelname))."')->name('update');
            Route::get('/destroy/{" . $modelname . "}', 'destroy')->middleware('permission:delete ".Str::replace('_','',Str::plural($modelname))."')->name('destroy');

        });";
        $apiroutes .= "Route::controller(" . str_replace('_', '', $modelName) . "Controller::class)->prefix('" . str_replace('_', '-', $modelname) . "')->name('$modelname.')->group(function(){
            Route::get('/', 'index');
            Route::post('/store', 'store');
            Route::post('/update/{" . $modelname . "}', 'update');
            Route::get('/destroy/{" . $modelname . "}', 'destroy');

        });";

        // Append the routes to the web.php file
        File::append($webphpPath, "\n" . $class . "\n" . $routes . "\n");

        File::append($apiphpPath, "\n" . $class . "\n" . $apiroutes . "\n");
    }

    private function makePermissions($modelName)
    {

        $model_name = Str::replace('_','',Str::plural(Str::lower($modelName)));
        $data = [
            'read ' . $model_name,
            'create ' . $model_name,
            'edit ' . $model_name,
            'delete ' . $model_name,
        ];

        foreach ($data as $item) {
            Permission::create(['name' => $item, 'guard_name' => 'web']);
        }

        return true;
    }
}
