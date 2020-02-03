<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

class OrteTable extends Table{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config){
        parent::initialize($config);
        $this->setTable('points');
    }
    
    protected function _initializeSchema(\Cake\Database\Schema\TableSchema $schema){
        $schema->columnType('Details', 'json');
        $schema->columnType('Details_intern', 'json');
        return $schema;
    }
    
    public function save(\Cake\Datasource\EntityInterface $entity, $options = Array()){
		debug($entity);
		return parent::save($entity, $options);
	}


    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->uuid('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('Name')
            ->maxLength('Name', 200)
            ->allowEmptyString('Name');

        $validator
            ->scalar('Strasse')
            ->maxLength('Strasse', 200)
            ->requirePresence('Strasse', 'create')
            ->notEmptyString('Strasse');

        $validator
            ->scalar('Nr')
            ->maxLength('Nr', 10)
            ->requirePresence('Nr', 'create')
            ->notEmptyString('Nr');

        $validator
            ->integer('PLZ')
            ->requirePresence('PLZ', 'create')
            ->notEmptyString('PLZ');

        $validator
            ->scalar('Stadt')
            ->maxLength('Stadt', 200)
            ->requirePresence('Stadt', 'create')
            ->notEmptyString('Stadt');

        $validator
            ->scalar('Beschreibung')
            ->allowEmptyString('Beschreibung');

        $validator
            ->numeric('Laengengrad')
            ->allowEmptyString('Laengengrad');

        $validator
            ->numeric('Breitengrad')
            ->allowEmptyString('Breitengrad');

        $validator
            ->scalar('Kategorie')
            ->maxLength('Kategorie', 200)
            ->allowEmptyString('Kategorie');

        return $validator;
    }
}
