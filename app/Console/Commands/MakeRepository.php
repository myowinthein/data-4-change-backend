<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Storage;

class MakeRepository extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:repository {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create repository directory inside app';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $storage = Storage::disk('app');
        $name = $this->argument('name');
        $extension = 'php';
        $folderpath = 'Repositories';
        $filePath = $folderpath .'/'. $name .'.'. $extension;

        $contents = '<?php

namespace App\Repositories;

use App\Models\Sample;

class '.$name.'
{
    public function __construct(Sample $sample) {
        $this->sample = $sample;
        $this->relationships = [\'userType:id,name\'];
    }

    public function datatable($request, $eagerLoad = true, $withTrash = true) {
        return $this->sample
                        ->when($withTrash, function ($query) {
                            return $query->withTrashed();
                        })
                        ->when($request->has(\'name\'), function ($query) {
                            return $query->where(\'name\', $request->name);
                        })
                        ->when($eagerLoad, function ($query) {
                            return $query->with($this->relationships);
                        })
                        ->orderBy(\'id\', \'desc\')
                        ->get();
    }

    public function all ($eagerLoad = true, $withTrash = true) {
        return $this->sample
                    ->when($withTrash, function ($query) {
                        return $query->withTrashed();
                    })
                    ->when($eagerLoad, function ($query) {
                        return $query->with($this->relationships);
                    })
                    ->all();
    }

    public function show ($id, $eagerLoad = false, $withTrash = false) {
        return $this->sample
                    ->when($withTrash, function ($query) {
                        return $query->withTrashed();
                    })
                    ->when($eagerLoad, function ($query) {
                        return $query->with($this->relationships);
                    })
                    ->find($id);
    }

    public function create ($payload) {
        return $this->sample->create($payload);
    }

    public function update ($id, $payload, $withTrash = false) {
        return $this->sample
                    ->when($withTrash, function ($query) {
                        return $query->withTrashed();
                    })
                    ->find($id)->update($payload);
    }

    public function delete ($id) {
        return $this->sample->destroy($id);
    }

    public function restore ($id) {
        return $this->sample->restore($id);
    }
}';

        // create parent folder
        $storage->makeDirectory($folderpath);

        // create file under folder
        if ($storage->exists($filePath)) {
          echo "\e[0;37;41mRepository already exists!\e[0m\n";
        } else {
          $storage->put($filePath, $contents);
        }
    }
}
