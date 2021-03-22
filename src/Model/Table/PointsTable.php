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
class PointsTable extends AppTable
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
        //$this->setDisplayField('Name');
        //$this->setPrimaryKey('id');
        
    }
    
    protected function _initializeSchema(\Cake\Database\Schema\TableSchema $schema){
        $schema->columnType('Details', 'json');
        $schema->columnType('Details_intern', 'json');
        return $schema;
    }

    public function geocodePoint($point){
        $queryString = $point->Strasse.".".$point->Nr.", ".$point->PLZ." ".$point->Stadt;
        $coordinates =$this->geocoding($queryString);
        if ($coordinates==null) return false;
        else{ 
            list ($point->Breitengrad, $point->Laengengrad) = $coordinates;
            return $point;
        }
            
    }
    
     public function geocoding($queryString, $bindto_addr_family = "0:0"){

        //debug($queryString);
            $queryString = urlencode($queryString);

            $urlString = "https://nominatim.openstreetmap.org/search?q=".$queryString."&format=geocodejson";
            //debug($urlString);
            $opts = array(
                'http'=>array(
                    'header'=>array("Referer: $urlString\r\n"),
                    'timeout'=>20,
                    'method'=>'GET'
                ),
                'socket' => array(
                    'bindto' => $bindto_addr_family
                ),
            );
            
            
            $context = stream_context_create($opts);
            $content = file_get_contents($urlString, false, $context);
            $geoObj =  json_decode($content);
            debug($geoObj);
            /* $breite = $geoObj->features[0]->geometry->coordinates[0];
            $laenge = $geoObj->features[0]->geometry->coordinates[1]; */
            if (isset($geoObj->features[0])){
            return $geoObj->features[0]->geometry->coordinates;
            }
            else {
                return null;
            }

    }
    
    # SPDX-License-Identifier: CC0-1.0
    
    function fetch_http_file_contents($url) {
        $hostname = parse_url($url, PHP_URL_HOST);
        if ($hostname == FALSE) {
            return FALSE;
        }
        
        $host_has_ipv6 = FALSE;
        $host_has_ipv4 = FALSE;
        $file_response = FALSE;
        
        $dns_records = dns_get_record($hostname, DNS_AAAA + DNS_A);
        
        foreach ($dns_records as $dns_record) {
            if (isset($dns_record['type'])) {
                switch ($dns_record['type']) {
                    case 'AAAA':
                        $host_has_ipv6 = TRUE;
                        break;
                    case 'A':
                        $host_has_ipv4 = TRUE;
                        break;
                } } }
                
                if ($host_has_ipv6 === TRUE) {
                    $file_response = file_get_intbound_contents($url, '[0]:0');
                }
                if ($host_has_ipv4 === TRUE && $file_response == FALSE) {
                    $file_response = file_get_intbound_contents($url, '0:0');
                }
                
                return $file_response;
    }
    
    function file_get_intbound_contents($url, $bindto_addr_family) {
        $stream_context = stream_context_create(
            array(
                'socket' => array(
                    'bindto' => $bindto_addr_family
                ),
                'http' => array(
                    'timeout'=>20,
                    'method'=>'GET'
                ) ) );
        
        return file_get_contents($url, FALSE, $stream_context);
    }
    

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
   /*  public function validationDefault(Validator $validator)
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
    } */
}
