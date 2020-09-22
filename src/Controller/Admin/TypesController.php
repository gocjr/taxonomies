<?php

namespace Taxonomies\Controller\Admin;

class TypesController extends AppController
{


    public function index()
    {
        parent::_read($this->Types);
    }

    public function add()
    {

        parent::_create($this->Types);
        $this->_setCommonData();
    }

    public function edit($id = null)
    {
        parent::_update($this->Types, ['id' => $id, 'contain' => ['Vocabularies']]);
        $this->_setCommonData();
    }

    public function delete($id = null)
    {
        parent::_remove($this->Types, $id);
    }

    protected function _setCommonData()
    {
        $this->set('vocabularies', $this->Types->Vocabularies->find('list'));
    }
}
