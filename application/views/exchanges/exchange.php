<?php $this->load->view('include/header'); ?>
<?php setlocale(LC_MONETARY,"en_US"); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js"  ></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap4.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap4.min.css"/>
<script type="text/javascript">
		$(document).ready(function() {
		$.noConflict();
		$('#coins-info-table').dataTable( {
          "order":  [[ 0, "asc" ]],
          "pageLength": 25,
          "searching": true,
          "bPaginate":true,
          "bInfo" : false,
          "bProcessing": true,
		 "bDeferRender": true,
          
		} );
		} );
	</script>
<?php
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
		 function custom_vol_format($n) {
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
 <?php foreach ($exchangeData->data as $res) { if($res->exchangeId == $exchange) $exchangename = $res->name;}
       foreach ($exchangeData->data as $res) {  if($res->exchangeId == $exchange) $exchangepair = $res->tradingPairs;}
       foreach ($exchangeData->data as $res) { if($res->exchangeId == $exchange) $exchangeurl = $res->exchangeUrl;}
       foreach ($exchangeData->data as $res) { if($res->exchangeId == $exchange) $exchangerank = $res->rank;}
       foreach ($exchangeData->data as $res) { if($res->exchangeId == $exchange) $exchangetvol = $res->percentTotalVolume;}
       foreach ($exchangeData->data as $res) { if($res->exchangeId == $exchange) $exchangevol = $res->volumeUsd;}?>
                <div class="page-title py-3">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-md-12 text-left">
                                <h1><?php echo $exchangename;?> Exchange & Trading Pairs Info</h1>
                                     
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
        <?php $ex_code=strtoupper($exchangename);
			  $img_src=base_url().'assets/images/exchanges/'.$ex_code.'.png';
			  $file_path=FCPATH.'assets/images/exchanges/'.$ex_code.'.png';
			  if (!file_exists($file_path)) $img_src=base_url().'assets/images/default.png'; ?>
        <div class="container">
			<div class="media">
			  <img class="mr-3" src="<?php echo $img_src;?>">
			    <div class="align-self-center media-body">
				  <h2 class="font-weight-bold" style="margin-bottom:0px;"><?php echo $exchangename;?> <span class="badge badge-success align-middle" style="margin-top:-0.3em;">Rank <?php if(isset($exchangerank)) echo '#'.$exchangerank; else echo 'N/A';?></span></h2>
 				  <h1 style="margin-bottom:0;"><span id="coin_price"><?php echo strtok($convertSymbol, " ");?><?php echo number_format($exchangevol/$convertRate);?></span> <small class="text-muted">(24H Trading Volume)</small></h1>
				</div>
			</div>

        <div class="pt-3 pb-2">
					<h4><i class="fa fa-eye"></i> Exchange Overview</h4>
					<p><span class="font-weight-bold"><?php echo $exchangename;?></span> exchange 24 hours trading volume is <span class="font-weight-bold" id="price_coin"><?php echo strtok($convertSymbol, " ");?><?php echo number_format($exchangevol/$convertRate);?></span> and has <span class="font-weight-bold"><?php if(isset($exchangepair)) echo $exchangepair; else echo '(Not Available)';?></span> trading pairs. <span class="font-weight-bold"><?php echo $exchangename;?></span> exchangee secured <span class="font-weight-bold">Rank <?php if(isset($exchangerank)) echo $exchangerank; else echo '(Not Available)';?></span> in the cryptocurrency exchange market with a total volume of <span class="font-weight-bold"><?php if(isset($exchangetvol)) echo round($exchangetvol,2).'%'; else echo '(N/A)';?></span>.</p>
					<hr>
					<p>Live <span class="font-weight-bold"><?php echo $exchangename;?></span> exchange markets data. Stay up to date with the latest crypto trading price movements on <span class="font-weight-bold"><?php echo $exchangeData->name;?></span> exchange. Check our exchange market data and see when there is an opportunity to buy or sell <span class="font-weight-bold">cryptocurrency</span> at best price in the market.</p>
				</div>
			
		<div class="row">
			<div class="col-sm">
				<a target = '_blank' href="<?php echo $exchangeurl; ?>" class="btn btn-dark btn-block mb-1"><i class="fa fa-link"></i> Official <?php echo $exchangename;?> Website</a>
			</div>
			<div class="col-sm">
			<a target = '_blank' href="<?php echo $settingData[0]['buy_sell'] ?>" class="btn btn-warning btn-block"><i class="fa fa-cart-plus"></i> Start Crypto Trading</a>
			</div>
		</div>
		
		<div class="pt-4 pb-3">
			<div class="card-deck">
				<div class="card bg-light">
					<div class="card-body">
						<h5 class="card-title">Exchange Name</h5>
					<p class="card-text">	<?php echo $exchangename;?></p>
					</div>
				</div>
			<div class="card bg-light">
    			<div class="card-body">
      				<h5 class="card-title">Rank</h5>
      				<p class="card-text"><?php if(isset($exchangerank)) echo $exchangerank; else echo '(N/A)';?></p>
    			</div>
			</div>
			      		<div class="card bg-light">
    			<div class="card-body">
      				<h5 class="card-title">Trading Pairs</h5>
      				<p class="card-text"><?php if(isset($exchangepair)) echo $exchangepair; else echo '(N/A)';?></p>
    			</div>
			</div>
			<div class="card bg-light">
    			<div class="card-body">
    			 <h5 class="card-title">Volume (24H)</h5>
      				<p class="card-text"><?php echo strtok($convertSymbol, " ");?><?php echo number_format($exchangevol/$convertRate);?></p>
    			</div>
			</div>
			      		<div class="card bg-light">
				<div class="card-body">
      				<h5 class="card-title">Total Volume (%)</h5>
      				<p class="card-text"><?php if(isset($exchangetvol)) echo round($exchangetvol,2).'%'; else echo '(N/A)';?></p>
    			</div>
			</div>

			</div>
		</div>
        
		<!-- Ad Code Bottom  -->
		<div class="pt-4 pb-4">
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
        		<div class="pb-5">
        		    <h4 class="py-3"><i class="fa fa-exchange"></i> <?php echo $exchangename; ?> Top Trading Pairs Info</h4>
		<!-- End Coin Data  -->
		<table id="coins-info-table" class="table table-striped table-bordered dt-responsive wrap" cellspacing="0" width="100%">
			<thead>
            <tr>
                <th>#</th>
                <th>Currency</th>
                <th>Pair</th>
                <th>Price</th>
                <th>Volume (24H)</th>
                <th>Volume (%)</th>
                <th>Trades (24H)</th>
            </tr>
			</thead>
			
						<tbody>
			    <?php
             setlocale(LC_MONETARY,"en_US");
             foreach ($exchangemData->data as $res)
				{
				    $img_src=base_url().'assets/images/coins/'.$res->baseId.'.png';
			$file_path=FCPATH.'assets/images/coins/'.$res->baseId.'.png';
			if (!file_exists($file_path)) $img_src=base_url().'assets/images/default.png';
					 ?>
				
				<tr>
					<td><?php echo $res->rank;?></td>
					<td><img src="<?php echo $img_src; ?>"><span class="coin-name"><?php echo ucwords(strtolower(str_replace('-',' ',$res->baseId))); ?></span></td>
					<td><?php echo (strlen($res->baseSymbol) > 10) ? substr($res->baseSymbol,0,7).'...' : $res->baseSymbol; ?>/<?php echo (strlen($res->quoteSymbol) > 10) ? substr($res->quoteSymbol,0,7).'...' : $res->quoteSymbol; ?></td>
					<td data-sort="<?php echo $res->priceUsd;?>"><?php echo strtok($convertSymbol, " ");?><?php echo custom_prc_format($res->priceUsd/$convertRate); ?></td>
					<td data-sort="<?php echo $res->volumeUsd24Hr;?>"><?php echo strtok($convertSymbol, " ");?><?php echo number_format($res->volumeUsd24Hr/$convertRate); ?></td>
					<td data-sort="<?php echo $res->percentExchangeVolume;?>"><?php echo round($res->percentExchangeVolume,2).'%'; ?></td>
					<td data-sort="<?php echo $res->tradesCount24Hr;?>"><?php if(isset($res->tradesCount24Hr)) echo number_format($res->tradesCount24Hr); else echo '-';?></td>
				</tr>
			<?php
		}
				?>
			    
			</tbody>
		   </table>        
</div>
</div></div></div>

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
 
<script src="<?php echo base_url(); ?>assets/js/front/jquery-3.3.1.slim.min.js"></script>
<?php $this->load->view('include/footer'); ?>