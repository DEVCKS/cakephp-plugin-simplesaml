<?php

namespace SimpleSaml\Model\Entity;

use Cake\ORM\Entity;

/**
 * SamlMetadata Entity
 *
 * @property int $id
 * @property int $client_id
 * @property array $saml20
 * @property array $shib13
 */
class SamlMetadata extends Entity
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
        'id' => true,
        'client_id' => true,
        'saml20' => true,
        'shib13' => true
    ];

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return $this->client_id;
    }

    /**
     * @return array
     */
    public function getSaml20(): array
    {
        return $this->saml20;
    }

    /**
     * @return array
     */
    public function getShib13(): array
    {
        return $this->shib13;
    }
}
