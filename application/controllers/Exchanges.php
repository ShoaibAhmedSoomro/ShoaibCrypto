<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Exchanges extends G_Controller
{
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('public/home_model');
        
    }
    
    /**
     * Index Page for this controller.
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     */
    
    public function index()
    {
	    $data['donations']       = $this->home_model->list_data('donation');
        $data['settingData']     = $this->home_model->list_data('settings');
        $data['pageData']        = $this->home_model->list_data('cms');
        $data['ads']             = $this->home_model->list_data('ads');
        $data['call2Action']     = $this->home_model->list_data('call2action');
        
        $data['pageTitle']       = 'Top Cryptocurrency Exchanges List | '. $data['pageData'][0]['meta_title'] .'';
        $data['pageDescription'] = 'List of top crypto exchanges ranked by 24 hours trading volume. View cryptourrency exchanges market data, info, trading pairs and information.';
		
		$filename=FCPATH . 'upload/json/exchange.json';
		$create_time=date ("Y-m-d H:i:s", filemtime($filename));
		$current_time=date ("Y-m-d H:i:s");
		$to_time = strtotime($current_time);
		$from_time = strtotime($create_time);
		$duration= round(abs($to_time - $from_time) / 60,2);
		if($duration<=10)
		$exchanges_results = file_get_contents($filename, true);
	    else
		 {	
			$url  = 'https://api.coincap.io/v2/exchanges?limit=1000'; // path to your JSON file
	        $exchanges_results  = $this->request($url);
	        $file = fopen(FCPATH.'upload/json/exchange.json','w');
            fwrite($file, $exchanges_results);
            fclose($file);
		 }
		
		$data['coinExchangesData']   = json_decode($exchanges_results);
		
        $this->load->view('exchanges/index', $data);
    }
  
    /* function for exchange detail page */
    public function detail()
    {
        $exchange       = strtolower($this->uri->segment(2)); //
        $data['exchange']       = $exchange;
        $url = file_get_contents(FCPATH . 'upload/json/exchange.json'); // path to your JSON file
        $data['exchangeData'] = json_decode($url);
        
        setlocale(LC_MONETARY, "en_US");
        foreach ($data['exchangeData']->data as $res) {
            if($res->exchangeId==$exchange)
			$data['ename']=$res->name;
        }
        
        $data['settingData']           = $this->home_model->list_data('settings');
        $data['pageData']              = $this->home_model->list_data('cms');
        $data['donations']             = $this->home_model->list_data('donation');
        $data['ads']                   = $this->home_model->list_data('ads');
        $data['call2Action']           = $this->home_model->list_data('call2action');

        $data['pageTitle']             = $data['ename'] . ' Markets, Trade Volume, Pairs & Info';
        $data['pageDescription']       = 'Checkout ' . $data['ename'] . ' 24 hours trading volume & pairs info. Stay up to date with the latest crypto trading price movements on ' . $data['ename'] . ' exchange.';
       
        $eurl = 'https://api.coincap.io/v2/markets?exchangeId='.$exchange.'&limit=250'; // path to your JSON file
	    $api_results  = $this->request($eurl);
        $data['exchangemData']  = json_decode($api_results);
        
		$this->load->view('exchanges/exchange', $data);
    }
    
    //curl call function 
    public function request($url)
     {


        $curl = curl_init();

         curl_setopt_array($curl, array(
		 CURLOPT_URL => $url,
         CURLOPT_RETURNTRANSFER => true,
         CURLOPT_ENCODING => "",
         CURLOPT_MAXREDIRS => 10,
         CURLOPT_TIMEOUT => 0,
         CURLOPT_FOLLOWLOCATION => false,
         CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
         CURLOPT_CUSTOMREQUEST => "GET",
          ));

        $response = curl_exec($curl);
		$err = curl_error($curl);

		curl_close($curl);

	if ($err) {
        return "cURL Error #:" . $err;
	} else {
       return $response;
      }

     }

}