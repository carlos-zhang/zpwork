<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class WatchRecord_model extends CI_Model {
    public function __construct() {
        $this->load->database();
    }

    public function get_watchrecords($limt, $offset) {
        $this->db->order_by('WR_BeginTime', 'desc');

        $this->db->select('WR_ID,WR_Begin,WR_BeginTime,WR_End,WR_EndTime');
        $query = $this->db->get('watchrecordpeoplesample', $limt, $offset);

        return $query->result_array();
    }

    public function get_wr_begin() {
        $query = $this->db->query('SELECT WR_Begin FROM WATCHRECORDPEOPLESAMPLE');

        return $query->result_array();
    }


    public function get_amountByday($dayTime) {

		$this->db->distinct();
		$this->db->select('WR_PplID');
		$this->db->from('watchrecordpeoplesample');
		$this->db->where('WR_BeginTime >=', $dayTime);
		$this->db->where('WR_BeginTime <=', $dayTime + 24 * 60 * 60);
		return $this->db->get()->num_rows();

    }

    public function get_amountBytime($dayTime) {
        $result = array();
        for ($i = 0; $i < 24; $i++) {
            $sql        = "SELECT distinct WR_PplID FROM watchrecordpeoplesample WHERE WR_BeginTime>=? AND WR_BeginTime<=?";
            $query      = $this->db->query($sql, array($dayTime + $i * 60 * 60, $dayTime + ($i + 1) * 60 * 60));
            $result[$i] = $query->num_rows();
        }

        return $result;
    }
	
	
    public function get_amountBytime_2($i) {
		$dayTime = strtotime('2011-03-01 00:00:00');
		$this->db->distinct();
		$this->db->select('WR_PplID');
		$this->db->from('watchrecordpeoplesample');
		$this->db->where('WR_BeginTime >=', $dayTime + $i * 24 * 60 * 60);
		$this->db->where('WR_BeginTime < ', $dayTime + ($i + 1) * 24 * 60 * 60);
		$peopleIdArray = $this->db->get()->result_array();
		return $peopleIdArray;
    }
	
	public function get_open_time_by_day_and_people($i, $people_id) {
		$dayTime = strtotime('2011-03-01 00:00:00');
		$this->db->select('WR_BeginTime');
		$this->db->from('watchrecordpeoplesample');
		$this->db->where('WR_PplID =', $people_id);
		$this->db->where('WR_BeginTime >=', $dayTime + $i * 24 * 60 * 60);
		$this->db->where('WR_BeginTime < ', $dayTime + ($i + 1) * 24 * 60 * 60);
		$this->db->order_by('WR_BeginTime', 'asc')->limit(1);
		return $this->db->get()->result_array();
		
	}

    public function get_amountBydayandsex($dayTime, $gender) {		
		$this->db->distinct();
		$this->db->select('WR_PplID');

        $this->db->from('watchrecordpeoplesample');
		$this->db->join('peoplesample', 'watchrecordpeoplesample.WR_PplID = peoplesample.Ppl_ID');
		$this->db->where('watchrecordpeoplesample.WR_BeginTime >=', $dayTime);
		$this->db->where('watchrecordpeoplesample.WR_BeginTime <', $dayTime + 24 * 60 * 60);
		$this->db->where('peoplesample.Ppl_Sex =', $gender);
		return $this->db->get()->num_rows();
    }
    
     public function get_amountBydayandoptions($dayTime, $options) {		
		$this->db->distinct();
		$this->db->select('WR_PplID');

        $this->db->from('watchrecordpeoplesample');
		$this->db->join('peoplesample', 'watchrecordpeoplesample.WR_PplID = peoplesample.Ppl_ID');
		$this->db->where('watchrecordpeoplesample.WR_BeginTime >=', $dayTime);
		$this->db->where('watchrecordpeoplesample.WR_BeginTime <', $dayTime + 24 * 60 * 60);
                if(count($options)>0){
                    foreach ($options as $key=>$name){
                        if($key=='age-low'){
                            $this->db->where('peoplesample.Ppl_age >=',$name);
                                                        continue;
                        }
                        if($key=='age-high'){
                            $this->db->where('peoplesample.Ppl_age <',$name);
                            continue;
                        }
                        if($key=='job'){
                            $this->db->where_in('peoplesample.Ppl_calling',$name);
                            continue;
                        }
                        $this->db->where('peoplesample.'.$key.' =', $name);
                    }
                }
                
		return $this->db->get()->num_rows();
    }
    
    public function birthdaytoage(){
        $this->db->select('Ppl_Birthday');
        $this->db->select('Ppl_Id');
        $this->db->from('peoplesample');
        $birthdays=$this->db->get()->result_array();
        $now=  strtotime('2013-4-9');
        foreach ($birthdays as $birthday){
            $age=2013-substr($birthday['Ppl_Birthday'], 0,4) ;
         $data = array('Ppl_age' => $age);

$this->db->where('Ppl_id', $birthday['Ppl_Id']);
$this->db->update('peoplesample', $data); 
        }
            
    }

}
?>
