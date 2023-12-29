<?php $this->load->view('include/header'); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"  ></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap4.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap4.min.css"/>
<?php setlocale(LC_MONETARY,"en_US"); ?>
<?php
	function custom_number_format($n, $precision = 2) {
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
 <?php foreach ($coinData->data as $res) { if($res->id == $coin) $coinname = $res->name;}
       foreach ($coinData->data as $res) {  if($res->id == $coin) $coinsymbol = $res->symbol;}
       foreach ($coinData->data as $res) { if($res->id == $coin) $coinprice = $res->priceUsd;}
       foreach ($coinData->data as $res) { if($res->id == $coin) $coinmcap = $res->marketCapUsd;}
       foreach ($coinData->data as $res) { if($res->id == $coin) $coinrank = $res->rank;}
       foreach ($coinData->data as $res) { if($res->id == $coin) $coinsupply = $res->supply;}
       foreach ($coinData->data as $res) { if($res->id == $coin) $coinmsupply = $res->maxSupply;}
       foreach ($coinData->data as $res) { if($res->id == $coin) $coinvolume = $res->volumeUsd24Hr;} 
       foreach ($coinData->data as $res) { if($res->id == $coin) $coinchange = $res->changePercent24Hr;}
       foreach ($coinData->data as $res) { if($res->id == $coin) $coinurl = $res->explorer;}
       foreach ($coinData->data as $res) { if($res->id == $coin) $coinvwap = $res->vwap24Hr;}
       foreach ($coinData->data as $res) { if($res->id == $coin) $coinid = $res->id;}?>
                <div class="page-title py-3">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-12 text-left">
                                <h1><?php echo $coinname;?> Live Price Update & Market Capitalization</h1>
                           </div>
                        </div>        
                    </div>    
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
        <!-- Coin Data  -->
        <?php  $img_src=base_url().'assets/images/coins/'.$coinid.'.png';
			$file_path=FCPATH.'assets/images/coins/'.$coinid.'.png';
			if (!file_exists($file_path)) $img_src=base_url().'assets/images/default.png';
			?>
        <div class="container">
			<div class="media">
			  <img class="mr-3" src="<?php echo $img_src ?>">
			    <div class="align-self-center media-body">
				  <h2 class="font-weight-bold" style="margin-bottom:5px;"><?php echo $coinname;?> <span class="badge badge-secondary align-middle" style="margin-top:-0.3em;" id="bitcode"><?php echo strtoupper($coinsymbol);?></span> <span class="badge badge-success align-middle" style="margin-top:-0.3em;">Rank <?php if(isset($coinrank)) echo '#'.$coinrank; else echo 'N/A';?></span></h2>
 				  <h1 style="margin-bottom:0;"><span id="coin_price"><?php echo strtok($convertSymbol, " ");?><?php echo custom_prc_format($coinprice/$convertRate); ?></span> <small><span class="p-<?php echo $coinchange > 0 ? 'up':'down'?>"><i class="fa fa-caret-<?php echo $coinchange > 0 ? 'up':'down'?>"></i> <?php echo str_replace('-','',round($coinchange,2))?>%</span></small></h1>
				</div>
			</div>
	<div class="container"><div class="row pt-4">
<?php if ($coinurl != "") { ?>		
<a href="<?php echo $coinurl; ?>" target="_blank"><span class="badge linking"><i class="fa fa-globe"></i> <?php echo $coinname;?> Explorer <i class="fa fa-external-link"></i></span></a>
<?php } ?>
</div></div>
			
				<div class="pt-3 pb-2">
					<h4><i class="fa fa-eye"></i> Market Overview</h4>
					<p><span class="font-weight-bold"><?php echo $coinname;?></span> current market price is <span class="font-weight-bold" id="price_coin"><?php echo strtok($convertSymbol, " ");?><?php echo custom_prc_format($coinprice/$convertRate);?></span> with a 24 hour trading volume of <span class="font-weight-bold"><?php echo strtok($convertSymbol, " ");?><?php echo custom_number_format($coinvolume/$convertRate);?></span>. The total available supply of <span class="font-weight-bold"><?php echo $coinname;?></span> is <span class="font-weight-bold"><?php echo custom_number_format($coinsupply); ?> <?php echo strtoupper($coinsymbol);?></span><?php if(isset($coinmsupply)) echo " with a maximum supply of "."<b>".custom_number_format($coinmsupply)." ".strtoupper($coinsymbol)."</b>"; else echo '';?>. It has secured <span class="font-weight-bold">Rank <?php if(isset($coinrank)) echo $coinrank; else echo '(Not Available)';?></span> in the cryptocurrency market with a marketcap of <span class="font-weight-bold"><?php echo strtok($convertSymbol, " ");?><?php echo custom_number_format($coinmcap/$convertRate);?></span>. The <span class="font-weight-bold"><?php echo strtoupper($coinsymbol);?></span> price is <i class="fa fa-caret-<?php echo $coinchange > 0 ? 'up':'down'?>"></i><span class="font-weight-bold"><?php echo str_replace('-','',round($coinchange,2));?>%</span> <?php if($coinchange > 0) echo 'up'; else echo 'down';?> in the last 24 hours.</p>
					<hr>
					<p>The volume-weighted average price of the <span class="font-weight-bold"><?php echo $coinname;?></span> is <span class="font-weight-bold"><?php echo strtok($convertSymbol, " ");?><?php echo custom_prc_format($coinvwap/$convertRate); ?></span> in the last 24 hours. Live <span class="font-weight-bold"><?php echo $coinData->name;?></span> prices from all markets and <span class="font-weight-bold"><?php echo strtoupper($coinData->symbol);?></span> coin market Capitalization. Stay up to date with the latest <span class="font-weight-bold"><?php echo $coinData->name;?></span> price movements. Check our coin stats data and see when there is an opportunity to buy or sell <span class="font-weight-bold"><?php echo $coinData->name;?></span> at best price in the market.</p>
				</div>
		<div class="row">
			<div class="col-sm">
				<a target = '_blank' href="<?php echo $settingData[0]['buy_sell'] ?>" class="btn btn-dark btn-block mb-1"><i class="fa fa-cart-plus"></i> Buy <?php echo $coinname;?> (<?php echo strtoupper($coinsymbol);?>)</a>
			</div>
			<div class="col-sm">
			<a target = '_blank' href="<?php echo $settingData[0]['buy_sell'] ?>" class="btn btn-warning btn-block"><i class="fa fa-cart-arrow-down"></i> Sell <?php echo $coinname;?> (<?php echo strtoupper($coinsymbol);?>)</a>
			</div>
		</div>
		<div class="pt-4">
			<div class="card-deck">
			    			<div class="card bg-light">
    			<div class="card-body">
      				<h6 class="card-title"><?php echo $coinname;?> Rank</h6>
      				<p class="card-text"><?php if(isset($coinrank)) echo $coinrank; else echo '(Not Available)';?> </p>
    			</div>
			</div>
			<div class="card bg-light">
    			<div class="card-body">
      				<h6 class="card-title"><?php echo $coinname;?> Price</h6>
      				<p class="card-text"><?php echo strtok($convertSymbol, " ");?><?php echo custom_prc_format($coinprice/$convertRate);?></p>
    			</div>
			</div>
				<div class="card bg-light">
					<div class="card-body">
						<h6 class="card-title">VWAP (24h)</h6>
						<p class="card-text"><?php if(isset($coinvwap)) echo strtok($convertSymbol, " ").custom_prc_format($coinvwap/$convertRate); else echo '(Not Available)'?></p>
					</div>
				</div>
      		<div class="card bg-light">
    			<div class="card-body">
      				<h6 class="card-title">Price Change (24h)</h6>
      				<p class="card-text"><span class="p-<?php echo $coinchange > 0 ? 'up':'down'?>"><i class="fa fa-caret-<?php echo $coinchange > 0 ? 'up':'down'?>"></i> <?php echo str_replace('-','',round($coinchange,2));?>%</span></p>
    			</div>
			</div>

			</div>
		</div>
<div class="card-space"></div>
		<div class="pb-3">
			<div class="card-deck">
			<div class="card bg-light">
    			<div class="card-body">
      				<h6 class="card-title">Market Cap</h6>
      				<p class="card-text"><?php echo strtok($convertSymbol, " ");?><?php echo custom_number_format($coinmcap/$convertRate);?> </p>
    			</div>
			</div>

      		<div class="card bg-light">
    			<div class="card-body">
      				<h6 class="card-title">Trading Volume (24H)</h6>
      				<p class="card-text"><?php echo strtok($convertSymbol, " ");?><?php echo custom_number_format($coinvolume/$convertRate);?></p>
    			</div>
			</div>
      		<div class="card bg-light">
    			<div class="card-body">
      				<h6 class="card-title">Circulating Supply</h6>
      				<p class="card-text"><?php echo custom_number_format($coinsupply); ?> <?php echo strtoupper($coinsymbol); ?></p>
    			</div>
			</div>
			<div class="card bg-light">
    			<div class="card-body">
      				<h6 class="card-title">Max Supply</h6>
      				<p class="card-text"><?php if(isset($coinmsupply)) echo custom_number_format($coinmsupply)." ".strtoupper($coinsymbol); else echo '(Not Available)';?></p>
    			</div>
			</div>
			</div>
		</div>
		
		<!-- Calculator  -->
		 <h4 class="pt-3 pb-2"><i class="fa fa-calculator"></i> Cryptocurrency <?php echo $coinname;?> Calculator</h4>
		 <div class="container bg-donation pt-4 pb-3 px-4">
   
 <div class="row">
<div class="col-md-6 mb-3">
 <input type="number" class="form-control" id="from_ammount" placeholder="Enter Amount To Convert" value=10 />
 </div>
 <div class="col-md-6 mb-3">
     <input type="text" class="form-control" id="from_cryptoc" value="<?php echo $coinname;?> (<?php echo strtoupper($coinsymbol);?>)" disabled/>
     <input type="hidden" class="form-control" id="from_currency" value="<?php echo $coinprice;?>" />
</div></div>
<div class="row">
<div class="col-md-6">
 <select class="form-control js-example-basic-single" id="to_currency" onchange=calculate();>
<?php foreach ($rateData->data as $res) {
$res->currencySymbol = str_replace("CHF","",$res->currencySymbol);
?>
<option value="<?php echo $res->rateUsd; ?>" <?php if ($res->currencySymbol.' '.$res->symbol == $convertSymbol) echo "Selected"; ?>><?php echo ucwords(str_replace('-',' ',$res->id)); ?> "<?php if($res->currencySymbol==="") echo 'NA'; else echo $res->currencySymbol;?>" (<?php echo $res->symbol; ?>)</option>
 <?php } ?>
 </select>
 </div>
 </div>
<h5 class="pt-4 text-center"><div class="col-md-12"><div id="to_ammount"></div></div></h5>
<script type="text/javascript">
$(document).ready(function() {
    $('.js-example-basic-single').select2();
});
</script>
<script>
const from_currencyEl = document.getElementById('from_currency');
const from_cryptocEl = document.getElementById('from_cryptoc');
const from_ammountEl = document.getElementById('from_ammount');
const to_currencyEl = document.getElementById('to_currency');
const to_ammountEl = document.getElementById('to_ammount');

from_ammountEl.addEventListener('input', calculate);
to_ammountEl.addEventListener('input', calculate);

function calculate() {
 to_ammountEl.innerText = (from_ammountEl.value) + ' ' + (from_cryptocEl.value) + ' ' + '=' + ' ' + Number((from_ammountEl.value * from_currencyEl.value / to_currencyEl.value).toFixed(2)).toLocaleString() + ' ' + $('#to_currency option:selected').text();
}
calculate();
</script>
        </div>
        <div class="cta-box py-4 mb-3">
<p class="lead text-center mb-2">Want to convert more cryptocurrencies?</p>
   <div class="text-center mb-2"> <a href="<?php echo base_url(); ?>calculator" class="btn btn-outline-dark btn-sm"><i class="fa fa-calculator"></i> Use Crypto Calculator</a> </div>
   </div>
        
		<!-- Price Chart  -->
			<h4 class="pt-3 pb-2"><i class="fa fa-area-chart"></i> <?php echo $coinname;?> Historical Data Price Chart</h4>
  			<div class="coin-chart" data-coin-period="365day" data-coin-id="<?php echo $coinid; ?>" data-chart-color="
			<?php if($settingData[0]['site_layout']==1) echo '#FFBA00';else if($settingData[0]['site_layout']==2)   echo '#65bc7b';else if($settingData[0]['site_layout']==3)   echo '#cc0000';else if($settingData[0]['site_layout']==4)   echo '#4d39e9';else if($settingData[0]['site_layout']==5)   echo '#4fb2aa';else if($settingData[0]['site_layout']==6)   echo '#17a2b8';else if($settingData[0]['site_layout']==7)   echo '#007bff';else if($settingData[0]['site_layout']==8)   echo '#28a745';else if($settingData[0]['site_layout']==9)   echo '#dc3545';else  echo '#343a40'; ?>">
				<div class="cmc-wrp"  id="COIN-CHART-<?php echo $coinid; ?>" style="width:100%; height:100%;" >
				</div>
			</div>
        <!-- End Price Chart  -->

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
		</div>
        <!-- End Ad Code Bottom  -->
        
        <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12 text-left">
        <div class="pb-4">
            <h4 class="pt-3"><i class="fa fa-exchange"></i> <?php echo $coinname;?> Markets Exchange Data</h4>
            <p class="lead pb-3">Compare live prices of <?php echo $coinname;?> on top exchanges.</p>
        	<table id="coins-info-table" class="table table-striped table-bordered dt-responsive wrap" cellspacing="0" width="100%">
			<thead>
            <tr>
                <th>#</th>
                <th>Exchange</th>
                <th>Pair</th>
                <th>Price</th>
                <th>Volume (24h)</th>
                <th>Volume (%)</th>
            </tr>
			</thead>
			<tbody>
			    <?php
             setlocale(LC_MONETARY,"en_US");
             foreach ($coinmData->data as $res)
				{
				    $ex_code=strtoupper($res->exchangeId);
			        $img_src=base_url().'assets/images/exchanges/'.$ex_code.'.png';
			        $file_path=FCPATH.'assets/images/exchanges/'.$ex_code.'.png';
			        if (!file_exists($file_path)) $img_src=base_url().'assets/images/default.png';
					 ?>
				<tr>
					<td></td>
					<td><img src="<?php echo $img_src; ?>"><span class="coin-name"><?php echo $res->exchangeId;?></span></td>
					<td><?php echo (strlen($res->baseSymbol) > 10) ? substr($res->baseSymbol,0,7).'...' : $res->baseSymbol; ?>/<?php echo (strlen($res->quoteSymbol) > 10) ? substr($res->quoteSymbol,0,7).'...' : $res->quoteSymbol; ?></td>
					<td data-sort="<?php echo $res->priceUsd;?>"><?php echo strtok($convertSymbol, " ");?><?php echo custom_prc_format($res->priceUsd/$convertRate); ?></td>
					<td data-sort="<?php echo $res->volumeUsd24Hr;?>"><?php echo strtok($convertSymbol, " ");?><?php echo number_format($res->volumeUsd24Hr/$convertRate); ?></td>
					<td data-sort="<?php echo $res->volumePercent;?>"><?php echo round($res->volumePercent,2).'%'; ?></td>
				</tr>
			<?php
		}
				?>
			    
			</tbody>
		   </table>
        </div>
        </div></div></div>
		<!-- End Coin Data  -->

<!-- News Section Start  -->
<div class="container pb-5">
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
<div style="padding-left:0px;padding-right:0px;" class="col-md-12">
<div style="margin-bottom:20px;" class="card">
<div class="row no-gutters">
<div class="col-md-3">
<img src="<?php echo $res->enclosure->{"@attributes"}->url;?>" width="100%;"></div>
<div class="col-md-9">
<div class="card-body">
<h6 class="card-title"><?php echo $res->title;?></h6>
<p><?php echo strip_tags(substr($res->description, 0, 500));?>...</p>
<a href="<?php echo $res->link;?>" class="btn btn-warning" target="_blank">Read More</a>
</div></div></div></div></div>
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

<!-- Chart Script  -->
<script src="https://www.amcharts.com/lib/3/amcharts.js"></script>
<script src="https://www.amcharts.com/lib/3/serial.js"></script>
<script src="https://www.amcharts.com/lib/3/amstock.js"></script>
<script src="https://www.amcharts.com/lib/3/plugins/export/export.min.js"></script>
<link rel="stylesheet" href="https://www.amcharts.com/lib/3/plugins/export/export.css" type="text/css" media="all" />
<script src="https://www.amcharts.com/lib/3/themes/none.js"></script>
<script>
(function($) {
    'use strict';
    /* Single Page chart js */
      $('.coin-chart').each(function(index)
        {
            var coinId=$(this).data("coin-id");
            var chart_color=$(this).data("chart-color");
            var coinperiod=$(this).data("coin-period");
            var priceData = [];
            var volData = [];
            var price_section =$('#coin_price').val();
            //$(this).find('.CCP').number(true); 
             $.ajax({
                    url: 'https://api.coincap.io/v2/assets/'+coinId+'/history?interval=d1',
                    method: 'GET',
                    beforeSend: function() {
                        $(this).closest('.cmc-preloader').show();
                    },
                    success: function(history) {
						
						//var hdata=JSON.parse(history.data);
					  
                     $.each(history.data, function(i, value) {
                          
                            priceData.push( {
                              "date":new Date(value.time),
                              "value":value.priceUsd/<?php echo $convertRate;?>,
                              //"volume":history.volume[i][1]
                            } ); 
                        });
                    
                    
                        setTimeout(function() {
							generateChartData(coinId,priceData,chart_color);
                            $(this).closest('.cmc-preloader').hide();
                        }, 500);
                    }
                });
        });
var generateChartData = function(coinId,coinData,color) {
var chart = AmCharts.makeChart('COIN-CHART-'+coinId, {
      "type": "stock",
      "theme": "light",
      "hideCredits":true,
      "categoryAxesSettings": {
        "minPeriod": "mm"
      },
      "dataSets": [ {
        "title":"<?php echo substr($convertSymbol, strrpos($convertSymbol, ' ') + 1);?>",
        "color":color,
        "fieldMappings": [ {
          "fromField": "value",
          "toField": "value"
        }, {
          "fromField": "volume",
          "toField": "volume"
        } ],
        "dataProvider":coinData,
        "categoryField": "date"
      } ],
      "panels": [ {
        "showCategoryAxis": false,
        "title": "Price",
        "percentHeight": 70,
        "stockGraphs": [ {
          "id": "g1",
          "valueField": "value",
          "type": "smoothedLine",
          "lineThickness": 2,
          "bullet": "round",
           "comparable": true,
          "compareField": "value",
          "balloonText": "[[title]]:<b>[[value]]</b>",
          "compareGraphBalloonText": "[[title]]:<b>[[value]]</b>"
        } ],
        "stockLegend": {
          "periodValueTextComparing": "[[percents.value.close]]%",
          "periodValueTextRegular": "[[value.close]]"
        },
         "allLabels": [ {
          "x": 200,
          "y": 115,
          "text": "",
          "align": "center",
          "size": 16
        } ],
      "drawingIconsEnabled": true
      }, {
        "title": "Price",
        "percentHeight": 30,
        "stockGraphs": [ {
          "valueField": "volume",
          "type": "column",
           "showBalloon": false,
          "cornerRadiusTop": 2,
          "fillAlphas": 1
        } ],
        "stockLegend": {
          "periodValueTextRegular": "[[value.close]]"
        },
      } ],
      "chartScrollbarSettings": {
        "graph": "g1",
        "usePeriod": "10mm",
        "position": "bottom"
      },
      "chartCursorSettings": {
        "valueBalloonsEnabled": true,
        "fullWidth": true,
        "cursorAlpha": 0.1,
        "valueLineBalloonEnabled": true,
        "valueLineEnabled": true,
        "valueLineAlpha": 0.5
      },
     "periodSelector": {
        "position": "top",
        "periods": [
        {
          "period": "hh",
          "count": 24,
          "label": "24H"
        },
        {
          "period": "DD",
          "selected": true,
          "count":7,
          "label": "7D"
        },
         {
          "period": "MM",
         "count": 1,
          "label": "1M"
        }, 
      {
          "period": "MM",
          "count": 3,
          "label": "3M"
        },
          {
          "period": "MM",
          "count":6,
          "label": "6M"
        },
          {
          "period": "MAX",
          "label": "1Y"
        } ]
      },
      "export": {
        "enabled": true,
        "position": "top-right"
      }
    } );
    }
})($);
</script>

<script type="text/javascript">
		$(document).ready(function() {
		$.noConflict();
		var t = $('#coins-info-table').DataTable( {
		    "columnDefs": [ {
            "searchable": false,
            "orderable": false,
            "targets": 0
        }, 
        ],
          "order": [[ 4, "desc" ]],
          "pageLength": 25,
          "bInfo" : false,
          "bProcessing": true,
		 "bDeferRender": true,
		} );
        t.on( 'order.dt search.dt', function () {
        t.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
            cell.innerHTML = i+1;
        } );
    } ).draw();
		} );
	</script>
<script src="<?php echo base_url(); ?>assets/js/front/jquery-3.3.1.slim.min.js"></script>
<?php $this->load->view('include/footer'); ?>