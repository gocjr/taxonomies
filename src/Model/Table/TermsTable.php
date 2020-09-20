<?php

declare(strict_types=1);

namespace Taxonomies\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Terms Model
 *
 * @property \Taxonomies\Model\Table\TaxonomiesTable&\Cake\ORM\Association\BelongsToMany $Taxonomies
 *
 * @method \Taxonomies\Model\Entity\Term get($primaryKey, $options = [])
 * @method \Taxonomies\Model\Entity\Term newEntity($data = null, array $options = [])
 * @method \Taxonomies\Model\Entity\Term[] newEntities(array $data, array $options = [])
 * @method \Taxonomies\Model\Entity\Term|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Taxonomies\Model\Entity\Term saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Taxonomies\Model\Entity\Term patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Taxonomies\Model\Entity\Term[] patchEntities($entities, array $data, array $options = [])
 * @method \Taxonomies\Model\Entity\Term findOrCreate($search, callable $callback = null, $options = [])
 */
class TermsTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('terms');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');
        
        /*this->belongsTo('TermsTaxonomies', [
            'className' => 'Taxonomies.TermsTaxonomies',
        ]);*/

        $this->belongsToMany('Taxonomies', [
            'foreignKey' => 'term_id',
            'targetForeignKey' => 'taxonomy_id',
            'joinTable' => 'terms_taxonomies',
            'joinType' => 'left',
            'className' => 'Taxonomies.Taxonomies',
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator): Validator
    {
        $validator
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('title')
            ->maxLength('title', 255)
            ->allowEmptyString('title');

        $validator
            ->scalar('slug')
            ->maxLength('slug', 255)
            ->allowEmptyString('slug');

        $validator
            ->integer('fakey')
            ->allowEmptyString('fakey');

        return $validator;
    }
}
