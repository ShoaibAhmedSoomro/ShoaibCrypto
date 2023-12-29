<?php $this->load->view('include/header'); ?>
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
          "pageLength": 10,
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
?>
<div class="page-title py-3">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 text-center">
        <h1>
          Top Cryptocurrency Spot Exchanges List
        </h1>
        <h6 class="pb-3">
          List of top crypto exchanges platform. The exchange rank is based on based on traffic, liquidity, trading volumes, and confidence in the legitimacy of trading volumes reported. View live cryptourrency exchanges rank, markets data, 24h volume, trading pairs and info.
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
    <h4 class="pb-3"><i class="fa fa-line-chart"></i> Top Exchanges</h4>
		 <?php
             setlocale(LC_MONETARY,"en_US");
             $i=0;
             foreach ($coinExchangesData->data as $res)
				{
				    if($i==7) continue; 
				                        $ex_code=strtoupper($res->name);
			        $img_src=base_url().'assets/images/exchanges/'.$ex_code.'.png';
					 ?>
					 
	<a href="<?php echo base_url() ?>exchange/<?php echo $res->exchangeId; ?>">
    <span class="badge badge-pill trending">  <img src="<?php echo $img_src; ?>" width="25px"/> <?php echo $res->name;?></span>
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
			<table id="coins-info-table" class="table table-striped table-bordered dt-responsive wrap" cellspacing="0" width="100%">
			<thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Trading Pairs</th>
                <th>Volume 24(H)</th>
                <th>Total Volume(%)</th>
				<th>Official Website</th>
            </tr>
			</thead>
			<tbody>
		 <?php
             setlocale(LC_MONETARY,"en_US");
             foreach ($coinExchangesData->data as $res)
				{
                    $ex_code=strtoupper($res->name);
			        $img_src=base_url().'assets/images/exchanges/'.$ex_code.'.png';
			        $file_path=FCPATH.'assets/images/exchanges/'.$ex_code.'.png';
			        if (!file_exists($file_path)) $img_src=base_url().'assets/images/default.png';
		?>
				    <tr id="CN_<?php echo strtolower($res->name);?>">
					<td><?php if(isset($res->rank)) echo $res->rank; else echo 'N/A';?></td>
					<td><img src="<?php echo $img_src; ?>"><a href="<?php echo base_url() ?>exchange/<?php echo $res->exchangeId; ?>"><span class="coin-name"><?php echo $res->name;?></span></a></td>
					<td data-sort="<?php echo $res->tradingPairs;?>"><?php if(isset($res->tradingPairs)) echo $res->tradingPairs; else echo 'N/A';?></td>
					<td data-sort="<?php echo $res->volumeUsd;?>"><?php echo strtok($convertSymbol, " ");?><?php echo custom_prc_format($res->volumeUsd/$convertRate); ?></td>
					<td data-sort="<?php echo $res->percentTotalVolume;?>"><?php echo round($res->percentTotalVolume,2).'%'; ?></td>
					<td><a href="<?php echo $res->exchangeUrl; ?>" target="_blank"><center><i class="fa fa-external-link"></i></center></a></td>
				</tr>
			<?php
		}
				?>
        </tbody>
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
<script src="<?php echo base_url(); ?>assets/js/front/jquery-3.3.1.slim.min.js"></script>
<?php $this->load->view('include/footer'); ?>