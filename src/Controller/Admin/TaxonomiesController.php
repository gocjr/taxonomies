<?php
declare(strict_types=1);

/**
./cake bake model TaxonomiesTerms --plugin Taxonomies &&
./cake bake model Taxonomies --plugin Taxonomies &&
./cake bake model Vocabularies --plugin Taxonomies &&
./cake bake model Types --plugin Taxonomies &&
./cake bake model Terms --plugin Taxonomies
 * 
 */
namespace Taxonomies\Controller\Admin;


class TaxonomiesController extends AppController
{
    public function initialize(): void
    {
        parent::initialize();
        $this->request = $this->request->withParam('pass', $this->request->getQuery());
    }
    
    public function index()
    {
        $rows = $this->Taxonomies->Types->find();
        $this->set('rows', $rows);
    }

    public function add()
    {
        /*
        $this->disableAutoRender();
        $data['type_id'] =  1;
        $data['vocabu1 =  1;
        $row = $this->Taxonomies->find()->where($data)->first() ?? $this->Taxonomies->newEmptyEntity();
        $data['terms']['_ids'] = [3];
        $row = $this->Taxonomies->patchEntity($row, $data);
        $row = $this->Taxonomies->save($row);*/

        parent::_create($this->Taxonomies);
        $types = $this->Taxonomies->Types->find('list');
        $vocabularies = $this->Taxonomies->Vocabularies->find('list');
        $terms = $this->Taxonomies->Terms->find('list');
        $this->set(compact('types', 'vocabularies', 'terms'));
    }

    public function edit($id = null)
    {
    }
}
