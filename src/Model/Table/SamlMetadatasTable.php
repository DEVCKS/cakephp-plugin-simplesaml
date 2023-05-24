<?php
namespace SimpleSaml\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Addvalues Model
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class SamlMetadatasTable extends Table
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

        $this->setTable('saml_metadatas');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
    }
}
