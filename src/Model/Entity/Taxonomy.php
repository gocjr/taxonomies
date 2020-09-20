<?php
declare(strict_types=1);

namespace Taxonomies\Model\Entity;

use Cake\ORM\Entity;

/**
 * Taxonomy Entity
 *
 * @property int $id
 * @property int|null $type_id
 * @property int|null $vocabulary_id
 *
 * @property \Taxonomies\Model\Entity\Type $type
 * @property \Taxonomies\Model\Entity\Vocabulary $vocabulary
 * @property \Taxonomies\Model\Entity\Term[] $terms
 */
class Taxonomy extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array
     */
    protected $_accessible = [
        'type_id' => true,
        'vocabulary_id' => true,
        'type' => true,
        'vocabulary' => true,
        'terms' => true,
    ];
}
