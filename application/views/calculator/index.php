<?php $this->load->view('include/header'); ?>
<div class="page-title py-3">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-12 text-center">
        <h1>
          Cryptocurrency Calculator And Converter Tool
        </h1>
        <h6 class="pb-3">
           Crypto calculator helps you convert prices between two currencies in real time. You can convert prices from more than 2000 cryptocurrency to fiat currency.
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
<!-- Calculator Start  -->
<div class="container">
 <div class="row">
<div class="col-md-6 mb-3">
 <input type="number" class="form-control" id="from_ammount" placeholder="Enter Amount To Convert" value=10 />
 </div></div>

 <div class="row">
 <div class="col-md-6">
 <select class="form-control js-example-basic-single" id="from_currency" onchange=calculate();>
 <?php foreach ($coinListtData->data as $res) { ?>
		<option value="<?php echo $res->priceUsd; ?>"><?php echo $res->name.' ('.strtoupper($res->symbol).')'; ?></option>
 <?php } ?>
 </select>
</div>

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
const from_ammountEl = document.getElementById('from_ammount');
const to_currencyEl = document.getElementById('to_currency');
const to_ammountEl = document.getElementById('to_ammount');

from_ammountEl.addEventListener('input', calculate);
to_ammountEl.addEventListener('input', calculate);

function calculate() {
 to_ammountEl.innerText = (from_ammountEl.value) + ' ' + $('#from_currency option:selected').text() + ' ' + '=' + ' ' + Number((from_ammountEl.value * from_currencyEl.value / to_currencyEl.value).toFixed(2)).toLocaleString() + ' ' + $('#to_currency option:selected').text();
}
calculate();
</script>

        </div>        
<!-- Calculator End  -->
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
	
<?php $this->load->view('include/footer'); ?>