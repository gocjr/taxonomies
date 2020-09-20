<?php

namespace Taxonomies\Controller\Admin;

class TypesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->Breadcrumbs
            ->add('Admin', ['action' => 'index', 'controller' => 'Dashoard','plugin'=>false])
            ->add('Taxonomies', ['action' => 'index', 'controller' => 'Taxonomies'])
            ->add('Types');
    }
    public function index()
    {
        parent::_read($this->Types);
    }

    public function add()
    {
        $this->Breadcrumbs->add('Types', ['action' => 'index'])->add('Add');
        parent::_create($this->Types);
        $this->set('vocabularies', $this->Types->Vocabularies->find('list'));
    }

    public function edit($id = null)
    {
        $this->Breadcrumbs->add('Types', ['action' => 'index'])->add('Edit');
        parent::_update($this->Types, ['id' => $id, 'contain' => ['Vocabularies']]);

        $this->set('vocabularies', $this->Types->Vocabularies->find('list'));
    }

    public function delete($id = null)
    {
        parent::_remove($this->Types, $id);
    }
}
