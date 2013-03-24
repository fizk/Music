<?php

namespace Music\Controller;

use DateTime;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\ViewModel;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractRestfulController{
	
	public function indexAction(){
        return new ViewModel(array(
            'value' => (object)array(
                'raw' => "The Beatles",
                'decoded' => "The Beatles",
            ),
            'collection' => $this->getServiceLocator()
                ->get('Music\Model\Music')->fetchProfile("The Beatles"),
                
            'range' => $this->getServiceLocator()
                ->get('Music\Model\Music')->fetchYears()
            )
        );
	}
    
    /**
     * Get a range og artists
     */
    public function timeRangeAction(){
        $data = array(
            'range' => (object)array(
                'previous' => ((int)$this->params()->fromRoute('from',2011))-1,
                'from' => ((int)$this->params()->fromRoute('from',2011)),
                'to' => ((int)$this->params()->fromRoute('to',null)),
                'next' => ((int)$this->params()->fromRoute('from',2011))+1,
            ),
            'collection' => $this->getServiceLocator()
                ->get('Music\Model\Music')->fetchRange(
                    $this->params()->fromRoute('from', null),
                    $this->params()->fromRoute('to', null)
                )
            );

        if(preg_match("/application\/json/", $this->getRequest()->getHeader("Accept")->getFieldValue())){
            return new JsonModel($data);
        }else{
            return new ViewModel($data);
        }
    }

    /**
     * Get profile of one artist
     */
    public function profileAction(){
    	$data = array(
    		'value' => (object)array(
    			'raw' 		=> $this->params()->fromRoute('name', null),
    			'decoded' 	=> urldecode($this->params()->fromRoute('name', null)),
    		),
            'collection' => $this->getServiceLocator()
                ->get('Music\Model\Music')->fetchProfile(
                    urldecode($this->params()->fromRoute('name', null)),
                	$this->params()->fromRoute('type', null)
                )
        	);


        if(preg_match("/application\/json/", $this->getRequest()->getHeader("Accept")->getFieldValue())){
            return new JsonModel($data);
        }else{
            return new ViewModel($data);
        }
    }

    public function get($id){}
    public function getList(){}
    public function update($id, $data){}
    public function create($date){}
    public function delete($id){}
}