<?php

declare(strict_types=1);

namespace Taxonomies\Model\Table;

use Cake\Database\Schema\TableSchemaInterface;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Vocabularies Model
 *
 * @property \Taxonomies\Model\Table\TaxonomiesTable&\Cake\ORM\Association\HasMany $Taxonomies
 *
 * @method \Taxonomies\Model\Entity\Vocabulary get($primaryKey, $options = [])
 * @method \Taxonomies\Model\Entity\Vocabulary newEntity($data = null, array $options = [])
 * @method \Taxonomies\Model\Entity\Vocabulary[] newEntities(array $data, array $options = [])
 * @method \Taxonomies\Model\Entity\Vocabulary|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Taxonomies\Model\Entity\Vocabulary saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \Taxonomies\Model\Entity\Vocabulary patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \Taxonomies\Model\Entity\Vocabulary[] patchEntities($entities, array $data, array $options = [])
 * @method \Taxonomies\Model\Entity\Vocabulary findOrCreate($search, callable $callback = null, $options = [])
 */
class VocabulariesTable extends Table
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

        $this->setTable('vocabularies');
        $this->setDisplayField('title');
        $this->setPrimaryKey('id');

        $this->hasOne('Taxonomy', [
            'foreignKey' => 'vocabulary_id',
            'className' => 'Taxonomies.Taxonomies',
        ]);

        $this->hasMany('Taxonomies', [
            'foreignKey' => 'vocabulary_id',
            'className' => 'Taxonomies.Taxonomies',
        ]);

        $this->belongsToMany('Types', [
            'foreignKey' => 'vocabulary_id',
            'targetForeignKey' => 'type_id',
            'joinTable' => 'taxonomies',
            'className' => 'Taxonomies.Types',
        ]);
    }

    protected function _initializeSchema(TableSchemaInterface $schema): TableSchemaInterface
    {
        $schema->setColumnType('attrs', 'json');
        return $schema;
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
