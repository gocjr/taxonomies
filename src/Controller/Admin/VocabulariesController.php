<?php

namespace Taxonomies\Controller\Admin;

use Cake\Event\EventInterface;

class VocabulariesController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
        $this->Breadcrumbs
            ->add('Admin', ['action' => 'index', 'controller' => 'Dashoard', 'plugin' => false])
            ->add('Taxonomies', ['action' => 'index', 'controller' => 'Taxonomies'])
            ->add('Vocabularies');
    }

    public function index()
    {
        $type = $this->request->getQuery('type');
        $vocabularies = $this->Vocabularies->find();
        if ($type) {
            $vocabularies = $vocabularies->leftJoinWith('Taxonomies', function ($query) use ($type) {
                return $query->where(['Taxonomies.type_id' => $type]);
            });
        }
        parent::_read($vocabularies);
        $this->set('types', $this->Vocabularies->Taxonomies->Types->find('list'));
    }

    public function add()
    {
        $this->Breadcrumbs->add('Vocabularies', ['action' => 'index'])->add('Add');
        parent::_create($this->Vocabularies);
        $this->set('types', $this->Vocabularies->Taxonomies->Types->find('list'));
    }

    public function edit($id = null)
    {
        $this->Breadcrumbs->add('Vocabularies', ['action' => 'index'])->add('Edit');
        parent::_update($this->Vocabularies, ['id' => $id, 'contain' => ['Types']]);
        $this->set('types', $this->Vocabularies->Taxonomies->Types->find('list'));
    }

    public function delete($id = null)
    {
        parent::_remove($this->Types, $id);
    }


    private function _debugTest(array $options = [])
    {
        $model = $this->{$this->getName()};
        $id = current($this->request->getParam('pass'));

        $row = $model->newEmptyEntity();
        if ($id) {
            $row = $model->get($id, $options);
        }
        $data = $this->request->getData();
        $row = $model->patchEntity($row, $data);

        if ($this->request->is(['put', 'post'])) {

            $model->save($row);
        }

        $this->set('row', $row);
    }
}
