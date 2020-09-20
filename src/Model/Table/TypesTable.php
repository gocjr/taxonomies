<?php

declare(strict_types=1);

namespace Taxonomies\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Types Model
 *
 * @property \Taxonomies\Model\Table\TaxonomiesTable&\Cake\ORM\Association\HasMany $Taxonomies
 *
 * @method \Taxonomies\Model\Entity\Type get($primaryKey, $options = [])
 * @method \Taxonomies\Model\Entity\Type newEntity($data = null, array $options = [])
 * @method \Taxonomies\Model\Entity\Type[] newEntities(array $data, array $options = [])
 * @method \Taxonomies\Model\Entity\Type|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Taxonomies\Model\Entity\Type saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Taxonomies\Model\Entity\Type patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Taxonomies\Model\Entity\Type[] patchEntities($entities, array $data, array $options = [])
 * @method \Taxonomies\Model\Entity\Type findOrCreate($search, callable $callback = null, $options = [])
 */
class TypesTable extends Table
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

        $this->setTable('types');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->hasMany('Taxonomies', [
            'foreignKey' => 'type_id',
            'className' => 'Taxonomies.Taxonomies',
        ]);
        $this->belongsToMany('Vocabularies', [
            'foreignKey' => 'type_id',
            'targetForeignKey' => 'vocabulary_id',
            'joinTable' => 'taxonomies',
            'className' => 'Taxonomies.Vocabularies',
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

        return $validator;
    }
}
