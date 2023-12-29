<?php $this->load->view('include/header'); ?>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js" ></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.16/js/dataTables.bootstrap4.min.js" ></script>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/dataTables.responsive.min.js" ></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.16/css/dataTables.bootstrap4.min.css"/>
<script type="text/javascript" src="https://cdn.datatables.net/responsive/2.2.1/js/responsive.bootstrap4.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.1/css/responsive.bootstrap4.min.css"/> 
<script type="text/javascript">
		$(document).ready(function() {
		$.noConflict();
		$('#coins-info-table').dataTable( {
          "order": [],
          "pageLength": 10,
          "bInfo" : false,
          "bProcessing": true,
		 "bDeferRender": true,
          
		} );
		} );
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
<!-- Page Title  -->
<div class="page-title py-3">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 text-left">
        <h1>Top 50 Crypto Losers</h1>
      </div>
    </div>        
  </div>    
</div>
<!-- End Page Title  -->

<div class="container pt-5 pb-4 text-center">
    <h4 class="pb-3"><i class="fa fa-line-chart"></i> Top Coins</h4>
		 <?php
             setlocale(LC_MONETARY,"en_US");
             $i=0;
             foreach ($coinListtData->data as $res)
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
    <div class="alert alert-danger" role="alert">Which crypto coins have lost the most in the last 24 hours? The cryptocurrency list below will be updated in real time and shows you the Top 50 crypto losers for today.</div>
	<div class="row justify-content-center">
		<div class="col-md-12 text-left">
		<div class="py-2">  
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
        <tbody>
			<?php
				$cnt=0;
				setlocale(LC_MONETARY,"en_US");
				foreach ($coinChange24Sort as $key => $value)
				{
				    $img_src=base_url().'assets/images/coins/'.$coinId[$key].'.png';
			        $file_path=FCPATH.'assets/images/coins/'.$coinId[$key].'.png';
			        if (!file_exists($file_path)) $img_src=base_url().'assets/images/default.png';
			        if(!empty($value)) {
                    if($cnt > 49) continue;
					 ?>
				<tr id="BTC_<?php echo $coinCode[$key];?>">
					<td><?php echo $coinRank[$key];?></td>
					<td><img src="<?php echo $img_src ?>"><a href="<?php echo base_url() ?>coin/<?php echo strtolower(str_replace(' ','-',$coinName[$key])); ?>"><span class="coin-name"><?php echo $coinName[$key];?></span></a> <span class="badge badge-warning"><?php echo $coinCode[$key];?></span></td>
					<td class="price" data-sort="<?php echo $coinPrice[$key];?>"><?php echo strtok($convertSymbol, " ");?><?php echo custom_prc_format($coinPrice[$key]/$convertRate);?></td>
					<td data-sort="<?php echo $coinMkcap[$key];?>"><?php echo strtok($convertSymbol, " ");?><?php echo custom_number_format($coinMkcap[$key]/$convertRate); ?></td>
					<td data-sort="<?php echo $coinSupply[$key];?>"><?php echo custom_number_format($coinSupply[$key]); ?> <?php echo $coinCode[$key];?></td>
					<td data-sort="<?php echo $coinUsdVolume[$key];?>"><?php echo strtok($convertSymbol, " ");?><?php echo custom_number_format($coinUsdVolume[$key]/$convertRate); ?></td>
					<td data-sort="<?php echo $coinChange24[$key];?>"><span class="p-down"><i class="fa fa-caret-down"></i> <?php echo str_replace('-','',round($coinChange24[$key],2));?>%</span></td>
				</tr>	
		 <?php ++$cnt;
		}}
				?>
        </tbody>
    </table>      
		</div>  
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

<script src="<?php echo base_url(); ?>assets/js/front/jquery-3.3.1.slim.min.js"></script>
<?php $this->load->view('include/footer'); ?>