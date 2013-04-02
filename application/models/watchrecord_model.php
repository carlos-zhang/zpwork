<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class WatchRecord_model extends CI_Model{
    public function __construct() {
        $this->load->database();
    }   
    
    public function get_watchrecords($limt,$offset){
        $this->db->order_by('WR_BeginTime','desc');
        
        $this->db->select('WR_ID,WR_Begin,WR_BeginTime,WR_End,WR_EndTime');
       $query=$this->db->get('watchrecordpeoplesample',$limt,$offset);
       return $query->result_array();
    }
   
    public function get_wr_begin(){
        $query=$this->db->query('SELECT WR_Begin FROM WATCHRECORDPEOPLESAMPLE');
        return $query->result_array();
    }
    public function get_amountByday($dayTime){
//        $array=array('WR_BeginTime>='=>$dayTime,'WR_BeginTime<='=>($dayTime+24*60*60));
//        $query=$this->db->get_where('watchrecordpeoplesample',$array);
       // echo '<p>SELECT * FROM watchrecordpeoplesample WHERE WR_BeginTime>='.$dayTime.' AND WR_BeginTime<='.($dayTime+24*60*60).'</p>';
        $sql="SELECT * FROM watchrecordpeoplesample WHERE WR_BeginTime>=? AND WR_BeginTime<=?";
       // $query=  $this->db->query('SELECT * FROM watchrecordpeoplesample WHERE WR_BeginTime>='.$dayTime.' AND WR_BeginTime<='.($dayTime+24*60*60));
       $query=  $this->db->query($sql,array($dayTime,$dayTime+24*60*60));
        return $query->num_rows();
        
    }
    
       public  function strtotime(){
       $watchrecords=$this->get_watchrecords(2000,21000);
       foreach ($watchrecords as $watchrecord){   
     
                $beginTime = strtotime($watchrecord['WR_Begin']);
                $endTime = strtotime($watchrecord['WR_End']);
                
                try {
                    
                
                $data = array('WR_BeginTime'=>$beginTime,
                        'WR_EndTime'=>$endTime
               ); 
             if($beginTime&&$endTime);

                $this->db->where('WR_ID',$watchrecord['WR_ID']);
                $this->db->update('watchrecordpeoplesample',$data) ;
                
                }  
                catch (Exception $e){
                echo $e;
                flush();
                }
           }  
       }
   
}
?>
