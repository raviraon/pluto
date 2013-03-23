<?php
class CaseObj {

	private $campaign;
	private $customer;
	private $fusion_id;
	private $open_date;
	private $status;
	private $closed_date;
	private $comments;

	public function __construct($campaign, $customer, $fusion_id, $open_date, $status, $closed_date="", $comments="" ){
		$this->campaign = $campaign;
		$this->customer = $customer;
		$this->fusion_id = $fusion_id;
		$this->open_date = $open_date;
		$this->status = $status;
		$this->closed_date = $closed_date;
		$this->comments = $comments;
	}
	
	public function getCampaign(){
		return $this->campaign;
	}

	public function setCampaign($campaign){
		$this->campaign = $campaign;
	}

	public function getCustomer(){
		return $this->customer;
	}

	public function setCustomer($customer){
		$this->customer = $customer;
	}

	public function getFusion_id(){
		return $this->fusion_id;
	}

	public function setFusion_id($fusion_id){
		$this->fusion_id = $fusion_id;
	}

	public function getOpen_date(){
		return $this->open_date;
	}

	public function setOpen_date($open_date){
		$this->open_date = $open_date;
	}

	public function getStatus(){
		return $this->status;
	}

	public function setStatus($status){
		$this->status = $status;
	}

	public function getClosed_date(){
		return $this->closed_date;
	}

	public function setClosed_date($closed_date){
		$this->closed_date = $closed_date;
	}

	public function getComments(){
		return $this->comments;
	}

	public function setComments($comments){
		$this->comments = $comments;
	}
}

?>