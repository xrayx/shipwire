<?php
 
class Usps_address_class {
 
		public $account = '504FUHU00087'; //you need to register for this
		public $url = 'http://production.shippingapis.com/ShippingAPI.dll';
		public $address1, $address2, $city, $state, $zip;
		public $ship_address1, $ship_address2, $ship_city, $ship_state, $ship_zip;
 
	function toXML() {
		$xml = ' <AddressValidateRequest USERID="' . $this->account . '"><Address ID="1">';
		$xml .= '<Address1>' . $this->address1 . '</Address1>';
		$xml .= '<Address2>' . $this->address2 . '</Address2>';
		$xml .= '<City>' . $this->city . '</City>';
		$xml .= '<State>' . $this->state . '</State>';
		$xml .= '<Zip5>' . $this->zip . '</Zip5>';
		$xml .= '<Zip4></Zip4></Address>';
 
		if ($this->ship_address2 <> ''){
			//shipping address
			$xml .= '<Address ID="2">';
			$xml .= '<Address1>' . $this->ship_address1 . '</Address1>';
			$xml .= '<Address2>' . $this->ship_address2 . '</Address2>';
			$xml .= '<City>' . $this->ship_city . '</City>';
			$xml .= '<State>' . $this->ship_state . '</State>';
			$xml .= '<Zip5>' . $this->ship_zip . '</Zip5>';
			$xml .= '<Zip4></Zip4></Address>';
			}
 
		$xml .= '</AddressValidateRequest>';
 
     return $xml;
     }
 
	function submit_request() {
 
		$ch = curl_init($this->url);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, "API=Verify&XML=" . $this->toXML());
		curl_setopt($ch, CURLOPT_TIMEOUT, 60);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		//curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,false);
 
		$result = curl_exec($ch);
		$error = curl_error($ch);
 
		if(empty($error)) {
			return $result;
		}else{
			die(curl_error($ch));
		}
	}
}
 
?>