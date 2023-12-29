<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
        
        /* COMMON :: ADMIN & PUBLIC */
        /* Load */
        $this->load->database();
        $this->load->add_package_path(APPPATH . 'third_party/ion_auth/');
        $this->load->config('common/dp_config');
        $this->load->config('common/dp_language');
        $this->load->library(array('form_validation', 'ion_auth', 'template', 'common/mobile_detect'));
        $this->load->helper(array('array', 'language', 'url'));
		$this->load->helper('file');
        $this->load->model('common/prefs_model');
		

        /* Data */
        $this->data['lang']           = element($this->config->item('language'), $this->config->item('language_abbr'));
        $this->data['charset']        = $this->config->item('charset');
        $this->data['frameworks_dir'] = $this->config->item('frameworks_dir');
        $this->data['plugins_dir']    = $this->config->item('plugins_dir');
        $this->data['avatar_dir']     = $this->config->item('avatar_dir');

        /* Any mobile device (phones or tablets) */
        if ($this->mobile_detect->isMobile())
        {
            $this->data['mobile'] = TRUE;

            if ($this->mobile_detect->isiOS()){
                $this->data['ios']     = TRUE;
                $this->data['android'] = FALSE;
            }
            else if ($this->mobile_detect->isAndroidOS())
            {
                $this->data['ios']     = FALSE;
                $this->data['android'] = TRUE;
            }
            else
            {
                $this->data['ios']     = FALSE;
                $this->data['android'] = FALSE;
            }

            if ($this->mobile_detect->getBrowsers('IE')){
                $this->data['mobile_ie'] = TRUE;
            }
            else
            {
                $this->data['mobile_ie'] = FALSE;
            }
        }
        else
        {
            $this->data['mobile']    = FALSE;
            $this->data['ios']       = FALSE;
            $this->data['android']   = FALSE;
            $this->data['mobile_ie'] = FALSE;
        }
	}
}

class G_Controller extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();

        /* COMMON API For Footer, Ticker, Calculator, Gainer and Looser Page */
		//json file save code start
		 $filename=FCPATH . 'upload/json/common.json';
		 $create_time=date ("Y-m-d H:i:s", filemtime($filename));
		 $current_time=date ("Y-m-d H:i:s");
		 $to_time = strtotime($current_time);
		 $from_time = strtotime($create_time);
		 $duration= round(abs($to_time - $from_time) / 60,2);
		 if($duration<=10)
		 $api_results = file_get_contents($filename, true);
	     else
		 {	
			$url  = 'https://api.coincap.io/v2/assets?limit=2000'; // path to your JSON file
	        $api_results  = $this->request($url);
	        $file = fopen(FCPATH.'upload/json/common.json','w');
            fwrite($file, $api_results);
            fclose($file);
		 }
			
		
		// json file save code end`
		
		
        $coinMarketData         = json_decode($api_results);
        
        /* For Calculator, Top Gainer & Looser Page */
        $data['coinListtData'] =$coinMarketData;
        
	   //loop listing into coin elements
        setlocale(LC_MONETARY, "en_US");
        foreach ($coinMarketData->data as $res) {
            $coinRank[]            = $res->rank;
            $coinName[]            = $res->name;
            $coinPrice[]           = $res->priceUsd;
            $coinId[]              = $res->id;
            $coinCode[]            = strtoupper($res->symbol);
            $coinChange24[]        = $res->changePercent24Hr;
            $coinChange24Sort[]    = $res->changePercent24Hr;
            $coinChange24DesSort[] = $res->changePercent24Hr;
            $coinMkcap[]           = $res->marketCapUsd;
            $coinSupply[]          = $res->supply;
            $coinUsdVolume[]       = $res->volumeUsd24Hr;
            if($res->symbol=='BTC')
			$data['btcCap']= $res->marketCapUsd;
		    if($res->symbol=='ETH')
			$data['ethCap']= $res->marketCapUsd;
        }
        $data['coinRank']      = $coinRank;
        $data['coinName']      = $coinName;
        $data['coinPrice']     = $coinPrice;
        $data['coinId']        = $coinId;
        $data['coinCode']      = $coinCode;
        $data['coinChange24']  = $coinChange24;
        $data['coinMkcap']     = $coinMkcap;
        $data['coinSupply']    = $coinSupply;
        $data['coinUsdVolume'] = $coinUsdVolume;
        
        //sort coin elements and assign into variable for top gainer and top loser
        arsort($coinChange24DesSort);
        asort($coinChange24Sort);
        
        $data['coinChange24Sort']    = $coinChange24Sort;
        $data['coinChange24DesSort'] = $coinChange24DesSort;
        
        $data['totalCap']= array_sum($coinMkcap);
		$data['totalvol']= array_sum($coinUsdVolume);
		$data['coinTotal']= count($coinMarketData->data);
		
        /* For News Data */
		//json file save code start
         $filename=FCPATH . 'upload/json/news.json';
		 $create_time=date ("Y-m-d H:i:s", filemtime($filename));
		 $current_time=date ("Y-m-d H:i:s");
		 $to_time = strtotime($current_time);
		 $from_time = strtotime($create_time);
		 $duration= round(abs($to_time - $from_time) / 60,2);
		 if($duration<=60)
		 $news_results = file_get_contents($filename, true);
	     else
		 {		
            $xml_string = 'https://cointelegraph.com/feed';
            $xml = file_get_contents($xml_string);
            $xml =simplexml_load_string($xml, "SimpleXMLElement", LIBXML_NOCDATA);
            $news_results = json_encode($xml);
            $file = fopen(FCPATH.'upload/json/news.json','w');
            fwrite($file, $news_results);
            fclose($file);
		 }
		 
        $data['newsData']         = json_decode($news_results);
        
        
        //Currency Switcher
        
         $filename=FCPATH . 'upload/json/rates.json';
		 $create_time=date ("Y-m-d H:i:s", filemtime($filename));
		 $current_time=date ("Y-m-d H:i:s");
		 $to_time = strtotime($current_time);
		 $from_time = strtotime($create_time);
		 $duration= round(abs($to_time - $from_time) / 60,2);
		 if($duration<=180)
		 $rates_results = file_get_contents($filename, true);
	     else
		 {		
		$rates_url  = 'https://api.coincap.io/v2/rates'; // path to your JSON file
	    $rates_results  = $this->request($rates_url);
	    $file = fopen(FCPATH.'upload/json/rates.json','w');
         fwrite($file, $rates_results);
         fclose($file);
		 }
        $data['rateData']         = json_decode($rates_results);
        $data['priceData']         = json_decode($rates_results);
		
		//set curreny conversion parameter
		if($this->session->userdata('convert_rate'))
		{
			$convertRate=$this->session->userdata('convert_rate');
		}
		else
		{
			$convertRate=1;
			
		}
		$data['convertRate']=$convertRate;
		
		if($this->session->userdata('convert_symbol'))
		{
			$convertSymbol=$this->session->userdata('convert_symbol');
		}
		else
		{
			$convertSymbol='$ USD';
			
		}
		
		$data['convertSymbol']=$convertSymbol;

		//end
        
        $this->load->vars($data);
	}
}

class Admin_Controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

        if ( ! $this->ion_auth->logged_in() OR ! $this->ion_auth->is_admin())
        {
            redirect('auth/login', 'refresh');
        }
        else
        {
            /* Load */
            $this->load->config('admin/dp_config');
            $this->load->library('admin/page_title');
            $this->load->library('admin/breadcrumbs');
            $this->load->model('admin/core_model');
            $this->load->helper('menu');
            $this->lang->load(array('admin/main_header', 'admin/main_sidebar', 'admin/footer', 'admin/actions'));

            /* Load library function  */
            $this->breadcrumbs->unshift(0, $this->lang->line('menu_dashboard'), 'admin/dashboard');

            /* Data */
            $this->data['title']       = $this->config->item('title');
            $this->data['title_lg']    = $this->config->item('title_lg');
            $this->data['title_mini']  = $this->config->item('title_mini');
            $this->data['admin_prefs'] = $this->prefs_model->admin_prefs();
            $this->data['user_login']  = $this->prefs_model->user_info_login($this->ion_auth->user()->row()->id);

            if ($this->router->fetch_class() == 'dashboard')
            {
                $this->data['dashboard_alert_file_install'] = $this->core_model->get_file_install();
                $this->data['header_alert_file_install']    = NULL;
            }
            else
            {
                $this->data['dashboard_alert_file_install'] = NULL;
                $this->data['header_alert_file_install']    = NULL; /* << A MODIFIER !!! */
            }
        }
    }
}


class Public_Controller extends MY_Controller
{
	public function __construct()
	{
		parent::__construct();

        if ($this->ion_auth->logged_in() && $this->ion_auth->is_admin())
        {
            $this->data['admin_link'] = TRUE;
        }
        else
        {
            $this->data['admin_link'] = FALSE;
        }

        if ($this->ion_auth->logged_in())
        {
            $this->data['logout_link'] = TRUE;
        }
        else
        {
            $this->data['logout_link'] = FALSE;
        }
	}
}
