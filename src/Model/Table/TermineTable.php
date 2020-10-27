<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Termine Model
 *
 * @method \App\Model\Entity\Termine get($primaryKey, $options = [])
 * @method \App\Model\Entity\Termine newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Termine[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Termine|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Termine saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Termine patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Termine[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Termine findOrCreate($search, callable $callback = null, $options = [])
 */
class TermineTable extends Table
{
    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
        
    public function initialize(array $config){
        parent::initialize($config);
        $this->belongsTo('StammOrte', ['foreignKey' => 'ort']);
        $this->belongsTo('Termindetails', ['foreignKey' => 'details']);
        $this->setTable('Termine');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');
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
            ->dateTime('beginn')
            ->allowEmptyDateTime('beginn');

        $validator
            ->dateTime('ende')
            ->allowEmptyDateTime('ende');

        $validator
            ->integer('ort')
            ->allowEmptyString('ort');

        $validator
            ->scalar('typ')
            ->maxLength('typ', 40)
            ->allowEmptyString('typ');

        $validator
            ->integer('details')
            ->allowEmptyString('details');

        return $validator;
    }
}
