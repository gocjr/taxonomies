<?php
declare(strict_types=1);

namespace Taxonomies\Model\Entity;

use Cake\ORM\Entity;

/**
 * Term Entity
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $slug
 * @property int|null $fakey
 *
 * @property \Taxonomies\Model\Entity\TaxonomiesTerm[] $taxonomies_terms
 * @property \Taxonomies\Model\Entity\Taxonomy[] $taxonomies
 */
class Term extends Entity
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
        'custom_id' => true,
        'taxonomies_terms' => true,
        'taxonomies' => true,
    ];
}
