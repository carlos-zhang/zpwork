﻿<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class WatchRecord extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('watchrecord_model');
        $this->load->helper('url');
    }

    public function view() {
        $data['watchrecords'] = $this->watchrecord_model->get_watchrecords();
        $data['wr_begin'] = $this->watchrecord_model->get_wr_begin();
        $data['title'] = "收视记录";
        $this->load->view('templates/header', $data);
        $this->load->view('watchrecord/test');
        $this->load->view('templates/footer');
    }

    public function strtotime() {
        $this->watchrecord_model->strtotime();
        // $data['watchrecords'] = $this->watchrecord_model->get_watchrecords();
        $this->load->view('watchrecord/converttest');
    }

    /////////产生日期//////////////////////////////////////////////////
    public function generateday($year, $month, $daystart = 1, $dayend = 30) {
        $array = array();
        for ($i = $daystart; $i < $dayend; $i++) {
            $array[] = $year . '-' . $month . '-' . ($i + 1);
        }

        return $array;
    }

    /////////////每日开机总人数////////////////////////////////////////////
    public function totalpeoplebyday() {
        $days = $this->generateday(2011, 3);
        $result = array();
        foreach ($days as $day) {
            $daytime = strtotime($day);
            $result[$day] = $this->watchrecord_model->get_amountByday($daytime);
        }
        return $result;
    }

    ////////////////////缁熻姣忔椂寮€鏈虹殑浜烘暟/////////////////////////////////////
    // public function totalpeoplebytime() {
    //     $days   = $this->generateday(2011, 3);
    //     $temp   = array();
    //     $result = array(24);
    // 
    //     foreach ($days as $day) {
    //         $daytime = strtotime($day);
    //         $temp[]  = $this->watchrecord_model->get_amountBytime($daytime);
    // 
    //     }
    // 
    //     for ($i = 0; $i < 24; $i++) {
    //         foreach ($temp as $key => $tp) {
    //             $result[$i] = isset($result[$i]) ? $result[$i] + $tp[$i] : $tp[$i];
    // 
    //         }
    //     }
    // 
    //     return $result;
    // 
    // }
    /////////////按照性别查询每日开机人数////////////////////////////////////////////
    public function totalpeoplebydayandsex() {
        $days = $this->generateday(2011, 3);
        $result = array();
        $genderArray = array('男', '女');
        foreach ($genderArray as $gender) {
            foreach ($days as $day) {
                $daytime = strtotime($day);
                $result[$gender][$day] = $this->watchrecord_model->get_amountBydayandsex($daytime, $gender);
            }
        }
        return $result;
    }

    public function totalpeoplebydayandoptions($options) {
        $days = $this->generateday(2011, 3);
        $result = array();
        foreach ($days as $day) {
            $daytime = strtotime($day);
            $result[$day] = $this->watchrecord_model->get_amountBydayandoptions($daytime, $options);
        }
        return $result;
    }

    public function byday() {
        $data['days'] = $this->totalpeoplebyday();
        $data['title'] = '每日开机人数';
        $this->load->view('templates/header', $data);
        $this->load->view('watchrecord/amountbyday');
        $this->load->view('templates/footer');
    }

    public function bytime() {
        $data['time'] = $this->totalpeoplebytime();
        $data['title'] = '每时开机人数';
        $this->load->view('templates/header', $data);
        $this->load->view('watchrecord/amountbytime');
        $this->load->view('templates/footer');
    }

    public function byweek() {
        $options = $_GET;
        $data['time'] = $this->totalpeoplebyweek();
        $data['title'] = '每周开机人数';
        $this->load->view('templates/header', $data);
        $this->load->view('watchrecord/amountbyweek');
        $this->load->view('templates/footer');
    }

    public function bygender() {
        $data['days'] = $this->totalpeoplebydayandsex();
        $data['title'] = '按性别每日开机人数';
        $this->load->view('templates/header', $data);
        $this->load->view('watchrecord/amountbyday');
        $this->load->view('templates/footer');
    }

    public function byoptions() {
        ;
//        $incomegroup=$_GET['incomegroup'];
//        $age_low =$_GET['age-low'];
//        $age_high=$_GET['age-high'];
        $options = $_GET;

        $datas = $this->totalpeoplebydayandoptions($options);
        $result = array();
        foreach ($datas as $data) {
            $result[] = $data;
        }
        echo json_encode($result);

//        $data['title'] = '每日开机人数';
//        $this->load->view('templates/header', $data);
//        $this->load->view('watchrecord/amountbyday');
//        $this->load->view('templates/footer');
    }

    public function bytimeandoptions() {
        $options = $_GET;
        echo json_encode($this->totalpeoplebytime($options));
    }

    ////////////////////每时开机人数///////////////////////////////////////////////////////////////
    public function totalpeoplebytime($options = array()) {

        $peopleIdArray = array();
        $this->load->driver('cache');
        $is_cache_people_hour_per_day_json = $this->cache->file->get('people_hour_per_day');
        if (0) {
            $people_hour_per_day_json = $is_cache_people_hour_per_day_json;
        } else {
            $is_cache_people_begin_time_by_day = $this->cache->file->get('people_begin_time_by_day');
            if (0) {
                $people_begin_time_by_day = $is_cache_people_begin_time_by_day;
            } else {
                for ($i = 1; $i < 30; $i++) {
                    $people_ids = $this->watchrecord_model->get_amountBytime_2($i, $options); //得到一天之中开机的人的id
                    foreach ($people_ids as $k => $people_id) {
                        $peopleIdArray[$i][$people_id['WR_PplID']] = $this->watchrecord_model->get_open_time_by_day_and_people($i, $people_id['WR_PplID']);
                    }
                }
                $people_begin_time_by_day = json_encode($peopleIdArray);
                $this->cache->file->save('people_begin_time_by_day', $people_begin_time_by_day, 99999999);
            }
            $people_begin_time_by_day_array = json_decode($people_begin_time_by_day, true);
            $people_hour_per_day = array();
            foreach ($people_begin_time_by_day_array as $day => $people_ids) {
                $baseDayTime = strtotime('2011-03-02 00:00:00');
                $dayTime = $baseDayTime + $day * 60 * 60 * 24;
                $people_hour_per_day[] = $this->getPeopleOpenTimeByDay($dayTime, $people_ids);
            }
            $people_hour_per_day_json = json_encode($people_hour_per_day);
            $this->cache->file->save('people_hour_per_day', $people_hour_per_day_json, 99999999);
        }
        $people_hour_per_day_array = json_decode($people_hour_per_day_json, true);
        $people_hour_array = array();
        for ($i = 0; $i < 30; $i++) {
            for ($j = 0; $j < 24; $j++) {
                $people_hour_per_day_array[$i][$j] = isset($people_hour_per_day_array[$i][$j]) ? $people_hour_per_day_array[$i][$j] : 0;
                $people_hour_array[$j] = isset($people_hour_array[$j]) ? $people_hour_array[$j] + $people_hour_per_day_array[$i][$j] : $people_hour_per_day_array[$i][$j];
            }
        }


        return $people_hour_array;
    }

    public function getPeopleOpenTimeByDay($dayTime, $docs) {
        $result = array();
        foreach ($docs as $k => $doc) {
            $hour = floor(($doc[0]['WR_BeginTime'] - $dayTime) / (60 * 60 * 1.0));
            $result[$hour] = isset($result[$hour]) ? $result[$hour] + 1 : 1;
            ksort($result);
        }
        return $result;
    }

    public function totalpeoplebyweek($options = array(), $type = 1) {
        $options = $_GET;
        $days = $this->generateday(2011, 3, 5, 27);
        $result = array();
        foreach ($days as $day) {
            $daytime = strtotime($day);

            $result[date('w', $daytime)] = isset($result[date('w', $daytime)]) ? $result[date('w', $daytime)] + $this->watchrecord_model->get_amountBydayandoptions($daytime, $options) : $this->watchrecord_model->get_amountBydayandoptions($daytime, $options);
        }
        if ($type == 2) {

            echo json_encode($result);
        } else if ($type == 3) {
            return $result;
        } else 
            {           echo  json_encode($result);
        }
    }

    public function comparebyday() {
        $data['title'] = "每日开机对比";
        $this->load->view('templates/header', $data);
        $this->load->view('watchrecord/comparebyday');
        $this->load->view('templates/footer');
    }

    public function comparebytime() {
        $data['title'] = "每时开机对比";
        $this->load->view('templates/header', $data);
        $this->load->view('watchrecord/comparebytime');
        $this->load->view('templates/footer');
    }

    public function comparebydayandoptions() {
        $options = $_GET;
        $job = array();
        $Ppl_Sex = array();
        $results = array();
        $finalresults = array();
        foreach ($options as $key => $option) {

            $finaloption = array();
            foreach ($option as $opt) {
                if (!strrpos($opt['name'], '[]')) {
                    $finaloption[$opt['name']] = $opt['value'];
                }
                if (strrpos($opt['name'], 'Ppl_Sex') === 0) {

                    $Ppl_Sex[] = $opt['value'];
                    $finaloption['Ppl_Sex'] = $Ppl_Sex;
                }
                if (strrpos($opt['name'], 'job') === 0) {
                    $job[] = $opt['value'];
                    $finaloption['job'] = $job;
                }
            }

            $datas = $this->totalpeoplebydayandoptions($finaloption);
            $result = array();

            foreach ($datas as $data) {
                $result[] = $data;
            }
            $results["data"] = $result;
            $results["name"] = "曲线" . ($key + 1);
            $finalresults[] = $results;
        }



        echo json_encode($finalresults);
    }

    public function comparebytimeandoptions() {
        $options = $_GET;
        $job = array();
        $Ppl_Sex = array();
        $results = array();
        $finalresults = array();
        foreach ($options as $key => $option) {

            $finaloption = array();
            foreach ($option as $opt) {
                if (!strrpos($opt['name'], '[]')) {
                    $finaloption[$opt['name']] = $opt['value'];
                }
                if (strrpos($opt['name'], 'Ppl_Sex') === 0) {

                    $Ppl_Sex[] = $opt['value'];
                    $finaloption['Ppl_Sex'] = $Ppl_Sex;
                }
                if (strrpos($opt['name'], 'job') === 0) {
                    $job[] = $opt['value'];
                    $finaloption['job'] = $job;
                }
            }

            $datas = $this->totalpeoplebytime($finaloption);
            $result = array();

            foreach ($datas as $data) {
                $result[] = $data;
            }
            $results["data"] = $result;
            $results["name"] = "曲线" . ($key + 1);
            $finalresults[] = $results;
        }
        echo json_encode($finalresults);
    }

    public function epgstatics() {
        $options = $_GET;
        $job = array();
        $Ppl_Sex = array();
        $results = array();
        $finalresults = array();
        foreach ($options as $key => $option) {

            $finaloption = array();
            foreach ($option as $opt) {
                if (!strrpos($opt['name'], '[]')) {
                    $finaloption[$opt['name']] = $opt['value'];
                }
                if (strrpos($opt['name'], 'Ppl_Sex') === 0) {

                    $Ppl_Sex[] = $opt['value'];
                    $finaloption['Ppl_Sex'] = $Ppl_Sex;
                }
                if (strrpos($opt['name'], 'job') === 0) {
                    $job[] = $opt['value'];
                    $finaloption['job'] = $job;
                }
            }

            $channels = $this->watchrecord_model->get_wholechannel();
            $result = array();
        foreach ($channels as $channel) {
            
            $result[$channel["Chl_Des"]] = $this->watchrecord_model->get_peoplewatch_channel_time($finaloption, $channel["Chl_ID"]);
        };
            $tempresult = array();

            foreach ($result as $ke=>$result) {
                
                $tempresult[] = $result[0]["WR_Time"]/(60*60);
            }
            $results["data"] = $tempresult;
            $results["name"] = "条柱" . ($key + 1);
            $finalresults[] = $results;
        }
        echo json_encode($finalresults);
            
    }
    
       public function countwholechannel(){
       $channels = $this->watchrecord_model->get_wholechannel();
        foreach ($channels as $channel) {
            
             $wholeTime= $this->watchrecord_model->get_peoplewatch_channel_time($options=array(), $channel["Chl_ID"]);
        
              echo json_encode($wholeTime);
             $this->db->where('Chl_ID',$channel["Chl_ID"]);
            
             $object=array("Chl_WatchTime"=>$wholeTime[0]['WR_Time']);
             $this->db->update('channel', $object); 
        };
    }
    public  function get_max_people_bychannel($options=  array()){
             $channels = $this->watchrecord_model->get_wholechannel();
            $result = array();
        foreach ($channels as $channel) {
            
            $result[$channel["Chl_Des"]] = $this->watchrecord_model->get_peoplewatch_channel_time($options, $channel["Chl_ID"]);
        };
          $tempresult = array();

            foreach ($result as $ke=>$result) {
                
                $tempresult[$ke] = $result[0]["WR_Time"]/(60*60);
            }
            
           return array_search(max($tempresult),$tempresult);
        
    }
    
    public function epgrecomment(){
        $options = $_GET;
       echo $this->get_max_people_bychannel($options);
    }


    public function epgrecommentview(){
        
        $data["title"]="EPG广告投放建议";
        $this->load->view("templates/header",$data);
        $this->load->view("watchrecord/epgrecomment");
        $this->load->view("templates/footer");
    }
    
    public function epgview(){
        
        $data['channels']=array();
        $channels=$this->watchrecord_model->get_wholechannel();
        foreach ($channels as $channel){
          $data['channels'][]=$channel['Chl_Des'];
        }
        
        $data["title"]="EPG数据条形图";
        $this->load->view("templates/header",$data);
        $this->load->view("watchrecord/epgstatics");
        $this->load->view("templates/footer");
    }
    public function birthdaytoage() {
        $this->watchrecord_model->birthdaytoage();
    }

    public function callingtonum() {
        $this->watchrecord_model->callingtonumber();
    }

    public function incometonum() {
        $this->watchrecord_model->incometonumber();
    }

    public function openrecomment() {
        // $data['days'] = $this->open_recomment();
        $data['title'] = '开机广告推荐';
        $this->load->view('templates/header', $data);
        $this->load->view('watchrecord/openrecomment');
        $this->load->view('templates/footer');
    }

    function open_recomment() {

        $options = $_GET;
        $time_option_result_array = $this->totalpeoplebytime($options);
        $week_option_result_array = $this->totalpeoplebyweek($options, $type = 3);
        $time_result_array = array(104,5,3,1,12,20,140,236,121,85,58,94,159,47,42,47,52,92,86,87,64,42,32,11);
        $week_result_array = array(270, 168, 170, 138, 160, 176, 191);
        $option_people_num = $this->watchrecord_model->get_option_peoplenum($options);
        $max_option_week_pos = array_search(max($week_option_result_array), $week_option_result_array);
        $max_option_time_pos = array_search(max($time_option_result_array), $time_option_result_array);
        $max_option_week = array($max_option_week_pos => max($week_option_result_array));
        $max_option_time = array($max_option_time_pos => max($time_option_result_array));
        $week_support = $week_option_result_array[$max_option_week_pos] / $option_people_num;
        $week_confindence = $week_option_result_array[$max_option_week_pos] / $week_result_array[$max_option_week_pos];
        $time_support = $time_option_result_array[$max_option_time_pos] / $option_people_num;
        $time_confindence = $time_option_result_array[$max_option_time_pos] / $time_result_array[$max_option_time_pos];

        $result = array("best_week" => $max_option_week_pos, 'best_time' => $max_option_time_pos+1, 'week_support' => $week_support,
            'time_support' => $time_support, 'week_confindence' => $week_confindence, 'time_confindence' => $time_confindence);
//       echo $time_option_result_array[$max_option_time_pos];
//       echo $time_result_array[$max_option_time_pos];
        echo json_encode($result, JSON_FORCE_OBJECT);

//        echo max($time_option_result_array);
//        echo max($week_option_result_array);
//        echo var_dump(array_search(max($time_option_result_array), $time_option_result_array));
//        echo var_dump(array_search(max($week_option_result_array), $week_option_result_array));
//        echo max($week_result_array);  
//        echo array_search(max($week_result_array), $week_result_array);
//        echo json_encode($option_people_num);
    }
    

}

