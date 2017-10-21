<?php

namespace Uzzal\Acl\Commands;

use Illuminate\Console\Command;
use Route;
use Uzzal\Acl\Models\Permission;
use Uzzal\Acl\Models\Resource;


class AclResource extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'acl:resource';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automatically make resources for Uzzal\ACL library';

    protected $_skip=[
        'App\Http\Controllers\Auth'
    ];

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
        $l = Route::getRoutes();
        $bar = $this->output->createProgressBar(count($l));
        $bar->setFormat('%percent:3s%% %message%');
        foreach($l->getIterator() as $v){
            $action = $v->getActionName();
            if($action=='Closure' || $this->_skipAction($action)){
                $bar->advance();
                continue;
            }
            $this->_create($action, current($v->methods()), $bar);
            $bar->advance();
        }
        $bar->finish();
    }

    protected function _create($action, $method, $bar){
        $resource_id = sha1($action, false);
        $controller = $this->_getControllerName($action);
        $name = $method.'::'.$this->_getActionName($action);

        if ($controller) {
            $resource = Resource::find($resource_id);
            if (!$resource && $name != 'Method') {
                Resource::create([
                    'resource_id' => $resource_id,
                    'name' => $controller . ' ' . $name,
                    'controller' => $controller,
                    'action' => $action
                ]);

                Permission::create(['role_id' => 1, 'resource_id' => $resource_id]);
                $bar->setMessage($action.' (created)');
            }else{
                $bar->setMessage($action.' (already exists!)');
            }
        }else{
            $bar->setMessage($action.' (skipped!)');
        }
    }

    protected function _skipAction($action){
        foreach($this->_skip as $r){
            if(strstr($action, $r)){
                return true;
            }
        }
        return false;
    }

    /**
     * @des Namespace will be \Form\RegistrationController will be like Form-Registration
     * @param string $action
     * @return string
     */
    private function _getControllerName($action) {
        $pattern = '/App\\\Http\\\Controllers\\\([a-zA-Z\\\]+)Controller\@/';
        preg_match($pattern, $action, $matches);

        if (count($matches) == 2) {
            return str_replace('\\', '-', $matches[1]);
        }

        return null;
    }

    /**
     *
     * @param type $action
     * @return string
     */
    private function _getActionName($action) {
        $pattern = '/([a-zA-Z]+)$/';
        preg_match($pattern, $action, $matches);

        if (count($matches) == 2) {
            return ucfirst($matches[1]);
        }

        return '';
    }
}
