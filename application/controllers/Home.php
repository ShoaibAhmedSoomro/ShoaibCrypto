<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Home extends G_Controller
{
    public function __construct()
    {
        parent::__construct();
		$this->load->library('session');
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
        $data['pageTitle']       = $data['pageData'][0]['meta_title'];
        $data['pageDescription'] = $data['pageData'][0]['meta_description'];
		
		//table data code start
	
		$url = file_get_contents(FCPATH . 'upload/json/common.json'); // path to your JSON file
		$data['coinHomeData']   = json_decode($url);
		//end
		
        $this->load->view('home', $data);
    }
    
    /* function for coin detail page */
    public function coin()
    {
        //coin single page
        $coin           = $this->uri->segment(2); //get coin name from url
        $data['coin']       = $coin;
        $url = file_get_contents(FCPATH . 'upload/json/common.json'); // path to your JSON file
        $data['coinData']              = json_decode($url);
        
        $data['settingData']           = $this->home_model->list_data('settings');
        $data['pageData']              = $this->home_model->list_data('cms');
        $data['donations']             = $this->home_model->list_data('donation');
        $data['ads']                   = $this->home_model->list_data('ads');
        $data['call2Action']           = $this->home_model->list_data('call2action');

        $data['pageTitle']             = ucwords(str_replace('-', ' ', $data['coin'])) . ' Live Price, MarketCap & Info';
        $data['pageDescription']       = 'Live ' . ucwords(str_replace('-', ' ', $data['coin'])) . ' prices, market Capitalization, historical data chart, volume & supply. Stay up to date with the latest ' . ucwords(str_replace('-', ' ', $data['coin'])) . ' info & markets data. Check our coins stats data to see when there is an opportunity to buy or sell ' . ucwords(str_replace('-', ' ', $data['coin'])). ' at best price.';
		
		
		$murl = 'https://api.coincap.io/v2/assets/'.$coin.'/markets?limit=250'; // path to your JSON file
		$api_results  = $this->request($murl);
        $data['coinmData']  = json_decode($api_results);
        
		
		$this->load->view('coin', $data);
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
	 
	 public function set_rate()
	 {
		 $rate=$this->input->post('rate');
		 $this->session->set_userdata('convert_rate', $rate);
		
		 
		 $symbol=$this->input->post('symbol');
		 $this->session->set_userdata('convert_symbol', $symbol);
	 }
	 
	  public function coindata()
	{
	    
		$url = file_get_contents(FCPATH . 'upload/json/common.json'); // path to your JSON file
		$coinMarketData = json_decode($url); 
		foreach($coinMarketData->data as $res)
        {
            $coin_display_name = (strlen($res->name) > 30) ? substr($res->name,0,27).'...' : $res->name;    			
			$coin_name=$res->id;
			$coin_code=strtolower(str_replace([' ','.','(',')','[',']','/','#'],'-',$res->name));

		    $img_src=base_url().'assets/images/coins/'.$coin_name.'.png';
			$file_path=FCPATH.'assets/images/coins/'.$coin_name.'.png';
			if (!file_exists($file_path)) $img_src=base_url().'assets/images/default.png';
			
			$row = array();
			$row['#'] = $res->rank;
            $row['Name'] = '<img src="'.$img_src.'"><a href="'.base_url().'coin/'.$coin_name.'"><span class="coin-name">'.$coin_display_name.'</span></a> <span class="badge badge-warning">'.$res->symbol.'</span>';
			$row['Price'] = $res->priceUsd;
            $row['Market Cap'] = $res->marketCapUsd;
            $row['Available Supply'] = $this->custom_number_format($res->supply).' '.$res->symbol ;
            $row['Volume 24(H)'] = $res->volumeUsd24Hr;
			if($res->changePercent24Hr>0)
            $row['Change 24(H)'] = '<span class="p-up"><i class="fa fa-caret-up"></i> '.round($res->changePercent24Hr,2).'%</span>';
			else
			$row['Change 24(H)'] = '<span class="p-down"><i class="fa fa-caret-down"></i> '.round($res->changePercent24Hr,2).'%</span>';	
           // $row['DT_RowId'] = "BTC_".$res->symbol;
		    $row['DT_RowId'] = "BTC_".strtolower($res->name);
            $data[] = $row;
		}
		$results = array(
		"draw" => 1,
		"recordsTotal" => count($data),
		"recordsFiltered" => count($data),
		"data"=>$data);
		echo json_encode($results);
		exit;
	}
	/* this function used to convert price to Trillion/Billion/Million/Thousand */
	public function custom_number_format($n, $precision = 2) {
        if ($n < 100000) {
        // Default
         $n_format = number_format($n);
        } else if ($n < 9000000) {
        // Thousand
        $n_format = number_format($n / 1000, $precision). 'K';
        } else if ($n < 900000000) {
        // Million
        $n_format = number_format($n / 1000000, $precision). 'M';
        } else if ($n < 900000000000) {
        // Billion
        $n_format = number_format($n / 1000000000, $precision). 'B';
        } else {
        // Trillion
        $n_format = number_format($n / 1000000000000, $precision). 'T';
    }
    return $n_format;
		}
}