<?php
declare(strict_types=1);

namespace Taxonomies\Model\Entity;

use Cake\ORM\Entity;

/**
 * TermsTaxonomy Entity
 *
 * @property int $id
 * @property int|null $taxonomy_id
 * @property int|null $term_id
 *
 * @property \Taxonomies\Model\Entity\Taxonomy $taxonomy
 * @property \Taxonomies\Model\Entity\Term $term
 */
class TermsTaxonomy extends Entity
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
        'taxonomy_id' => true,
        'term_id' => true,
        'taxonomy' => true,
        'term' => true,
    ];
}
