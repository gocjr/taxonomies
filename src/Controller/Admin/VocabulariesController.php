<?php

namespace Taxonomies\Controller\Admin;

use Cake\Event\EventInterface;

class VocabulariesController extends AppController
{

    public function beforeRender(EventInterface $event)
    {
        parent::beforeRender($event);
        $this->addCrumb('Taxonomies', ['action' => 'index']);
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
        parent::_create($this->Vocabularies);
        $this->_setCommonData();
    }

    public function edit($id = null)
    {
        parent::_update($this->Vocabularies, ['id' => $id, 'contain' => ['Types']]);
        $this->_setCommonData();
    }

    public function delete($id = null)
    {
        parent::_remove($this->Types, $id);
    }


    protected function _setCommonData(): void
    {
        $this->set('types', $this->Vocabularies->Taxonomies->Types->find('list'));
    }
}
