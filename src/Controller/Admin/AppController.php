<?php

declare(strict_types=1);

namespace Taxonomies\Controller\Admin;

use Cake\Datasource\ConnectionManager;
use App\Controller\Admin\AppController as BaseController;
use Cake\Event\EventInterface;

class AppController extends BaseController
{
    public function initialize(): void
    {
        parent::initialize();
    }

    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
    }
    
    protected function enableTestDatabase()
    {
        $connection = ConnectionManager::get('test');
        $this->{$this->getName()}->setConnection($connection);
    }
}
