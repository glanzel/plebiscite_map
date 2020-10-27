<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * StammOrte Model
 *
 * @method \App\Model\Entity\StammOrte get($primaryKey, $options = [])
 * @method \App\Model\Entity\StammOrte newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\StammOrte[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\StammOrte|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StammOrte saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\StammOrte patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\StammOrte[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\StammOrte findOrCreate($search, callable $callback = null, $options = [])
 */
class StammOrteTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('Stamm_Orte');
        $this->setDisplayField('ort');
        $this->setPrimaryKey('id');
        $this->hasMany('Termine', [
            'foreignKey' => 'id'
        ]);
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
            ->integer('id')
            ->allowEmptyString('id', null, 'create');

        $validator
            ->scalar('bezirk')
            ->maxLength('bezirk', 40)
            ->requirePresence('bezirk', 'create')
            ->notEmptyString('bezirk');

        $validator
            ->scalar('ort')
            ->maxLength('ort', 40)
            ->requirePresence('ort', 'create')
            ->notEmptyString('ort');

        return $validator;
    }
}
