<?php
namespace App\Controller;

class PointsController extends AppController
{
    public function index($kategorie=null){
        $points=$this->Points->find();

        $jsonpoints=[];
        $jsonpoints['type']='FeatureCollection';
        $jsonpoints['features']=[];
        foreach ($points as $point)
        {
            $jsonpoint=[];
            $jsonpoint['type']='Feature';
            $jsonpoint['properties']=[];
            $jsonpoint['properties']['Strasse']=$point->Strasse;
            $jsonpoint['properties']['Nr']=$point->Nr;
            $jsonpoint['properties']['PLZ']=$point->PLZ;
            $jsonpoint['properties']['Stadt']=$point->Stadt;
            $jsonpoint['geometry']=[];

            $jsonpoint['geometry']['type']='Point';
            $jsonpoint['geometry']['coordinates']=[$point->Laengengrad, $point->Breitengrad];
            $jsonpoints['features'][] = $jsonpoint;
        }
        $jsonpoints=json_encode($jsonpoints);
        $this->set('points', $jsonpoints);
    }
}
