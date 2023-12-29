<?php $this->load->view('include/header'); ?>
<div class="page-title py-3">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 text-center">
        <h1>
          Cryptocurrency Latest News & Updates
        </h1>
        <h6 class="pb-2">
          This section covers fintech, blockchain and Bitcoin bringing you the latest news and analyses on the future of money.
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
   <div class="card-deck">
   <?php
             setlocale(LC_MONETARY,"en_US");
             foreach ($newsData->channel->item as $res)
				{
					 ?>
  <div style="padding-left:0px;padding-right:0px;" class="col-md-4">
		<div style="margin-bottom:20px;padding-left:0px;padding-right:0px;" class="card">
  <img src="<?php echo $res->enclosure->{"@attributes"}->url;?>" class="card-img-top">
  <div class="card-body">
          	<span class="badge linking"> <?php echo substr($res->pubDate, 0, 16);?> </span>
    <h3 class="card-title"><?php echo $res->title;?></h3>
    <p><?php echo strip_tags(substr($res->description, 0, 600));?>...</p>
    <a href="<?php echo $res->link;?>" class="btn btn-warning" target="_blank">Read More</a>
  </div>
 </div></div>
	<?php
		}
				?>
    </div></div>     

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
<!-- Donation Box  -->
<?php $this->load->view('include/donation'); ?>
<!-- End Donation Box  -->
		
<script src="<?php echo base_url(); ?>assets/js/front/jquery-3.3.1.slim.min.js"></script>
<?php $this->load->view('include/footer'); ?>