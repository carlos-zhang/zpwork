<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
 class WatchRecord extends CI_Controller{
     public function __construct() {
         parent::__construct();
         $this->load->model('watchrecord_model');
         $this->load->helper('url');
     }
     public function  view(){
         $data['watchrecords']=$this->watchrecord_model->get_watchrecords();
         $data['wr_begin']=  $this->watchrecord_model->get_wr_begin();
         $data['title'] = "开机广告分析";
         $this->load->view('templates/header');
         $this->load->view('watchrecord/test',$data);
         $this->load->view('templates/footer');
     }
     public function strtotime(){
         $this->watchrecord_model->strtotime();
        // $data['watchrecords'] = $this->watchrecord_model->get_watchrecords();
         
         $this->load->view('watchrecord/converttest');
     }
     
     /////////产生三月的日期///////////////////////////////////////////////////
     public function generateday($year,$month){ 
         $array=array();
        for( $i=1;$i<30;$i++){
           $array[]=$year.'-'.$month.'-'.($i+1);            
        }
        return $array;
     }
     /////////////统计每天开机的人数////////////////////////////////////////////
     public function totalpeoplebyday(){
         $days= $this->generateday(2011, 3);
         $result=array();
         foreach ($days as $day){
             $daytime=strtotime($day);
            $result[$day]=$this->watchrecord_model->get_amountByday($daytime);
         }
         return $result;
     }
     ////////////////////统计每时开机的人数/////////////////////////////////////
     public function totalpeoplebytime(){
         $days=  $this->generateday(2011, 3);
         $temp=array();
         $result = array(24);
        
             foreach ($days as $day){
                   $daytime=  strtotime($day);
                   $temp[]=$this->watchrecord_model->get_amountBytime($daytime);
                   
            }
            
                for($i=0;$i<24;$i++){
                    foreach ($temp as $key=>$tp){
//                        
                        $result[$i] = isset($result[$i]) ? $result[$i]+$tp[$i] : $tp[$i];
            
                    }
            }
            return $result;
         
     }
     public function byday(){
         $data['days']=  $this->totalpeoplebyday();
         $data['title'] = '每日开机人数';
         $this->load->view('templates/header',$data);
         $this->load->view('watchrecord/amountbyday');
         $this->load->view('templates/footer');
     }
     public function  bytime(){
     $data['time'] = $this->totalpeoplebytime();
         $data['title'] ='每时开机人数';
         $this->load->view('templates/header',$data);
         $this->load->view('watchrecord/amountbytime');
         $this->load->view('templates/footer');
     }
 }
