function del()
{
	if(confirm("This Action cannot be undone. Are you sure you want to perform this action!"))
			{return true;}
	else
			{return false;}
}
	
function make_me_stared(action,msg_id)
{
	$.ajax({
			type: "POST",
			url:URL_SITE+"/front/actionOnMessages.php?action="+action+"&type=stared&msg="+msg_id,			
			success: function(msg)
			{		
				$("#ajaxReplace_"+msg_id).html(msg);
				
			}
	});	
}



function sort(sortname)
{
 
var sortingdata=sortname;
jQuery.ajax({
	type: "GET",
	url: "itemAjax.php?type="+sortingdata,
	
	success: function(msg){
	
	jQuery("#allitem").html(msg);
	}
	});
	
}

$(function() {
		var dates = $( "#from_searchlist, #to_searchlist" ).datepicker({
			
			minDate:-0,
			changeMonth: true,
			numberOfMonths: 1,
			onSelect: function( selectedDate ) {
				var option = this.id == "from_searchlist" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
	});

	$(function() {
		var dates = $( "#pickupother,#dropoffother" ).datepicker({
			
			minDate:-0,
			changeMonth: true,
			numberOfMonths: 1,
			onSelect: function( selectedDate ) {
				var option = this.id == "pickupother" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
	});


	jQuery(document).ready(function() { 	
	jQuery("#upload_picture").click(function() {
	var options = { 
	target:     '', 
	beforeSubmit:  function(){ 
	return jQuery("#userimagefrm").validate().form()} ,
	url:"uploadUserImage.php",
	success: function(msg) {
	location.reload(true);

	} 
	}; 

	jQuery('#userimagefrm').ajaxForm(options); 
	jQuery.blockUI({ message: jQuery('#userImage'), css: { width: '500px', border: '0px solid #cccccc', padding:'5px',top:'250px', height:'100px', overflow:'auto' } });
	});
	});

	
		$(document).ready(function(){
			$("#description").show();
			$("#pickupdetial").hide();

			$("#images").show();
			$("#mapping").hide();
			$("#calendering").hide();

			$("#review").show();
			$("#friends").hide();


			$("#photo").click(function(){
				$("#images").show();
				$("#mapping").hide();
				$("#calendering").hide();

			});

			$("#Map").click(function(){
				$("#images").hide();
				$("#mapping").show();
				$("#calendering").hide();

			});

			$("#calender").click(function(){
				$("#images").hide();
				$("#mapping").hide();
				$("#calendering").show();

			});

			$("#dec").click(function(){
					$("#description").show();
					$("#pickupdetial").hide();

			});
			$("#pickup").click(function(){
					$("#description").hide();
					$("#pickupdetial").show();

			});
			

			$("#reviewdetail").click(function(){
				$("#review").show();
				$("#friends").hide();

			});

			$("#friend").click(function(){
				$("#review").hide();
				$("#friends").show();

			});
			
			
		

	});

	function addToFavourite()
		{
			var item_id="<?php echo $item_id; ?>";
			var query="<?php echo $_SESSION['user']['id'] ; ?>";

			jQuery.ajax({
				type: "GET",
				url: "checkEmail.php?item_id="+item_id+"&user_id="+query,
                
				success: function(msg){
				
				jQuery("#message").html(msg);
				}
				});
			
		}
function hide_show(div_show, div_hide)
{
	$('#'+div_show).show();
	$('#'+div_hide).hide();
}
function requirements(profile, phone)
{
	
	var msg='';
	if(profile==1)
	{
		msg+='<p>You did not have profile Picture. Please upload a picture from <a href="'+URL_SITE+'front/profile.php">here</a></p>'
	}
	if(phone==1)
	{
		msg+='<p>You did not have Verified phone number. Verified it from <a href="'+URL_SITE+'front/profile.php">here</a></p>'
	}
	if(msg!='')
	{
		$.blockUI({ message: '<p>You can not Rent this item due to following reasons<br/></p>'+msg, css:{ width: '500px', border: '1px solid #cccccc', padding:'10px', height:'auto', overflow:'auto',cursor:'default' } });
	}
	
}

function view_item_tab(div_show,div_hide1,div_hide2)
{	
	$('#'+div_show).show();
	$('#'+div_hide1).hide();
	$('#'+div_hide2).hide();
	if(div_show!='photo')
	{
		$('#view_thumnail').hide();
	

	}
	else
	{
		$('#view_thumnail').show();
	}
}

//funtion definition for idea@192.168.0.18:/spark/front/transaction.php File added by Praveen 3/1/2012
function TransactionHistry(status,userid,page)
{
	var dataAjax ="transaction="+status+"&userid="+userid;

	$.ajax({
		type: "POST",
		data: dataAjax,
		url: URL_SITE+"/front/actionTransaction.php?page="+page,		
			
		success: function(msg)
		{	
			$("#display_all_transaction").html(msg);		
		}
	});	
}

function pagination_item_page(page,item_id)
{
	var dataAjax ="item_id="+item_id+"&page="+page;
	$('#loding').show();
	$.ajax({
		type: "get",
		data: dataAjax,
		url: URL_SITE+"/front/itemReviewAjax.php",		
			
		success: function(msg)
		{	
			$("#ajaxReview").html(msg);	
			$('#loding').hide();
		}
	});	
}

function msg_show(msg_to_show)
{
	
	
	$.blockUI({ 
            message: (msg_to_show), 
            fadeIn: 700, 
            fadeOut: 700, 
            timeout: 4000, 
            showOverlay: false, 
            centerY: false, 
            css: {
				top:'5px',
                padding: '5px', 
                backgroundColor: '#000', 
                '-webkit-border-radius': '10px', 
                '-moz-border-radius': '10px', 
                opacity: .6, 
                color: '#fff' 
            } 
        }); 
}

// to add date picker in deny page
$(function() {
		var dates = $( "#startRent,#finish_rent" ).datepicker({
			
			minDate:-0,
			changeMonth: true,
			numberOfMonths: 1,
			onSelect: function(selectedDate) {
				var option = this.id == "startRent" ? "minDate" : "maxDate",
					instance = $( this ).data( "datepicker" ),
					date = $.datepicker.parseDate(
						instance.settings.dateFormat ||
						$.datepicker._defaults.dateFormat,
						selectedDate, instance.settings );
				dates.not( this ).datepicker( "option", option, date );
			}
		});
});



//---PAYOUT PREFERENCES--(spark/front/PayoutPreferences.php)--Praveen On 3/15/2012--------->
jQuery(document).ready(function() { 	
	jQuery("#paypal_click").click(function() {
		jQuery("#PayPal_Information_show").show();
		jQuery("#Direct_Information_show").hide();
		jQuery("#Check_Information_show").hide();	
	});
	
	jQuery("#Direct_Deposit_click").click(function() {
		jQuery("#PayPal_Information_show").hide();
		jQuery("#Direct_Information_show").show();
		jQuery("#Check_Information_show").hide();	
	});

	jQuery("#Check_Deposit_click").click(function() {
		jQuery("#PayPal_Information_show").hide();
		jQuery("#Direct_Information_show").hide();
		jQuery("#Check_Information_show").show();	
	});
});