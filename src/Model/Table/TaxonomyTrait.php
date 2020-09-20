<?php

declare(strict_types=1);

namespace Taxonomies\Model\Table;

use Cake\Utility\Text;
use Closure;
use Taxonomies\Model\Entity\Taxonomy;

trait TaxonomyTrait
{

    public function getItems(): array
    {
        $taxonomies = $this->find('assoc');
        $rows = [];
        foreach ($taxonomies  as $taxonomy) {
            $rows[$taxonomy->type->title]['id'] = $taxonomy->type->id;
            $rows[$taxonomy->type->title]['slug'] = $taxonomy->type->slug;
            $rows[$taxonomy->type->title]['title'] = $taxonomy->type->title;
            $rows[$taxonomy->type->title]['link'] = '#' . $taxonomy->type->slug;

            $rows[$taxonomy->type->title]['children'][$taxonomy->id]['id'] = $taxonomy->vocabulary->id;
            $rows[$taxonomy->type->title]['children'][$taxonomy->id]['slug'] = $taxonomy->vocabulary->slug;
            $rows[$taxonomy->type->title]['children'][$taxonomy->id]['title'] = $taxonomy->vocabulary->title;
            $rows[$taxonomy->type->title]['children'][$taxonomy->id]['link'] = '/plugin:Taxonomies/controller:Terms/action:index?fk:' . $taxonomy->id;
            $rows[$taxonomy->type->title]['children'][$taxonomy->id]['children'] = [];
        }
        sort($rows);
        return $rows;
    }

    public function getLinks(): array
    {
        $links[] = [
            'slug' => 'Taxonomies',
            'title' => 'Taxonomies',
            'link' => 'http://promocarros.com/admin/taxonomies',
            'children' => [
                [
                    'title' => 'Types',
                    'slug' => 'test',
                    'link' => 'http://promocarros.com/admin/taxonomies/types',
                    'children' => []
                ],
                [
                    'title' => 'Vocabularies',
                    'slug' => 'test',
                    'link' => 'http://promocarros.com/admin/taxonomies/vocabularies',
                    'children' => []
                ],
                [
                    'title' => 'Terms',
                    'slug' => 'test',
                    'link' => 'http://promocarros.com/admin/taxonomies/terms',
                    'children' => []
                ],

            ]
        ];
        return $links;
    }


    public function findAssoc(\Cake\ORM\Query $query, array $options = []): \Cake\ORM\Query
    {
        $options +=  [
            'fields' => ['Taxonomies.id', 'Vocabularies.id', 'Vocabularies.title', 'Vocabularies.slug', 'Types.id', 'Types.title', 'Types.slug'],
            'contain' => ['Vocabularies', 'Types'],
            'order' => ['Vocabularies.title' => 'asc', 'Types.id' => 'asc']
        ];
        return $query->find('all', $options);
    }

    public function findTypes($type_id = null,  $vocabulary_id = null)
    {
        $options = [];
        $link = '/plugin:taxonomies/controller:taxonomies/action:index';
        if ($type_id) {
            $options['contain']['Vocabularies']['conditions']['type_id'] = $type_id;
        }
        if ($vocabulary_id) {
            $options['contain']['Vocabularies']['Taxonomies']['conditions']['Taxonomies.type_id'] = $type_id;
            $options['contain']['Vocabularies']['Taxonomies']['conditions']['Taxonomies.vocabulary_id'] = $vocabulary_id;
            $options['contain']['Vocabularies']['Taxonomies'][] = 'Terms';
        }

        $types = $this->Types->find('all', $options);
        $rows = [];
        foreach ($types as $t => $type) {
            $rows[$t] = $this->patchData($type);
            $rows[$t]['link'] = $link . '?type=' . $type->id;
            if ($type->vocabularies) :
                foreach ($type->vocabularies as $v => $vocabulary) {
                    $rows[$t]['children'][$v] = $this->patchData($vocabulary);
                    $rows[$t]['children'][$v]['link'] =  $link . '?type=' . $type->id . '&vocabulary=' . $vocabulary->id;
                    if ($vocabulary->taxonomies) :
                        foreach ($vocabulary->taxonomies as $taxonomy) {
                            foreach ($taxonomy->terms as  $j => $term) {
                                $term = $this->patchData($term);
                                $term['taxonomy_id'] = $taxonomy->id;
                                $rows[$t]['children'][$v]['children'][$j] = $term;
                            }
                        }
                    endif;
                }
            endif;
        }
        return  $rows;
    }

    public function patchData($row): array
    {
        return [
            'id' => $row->id,
            'title' => $row->title,
            'slug' => $row->slug ?? strtolower(Text::slug($row->title, '-')),
            'link' => '#',
            'children' => []
        ];
    }

    public function allTerms($type_id = null,  $vocabulary_id = null)
    {
        $options = [];

        $options['fields'] = ['Taxonomies.id'];
        $options['contain']['Types'] = function ($q) {
            return $q->select(['Types.id', 'Types.title', 'Types.slug']);
        };
        $options['contain']['Vocabularies'] = function ($q) {
            return $q->select(['Vocabularies.id', 'Vocabularies.title', 'Vocabularies.slug']);
        };

        $options['contain']['Terms'] = function ($q) {
            return $q->select(['Terms.id', 'Terms.title']);
        };

        $options['conditions'] = ['Taxonomies.type_id' => $type_id, 'Taxonomies.vocabulary_id' =>  $vocabulary_id];
        $options['conditions'] =  array_filter($options['conditions'], function ($v) {
            return !empty($v);
        });
        $options['order'] =  ['Types.id' => 'ASC', 'Vocabularies.title' => 'ASC'];

        $taxonomies = $this->find('assoc', $options);
        $taxonomies = $this->formatToList($taxonomies);
        return $taxonomies;
    }

    public function listVocabulariesTermsByTypeId($type_id = null, Closure $callback = null)
    {
        $rows  = $this->find()
            ->contain(['Vocabularies', 'Terms'])
            ->where(['Taxonomies.type_id' => $type_id]);

        if (!is_callable($callback)) {
            $callback =  function ($q) {
                return $q
                    ->each(function ($row) {
                        $newRows = [];
                        foreach ($row->terms as $term) {
                            $newRows[$term->_joinData->id] = $term->title;
                        }
                        $row->terms = ['type' => 'text', 'label'  => $row->vocabulary->title,'id'=> $row->vocabulary->id];
                        if (!empty($newRows)) {
                            $row->terms['type'] = 'select';
                            $row->terms['options'] = $newRows;
                        }
            
                        if (!empty($row->vocabulary->attrs)) {
                            $row->terms += $row->vocabulary->attrs;
                        }
                        return $row;
                    })
                    ->extract('terms');
            };
        }
        $rows = $rows->formatResults($callback);

        return $rows;
    }

    public function formatToList($query)
    {
        $taxonomies = $query->toArray();
        $rows = [];
        foreach ($taxonomies as $taxonomy) {
            if (!$taxonomy->terms) {
                continue;
            }
            $rows[$taxonomy->type->id]['id'] = $taxonomy->type->id;
            $rows[$taxonomy->type->id]['title'] = $taxonomy->type->title;
            $rows[$taxonomy->type->id]['children'][$taxonomy->vocabulary->id]['id'] = $taxonomy->vocabulary->id;
            $rows[$taxonomy->type->id]['children'][$taxonomy->vocabulary->id]['title'] = $taxonomy->vocabulary->title;
            $rows[$taxonomy->type->id]['children'][$taxonomy->vocabulary->id]['children'] = [];
            foreach ($taxonomy->terms as $term) {
                $rows[$taxonomy->type->id]['children'][$taxonomy->vocabulary->id]['children'][] = ['id' => $term->id, 'title' => $term->title];
            }
        }
        return $rows;
    }
}
