<?php

namespace Taxonomies\Controller\Admin;

use Cake\Event\EventInterface;

class TermsController extends AppController
{


    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
    }

    public function index()
    {
        $taxonomy_id = $this->request->getQuery('target');
        $terms = $this->Terms->find()->select(['Terms.id', 'Terms.title', 'Terms.slug']);
        if ($taxonomy_id) {
            $terms = $terms->matching('Taxonomies', function ($q) use ($taxonomy_id) {
                return $q->where(['TermsTaxonomies.taxonomy_id' => $taxonomy_id]);
            });
        }

        $rows = $this->paginate($terms);
        $this->set('rows', $rows);
    }

    public function add()
    {
        parent::_create($this->Terms);
        $this->_setCommonData();
    }

    public function edit($id = null)
    {
        parent::_update($this->Terms, ['id' => $id, 'contain' => ['Taxonomies']]);
        $this->_setCommonData();
    }

    public function delete($id = null)
    {
        parent::_remove($this->Terms, $id);
    }

    private function _setCommonData()
    {
        $taxonomies = $this->Terms->Taxonomies->find('assoc')->toArray();
        foreach ($taxonomies as $i => $taxonomy) {
            $taxonomies[$taxonomy->type->title][$taxonomy->id] = $taxonomy->vocabulary->title;
            unset($taxonomies[$i]);
        }
        $this->set('taxonomies', $taxonomies);
    }
}
