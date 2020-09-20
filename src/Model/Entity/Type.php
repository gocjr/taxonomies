<?php
declare(strict_types=1);

namespace Taxonomies\Model\Entity;

use Cake\ORM\Entity;

/**
 * Type Entity
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $slug
 *
 * @property \Taxonomies\Model\Entity\Taxonomy[] $taxonomies
 */
class Type extends Entity
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
        'title' => true,
        'slug' => true,
        'taxonomies' => true,
        'vocabularies'=>true
    ];
}
