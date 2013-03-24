<?php

namespace Music\Controller;

use DateTime;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController{
	
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
    
    public function timeRangeAction(){
        return new ViewModel(array(
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
        	)
        );
    }

    public function profileAction(){
    	return new ViewModel(array(
    		'value' => (object)array(
    			'raw' 		=> $this->params()->fromRoute('name', null),
    			'decoded' 	=> urldecode($this->params()->fromRoute('name', null)),
    		),
            'collection' => $this->getServiceLocator()
                ->get('Music\Model\Music')->fetchProfile(
                    urldecode($this->params()->fromRoute('name', null)),
                	$this->params()->fromRoute('type', null)
                )
        	)
    	);
    }
}