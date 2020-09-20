<?php
declare(strict_types=1);

namespace Taxonomies\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * TermsTaxonomies Model
 *
 * @property \Taxonomies\Model\Table\TaxonomiesTable&\Cake\ORM\Association\BelongsTo $Taxonomies
 * @property \Taxonomies\Model\Table\TermsTable&\Cake\ORM\Association\BelongsTo $Terms
 *
 * @method \Taxonomies\Model\Entity\TermsTaxonomy get($primaryKey, $options = [])
 * @method \Taxonomies\Model\Entity\TermsTaxonomy newEntity($data = null, array $options = [])
 * @method \Taxonomies\Model\Entity\TermsTaxonomy[] newEntities(array $data, array $options = [])
 * @method \Taxonomies\Model\Entity\TermsTaxonomy|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Taxonomies\Model\Entity\TermsTaxonomy saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Taxonomies\Model\Entity\TermsTaxonomy patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Taxonomies\Model\Entity\TermsTaxonomy[] patchEntities($entities, array $data, array $options = [])
 * @method \Taxonomies\Model\Entity\TermsTaxonomy findOrCreate($search, callable $callback = null, $options = [])
 */
class TermsTaxonomiesTable extends Table
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

        $this->setTable('terms_taxonomies');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->belongsTo('Taxonomies', [
            'foreignKey' => 'taxonomy_id',
            'className' => 'Taxonomies.Taxonomies',
        ]);
        $this->belongsTo('Terms', [
            'foreignKey' => 'term_id',
            'className' => 'Taxonomies.Terms',
        ]);

        $this->belongsToMany('Vehicles', [
            'foreignKey' => 'terms_taxonomy_id',
            'targetForeignKey' => 'vehicle_id',
            'joinTable' => 'vehicles_terms_taxonomies',
            'className' => 'Vehicles.Vehicles',
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

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules): RulesChecker
    {
        $rules->add($rules->existsIn(['taxonomy_id'], 'Taxonomies'));
        $rules->add($rules->existsIn(['term_id'], 'Terms'));

        return $rules;
    }
}
