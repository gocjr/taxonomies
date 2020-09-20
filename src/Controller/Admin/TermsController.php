<?php

namespace Taxonomies\Controller\Admin;

use Cake\Event\EventInterface;

class TermsController extends AppController
{


    public function beforeFilter(EventInterface $event)
    {
        parent::beforeFilter($event);
        $this->Breadcrumbs
            ->add('Admin', ['action' => 'index', 'controller' => 'Dashoard', 'plugin' => false])
            ->add('Taxonomies', ['action' => 'index', 'controller' => 'Taxonomies'])
            ->add('Terms');
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
        //parent::_read($terms);
    }

    public function add()
    {
        $this->Breadcrumbs->add('Terms', ['action' => 'index'])->add('Add');;
        parent::_create($this->Terms);
        $this->setVocabulariesToView();
    }

    public function edit($id = null)
    {
        $this->Breadcrumbs->add('Terms', ['action' => 'index'])->add('Edit');;
        parent::_update($this->Terms, ['id' => $id, 'contain' => ['Taxonomies']]);
        $this->setVocabulariesToView();
    }

    public function delete($id = null)
    {
        parent::_delete($this->Terms, $id);
    }

    private function setVocabulariesToView()
    {
        $taxonomies = $this->Terms->Taxonomies->find('assoc')->toArray();
        foreach ($taxonomies as $i => $taxonomy) {
            $taxonomies[$taxonomy->type->title][$taxonomy->id] = $taxonomy->vocabulary->title;
            unset($taxonomies[$i]);
        }
        $this->set('taxonomies', $taxonomies);
    }
}
