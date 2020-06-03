<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Web extends CI_Controller {

	public function __construct() {
        parent::__construct();
        $this->load->model('m_product');
        $this->load->model('m_budget');
        $this->load->model('m_requestin');
    }

    public function index() 
    {	
        $currentYear = date('Y');
    	$currentBudget = $this->m_budget->totalCurrentBudget();
        $budgetOut = $this->m_product->allBudgetOut($currentYear);
        $requestin = $this->m_requestin->countRequestIn();
        $remainBudget = $currentBudget->total_budget - $budgetOut->budget_total;
        $data['budget'] = $currentBudget;
        $data['budgetOut'] = $budgetOut;
        $data['requestIn'] = $requestin;
        $data['remainBudget'] = $remainBudget;
    	$this->template->load('overview', 'web/dashboard', $data);
    }

}