<?php $this->load->view('include/header'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/2.0.3/socket.io.js" ></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"  ></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap4.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap4.min.css"/>
       <script type="text/javascript">
	$(document).ready(function () {
	    $.noConflict();
    $('#coins-info-table').DataTable({
        	"oLanguage": {
			"sProcessing": "Loading Coins..."
				},
			processing: true,
			iDisplayLength: 50,
			ajax: "<?php echo base_url()?>home/coindata",
			bServerSide: false,
			bDeferRender: true,
			bInfo: false,
			bPaginate:true,
			columns: [
			{ data: '#' },
			{ data: 'Name' },
			{ data: 'Price','render': function (coinprice) {  
			    var cprice = coinprice/<?php echo $convertRate;?>;
			    return '<span class="price">' + '<?php echo strtok($convertSymbol, " ");?>' + custom_prc_format(cprice) + '</span>';
                        } },
			{ data: 'Market Cap', 'render': function (mcap) {  
			    var marketcap = mcap/<?php echo $convertRate;?>;
                            return '<?php echo strtok($convertSymbol, " ");?>' + formatCash(marketcap);  
                        }   } ,
			{ data: 'Available Supply' },
			{ data: 'Volume 24(H)','render': function (vol) {  
			    var volume = vol/<?php echo $convertRate;?>;
                return '<?php echo strtok($convertSymbol, " ");?>' + formatCash(volume);
                        } },
		    { data: 'Change 24(H)' }
		]
		});
		} );
		const formatCash = n => {
            if (n < 1e3) return n;
            if (n >= 1e3 && n < 1e6) return +(n / 1e3).toFixed(2) + "K";
            if (n >= 1e6 && n < 1e9) return +(n / 1e6).toFixed(2) + "M";
            if (n >= 1e9 && n < 1e12) return +(n / 1e9).toFixed(2) + "B";
            if (n >= 1e12) return +(n / 1e12).toFixed(2) + "T";
};
	function custom_prc_format($n) {
        if ($n >= 1) {
        $n_format = $n.toFixed(2);
        } else if ($n >= 0.1 && $n < 1) {
        $n_format = $n.toFixed(3);
        } else if ($n >= 0.01 && $n < 0.1) {
        $n_format = $n.toFixed(4);
        } else if ($n >= 0.001 && $n < 0.01) {
        $n_format = $n.toFixed(6);
        } else if ($n >= 0.0001 && $n < 0.001) {
        $n_format = $n.toFixed(8);
        }
        else {
        $n_format = $n.toFixed(10);
    }
			return $n_format;
		}
	</script>
<?php
	function custom_number_format($n, $precision = 2) {
        if ($n < 100000) {
        // Default
         $n_format = number_format($n);
        } else if ($n < 9000000) {
        // Thousand
        $n_format = number_format($n / 1000, $precision, '.', ''). 'K';
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
	function custom_prc_format($n) {
        if ($n >= 1) {
        $n_format = number_format($n, 2);
        } else if ($n >= 0.1 && $n < 1) {
        $n_format = number_format($n, 3);
        } else if ($n >= 0.01 && $n < 0.1) {
        $n_format = number_format($n, 4);
        } else if ($n >= 0.001 && $n < 0.01) {
        $n_format = number_format($n, 6);
        } else if ($n >= 0.0001 && $n < 0.001) {
        $n_format = number_format($n, 8);
        }
        else {
        $n_format = number_format($n, 10);
    }
			return $n_format;
		}
?>
<div class="page-title py-3">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 text-center">
        <h1>
          <?php echo $pageData[0]['home_title']?>
        </h1>
        <h6 class="pb-2">
          <?php echo $pageData[0]['description']?>
        </h6>
        <div class="pb-3">
        <a target = '_blank' href="<?php echo $settingData[0]['buy_sell'] ?>" class="btn btn-outline-dark btn-lg">
            Start Crypto Trading
        </a>
        </div>
      </div>
    </div>        
  </div>    
</div>

<div class="container pt-5 pb-4 text-center">
    <h4 class="pb-3"><i class="fa fa-line-chart"></i> Top Coins</h4>
		 <?php
             setlocale(LC_MONETARY,"en_US");
             $i=0;
             foreach ($coinHomeData->data as $res)
				{
				    if($i==7) continue; 
				    $ex_code=$res->id;
			        $img_src=base_url().'assets/images/coins/'.$ex_code.'.png';
					 ?>
					 
	<a href="<?php echo base_url() ?>coin/<?php echo $res->id; ?>">
    <span class="badge badge-pill trending">  <img src="<?php echo $img_src; ?>" width="25px"/> <?php echo $res->name;?> <span class="badge badge-warning"><?php echo $res->symbol;?></span></span>
</a>
	<?php
	++$i;
		}
				?>
		</div>
		
<!-- Ad Code Top  -->
  <div class="py-4">
  <?php if($ads[0]['pref']==0 || $ads[0]['pref']==2) { ?>
  <div class="container">
    <div class="row justify-content-center">
       <?php echo  $ads[0]['header_ads']?>
    </div>    
  </div>
  <?php } ?>
  </div>
<!-- End Ad Code Top  -->
<!-- Data Table  -->


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 text-left">
            <h3>Cryptocurrency Prices by Market Cap</h3>
            <p>The worldwide cryptocurrency market cap today is <span class="font-weight-bold"><?php echo strtok($convertSymbol, " ");?><?php echo custom_number_format($totalCap/$convertRate);?></span>. The total crypto trading volume in the last 24 hours is <span class="font-weight-bold"><?php echo strtok($convertSymbol, " ");?><?php echo custom_number_format($totalvol/$convertRate);?></span>. Bitcoin dominance is at <span class="font-weight-bold"><?php echo number_format($btcCap/$totalCap*100, 1);?>%</span> with a market cap of <span class="font-weight-bold"><?php echo strtok($convertSymbol, " ");?><?php echo custom_number_format($btcCap/$convertRate);?></span> and Ethereum dominance is at <span class="font-weight-bold"><?php echo number_format($ethCap/$totalCap*100, 1);?>%</span> with a market cap of <span class="font-weight-bold"><?php echo strtok($convertSymbol, " ");?><?php echo custom_number_format($ethCap/$convertRate);?></span>. The ranks of the coins are based on marketcap, trading volume, and prices.</p>
<table id="coins-info-table" class="table table-striped table-bordered dt-responsive wrap" cellspacing="0" width="100%">
			<thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Price</th>
                <th>Market Cap</th>
                <th>Available Supply</th>
                <th>Volume (24H)</th>
                <th>Change (24H)</th>
            </tr>
			</thead>
		   </table>  
			
        </div>        
    </div>    
</div>
<!-- End Data Table  -->
<!-- Ad Code Bottom  -->
	<div class="py-4">
	<?php if($ads[0]['pref']==1 || $ads[0]['pref']==2) { ?>
		<div class="container">
			<div class="row justify-content-center">
				<?php echo  $ads[0]['footer_ads']?>
			</div>    
		</div>
	<?php } ?>
	</div>
<!-- End Ad Code Bottom  -->

<!-- News Section Start  -->
<div class="container pt-3 pb-5">
<h2 class="pb-2">Cryptocurrency Latest News & Updates</h2>
<div class="card-deck">
   <?php
   $i=1;
             setlocale(LC_MONETARY,"en_US");
             foreach ($newsData->channel->item as $res)
				{
				    if($i>3)
				    continue; 
					 ?>
<div style="padding-left:0px;padding-right:0px;" class="col-md-4">
<div style="margin-bottom:20px;padding-left:0px;padding-right:0px;min-height:500px;" class="card">
<img src="<?php echo $res->enclosure->{"@attributes"}->url;?>" class="card-img-left">
<div class="card-body">
<span class="badge linking"> <?php echo substr($res->pubDate, 0, 16);?> </span>
<h6 class="card-title"><?php echo $res->title;?></h6>
<p><?php echo strip_tags(substr($res->description, 0, 450));?>...</p>
<a href="<?php echo $res->link;?>" class="btn btn-warning" target="_blank">Read More</a>
</div></div></div>
	<?php
	++$i;
		}
				?>
</div>  
<a href="<?php echo base_url(); ?>news" class="btn btn-warning btn-block">View More</a>
</div>  
<!-- News Section End  -->

<!-- Donation Box  -->
<?php $this->load->view('include/donation'); ?>
<!-- End Donation Box  -->
<script type="text/javascript">
		var formatter = new Intl.NumberFormat('en-US', {
			style: 'currency',
			currency: "<?php echo substr($convertSymbol, strrpos($convertSymbol, ' ') + 1);?>",
			minimumFractionDigits: 2,
		});
		const pricesWs=new WebSocket('wss://ws.coincap.io/prices?assets=ALL');
		pricesWs.onmessage=function(msg){
		var sdata=JSON.parse(msg.data);
		for(var indexkey in sdata){
			
			if(sdata.hasOwnProperty(indexkey)){
			var coin = 'BTC_' + indexkey;	
			var _coinTable = $('#coins-info-table');
            var row = _coinTable.find("tr#" + coin);
            price = _coinTable.find("tr#" + coin + " .price");
            _price = formatter.format(sdata[indexkey]/<?php echo $convertRate;?>);
            var c = _price.substr(_price.length-5);
            if(c=='00000')
			_price=_price.substr(0, _price.length-5);
             previous_price = $(price).data('usd');
              $(price).html(_price);
            _class = previous_price < _price  ? 'increment' : 'decrement';
            if (_price >= previous_price) {
                $(price).html(_price).removeClass().addClass(_class + ' price').data("usd", _price);
            } else {
                $(price).html(_price).removeClass().addClass(_class + ' price').data("usd", _price);
            }
             if (_price !== previous_price) {
                _class = previous_price < _price ? 'increment' : 'decrement';
                $(row).addClass(_class);
                setTimeout(function () {
                    $(row).removeClass('increment decrement');
                }, 300);
            }
             
            } 
             
		}}
		</script>
<script src="<?php echo base_url(); ?>assets/js/front/jquery-3.3.1.slim.min.js"></script>
<?php $this->load->view('include/footer'); ?>