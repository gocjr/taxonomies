<?php

declare(strict_types=1);

namespace Taxonomies\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Taxonomies Model
 *
 * @property \Taxonomies\Model\Table\TypesTable&\Cake\ORM\Association\BelongsTo $Types
 * @property \Taxonomies\Model\Table\VocabulariesTable&\Cake\ORM\Association\BelongsTo $Vocabularies
 * @property \Taxonomies\Model\Table\TermsTable&\Cake\ORM\Association\BelongsToMany $Terms
 *
 * @method \Taxonomies\Model\Entity\Taxonomy get($primaryKey, $options = [])
 * @method \Taxonomies\Model\Entity\Taxonomy newEntity($data = null, array $options = [])
 * @method \Taxonomies\Model\Entity\Taxonomy[] newEntities(array $data, array $options = [])
 * @method \Taxonomies\Model\Entity\Taxonomy|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Taxonomies\Model\Entity\Taxonomy saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Taxonomies\Model\Entity\Taxonomy patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Taxonomies\Model\Entity\Taxonomy[] patchEntities($entities, array $data, array $options = [])
 * @method \Taxonomies\Model\Entity\Taxonomy findOrCreate($search, callable $callback = null, $options = [])
 */
class TaxonomiesTable extends Table
{
    use TaxonomyTrait;
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config): void
    {
        parent::initialize($config);

        $this->setTable('taxonomies');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');


        $this->belongsTo('Types', [
            'foreignKey' => 'type_id',
            'className' => 'Taxonomies.Types',
        ]);
        $this->belongsTo('Vocabularies', [
            'foreignKey' => 'vocabulary_id',
            'className' => 'Taxonomies.Vocabularies',
        ]);
        
        $this->belongsToMany('Terms', [
            'foreignKey' => 'taxonomy_id',
            'targetForeignKey' => 'term_id',
            'joinTable' => 'terms_taxonomies',
            'joinType' => 'left',
            'className' => 'Taxonomies.Terms',
        ]);
        $this->belongsToMany('Vehicles', [
            'foreignKey' => 'term_taxonomy_id',
            'targetForeignKey' => 'user_vehicle_id',
            'joinTable' => 'users_vehicles',
            'joinType' => 'left',
            'className' => 'Users.Vehicles',
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
            ->nonNegativeInteger('id')
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
        $rules->add($rules->existsIn(['type_id'], 'Types'));
        $rules->add($rules->existsIn(['vocabulary_id'], 'Vocabularies'));

        return $rules;
    }
}
