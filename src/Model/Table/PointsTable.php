<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Points Model
 *
 * @method \App\Model\Entity\Point get($primaryKey, $options = [])
 * @method \App\Model\Entity\Point newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Point[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Point|false save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Point saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Point patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Point[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Point findOrCreate($search, callable $callback = null, $options = [])
 */
class PointsTable extends Table
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

        
        $this->setTable('points');
        $this->setDisplayField('Name');
        $this->setPrimaryKey('id');
        
    }

    public function geocoding($queryString){

        debug($queryString);
            $queryString = urlencode($queryString);

            $urlString = "https://nominatim.openstreetmap.org/search?q=".$queryString."&format=geocodejson";
            debug($urlString);
            $opts = array(
                'http'=>array(
                    'header'=>array("Referer: $urlString\r\n")
                )
            );
            $context = stream_context_create($opts);
            $content = file_get_contents($urlString, false, $context);
            $geoObj =  json_decode($content);
            //debug($geoObj);
            /* $breite = $geoObj->features[0]->geometry->coordinates[0];
            $laenge = $geoObj->features[0]->geometry->coordinates[1]; */
            if (isset($geoObj->features[0])){
            return $geoObj->features[0]->geometry->coordinates;
            }
            else {
                return null;
            }

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
