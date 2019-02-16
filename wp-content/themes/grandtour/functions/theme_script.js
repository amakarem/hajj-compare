// implement JSON.stringify serialization
JSON.stringify = JSON.stringify || function (obj) {
    var t = typeof (obj);
    if (t != "object" || obj === null) {
        // simple data type
        if (t == "string") obj = '"'+obj+'"';
        return String(obj);
    }
    else {
        // recurse array or object
        var n, v, json = [], arr = (obj && obj.constructor == Array);
        for (n in obj) {
            v = obj[n]; t = typeof(v);
            if (t == "string") v = '"'+v+'"';
            else if (t == "object" && v !== null) v = JSON.stringify(v);
            json.push((arr ? "" : '"' + n + '":') + String(v));
        }
        return (arr ? "[" : "{") + String(json) + (arr ? "]" : "}");
    }
};

jQuery.fn.vercenter = function () {
	var marginTop = parseInt((jQuery(window).height() - this.height() ) / 2);
	marginTop = parseInt(marginTop - 40);
	this.css("margin-top", marginTop  + "px");
	return this;
}

function addingListRemoveEvent()
{	
	jQuery('.adding_list_remove_row').on( 'click', function(){
		jQuery(this).parent('td').parent('tr').remove();
	});
}

function triggerResize()
{
	jQuery(window).resize();
}

function showLoading()
{
	jQuery.fancybox.showLoading();
}

function hideLoading()
{
	setTimeout(function(){
		jQuery.fancybox.hideLoading();
		jQuery('#wpwrap .fancybox-overlay').remove();
		jQuery('#content_metabox .inside .fancybox-overlay').remove();
	}, 1000);
}

function cancelContent(builderID)
{
	if(builderID != '')
	{
		jQuery('#ppb_page_content.live .ppb_sortable li#'+builderID).remove();
	}

	jQuery.fancybox.close();
}

function removeSortRecord(thisParentLi, targetObj)
{
	jQuery('li#'+thisParentLi+'_sort').remove();
	var order = jQuery('#'+targetObj).sortable('toArray');
    jQuery('#'+targetObj+'_data').val(order);
}

function isLiveMode()
{
	return jQuery('#ppb_page_content').hasClass('live');
}

function ppbAddHistory(historyAction)
{
	if (localStorage) 
	{
	  	var pageID = jQuery('#ppb_page_id').val();
	  	var currentBlockHTML = jQuery('#content_builder_sort').html();
	  	
	  	//If undo
	  	if(historyAction == 'undo')
	  	{
		  	localStorage.setItem(pageID+'_ppb_undo', currentBlockHTML);
		  	var currentDataSettings = {};
	  		var currentDataSize = {};
	  		var blockid = '';
	  		
	  		jQuery("#content_builder_sort > li").each(function(){
	  			blockid = jQuery(this).attr('id');
	  		
	  			currentDataSettings[blockid] = jQuery(this).data('ppb_setting');
	  			currentDataSize[blockid] = jQuery(this).attr('data-current-size');
			});
			
			localStorage.setItem(pageID+'_ppb_undo_setting', JSON.stringify(currentDataSettings));
			localStorage.setItem(pageID+'_ppb_undo_size', JSON.stringify(currentDataSize));
		  
		  	jQuery('#ppb_undo').addClass('visible');
		  	jQuery('#ppb_redo').removeClass('visible');
		}
		//If redo
		else
		{
		  	localStorage.setItem(pageID+'_ppb_redo', currentBlockHTML);
		  	var currentDataSettings = {};
	  		var currentDataSize = {};
	  		var blockid = '';
	  		
	  		jQuery("#content_builder_sort > li").each(function(){
	  			blockid = jQuery(this).attr('id');
	  		
	  			currentDataSettings[blockid] = jQuery(this).data('ppb_setting');
	  			currentDataSize[blockid] = jQuery(this).attr('data-current-size');
			});
			
			localStorage.setItem(pageID+'_ppb_redo_setting', JSON.stringify(currentDataSettings));
			localStorage.setItem(pageID+'_ppb_redo_size', JSON.stringify(currentDataSize));
		  
		  	jQuery('#ppb_undo').removeClass('visible');
		  	jQuery('#ppb_redo').addClass('visible');
		}
	}
}

function ppbGetHistory(historyAction)
{
	if (localStorage) 
	{
	  	var pageID = jQuery('#ppb_page_id').val();
	  	
	  	//If undo
	  	if(historyAction == 'undo')
	  	{ 
	  		//Save redo data
			ppbAddHistory('redo');
	  	
	  		var currentBlockHTML = localStorage.getItem(pageID+'_ppb_undo');
	  		jQuery('#content_builder_sort').html(currentBlockHTML);
	  		
	  		var currentDataSettings = jQuery.parseJSON(localStorage.getItem(pageID+'_ppb_undo_setting'));
	  		var currentDataSize = jQuery.parseJSON(localStorage.getItem(pageID+'_ppb_undo_size'));
	  		var blockSettings = '';
	  		var blockSize = '';
	  		var blockid = '';
	  		
	  		jQuery("#content_builder_sort > li").each(function(){
	  			blockid = jQuery(this).attr('id');

	  			var blockSettings = currentDataSettings[blockid];
	  			var blockSize = currentDataSize[blockid];
	  			
	  			jQuery(this).data('ppb_setting', blockSettings);
	  			jQuery(this).attr('data-current-size', blockSize);
			});
	  	
		  	jQuery('#ppb_redo').addClass('visible');
		  	jQuery('#ppb_undo').removeClass('visible');
		}
		//If redo
		else
		{
			//Save redo data
			ppbAddHistory('undo');
		
			var currentBlockHTML = localStorage.getItem(pageID+'_ppb_redo');
			jQuery('#content_builder_sort').html(currentBlockHTML);
			
			var currentDataSettings = jQuery.parseJSON(localStorage.getItem(pageID+'_ppb_redo_setting'));
	  		var currentDataSize = jQuery.parseJSON(localStorage.getItem(pageID+'_ppb_redo_size'));
	  		var blockSettings = '';
	  		var blockSize = '';
	  		var blockid = '';
	  		
	  		jQuery("#content_builder_sort > li").each(function(){
	  			blockid = jQuery(this).attr('id');

	  			var blockSettings = currentDataSettings[blockid];
	  			var blockSize = currentDataSize[blockid];
	  			
	  			jQuery(this).data('ppb_setting', blockSettings);
	  			jQuery(this).attr('data-current-size', blockSize);
			});
		
			jQuery('#ppb_redo').removeClass('visible');
		  	jQuery('#ppb_undo').addClass('visible');
		}
		
		ppbBuildEdit();
		refreshBuilderBlockEvents();
		ppbBuildItem();
		
		//If in live mode reload preview frame
    	if(isLiveMode())
		{
			//Save all content
			ppbSaveAll();
	    	
	    	//Set preview frame data
			ppbSetPreviewData();
			
			//Reload preview frame
			ppbReloadPreview();
		}
	}
}

function ppbUpdateAllSize()
{
	//Update all resized elements
	jQuery("#content_builder_sort > li").each(function(){
	    var currentSize = jQuery(this).attr('data-current-size');
	    var prev1Li = jQuery(this).prev();
	    var prev2Li = prev1Li.prev();
	    var prev3Li = prev2Li.prev();
	    var next1Li = jQuery(this).next();
	    
	    if(currentSize == 'one_fourth')
	    {
	    	if(prev1Li.attr('data-current-size')=='one_fourth' && prev2Li.attr('data-current-size')=='one_fourth' && prev3Li.attr('data-current-size')=='one_fourth')
	    	{
	    		jQuery(this).addClass('last');
	    		jQuery(this).attr('data-current-size', 'one_fourth last');
	        	jQuery(this).find('.ppb_setting_columns').attr('value', 'one_fourth last');
	    	}
	    }
	    else if(currentSize == 'one_fourth last')
	    {
	    	if(prev1Li.attr('data-current-size')!='one_fourth' || prev2Li.attr('data-current-size')!='one_fourth' || prev3Li.attr('data-current-size')!='one_fourth')
	    	{
	    		jQuery(this).removeClass('last');
	    		jQuery(this).attr('data-current-size', 'one_fourth');
	        	jQuery(this).find('.ppb_setting_columns').attr('value', 'one_fourth');
	    	}
	    }
	    else if(currentSize == 'one_third')
	    {
	    	if(prev1Li.attr('data-current-size')=='one_third' && prev2Li.attr('data-current-size')=='one_third')
	    	{
	    		jQuery(this).addClass('last');
	    		jQuery(this).attr('data-current-size', 'one_third last');
	        	jQuery(this).find('.ppb_setting_columns').attr('value', 'one_third last');
	    	}
	    }
	    else if(currentSize == 'one_third last')
	    {
	    	if(prev1Li.attr('data-current-size')!='one_third' || prev2Li.attr('data-current-size')!='one_third' || prev1Li.attr('data-current-size')=='two_third')
	    	{
	    		jQuery(this).removeClass('last');
	    		jQuery(this).attr('data-current-size', 'one_third');
	        	jQuery(this).find('.ppb_setting_columns').attr('value', 'one_third');
	    	}
	    }
	    else if(currentSize == 'one_half')
	    {
	        if(prev1Li.attr('data-current-size')=='one_half')
	    	{
	    		jQuery(this).addClass('last');
	    		jQuery(this).attr('data-current-size', 'one_half last');
	        	jQuery(this).find('.ppb_setting_columns').attr('value', 'one_half last');
	    	}
	    }
	    else if(currentSize == 'one_half last')
	    {
	    	if(prev1Li.attr('data-current-size')!='one_half')
	    	{
	    		jQuery(this).removeClass('last');
	    		jQuery(this).attr('data-current-size', 'one_half');
	        	jQuery(this).find('.ppb_setting_columns').attr('value', 'one_half');
	    	}
	    }
	    else if(currentSize == 'two_third')
	    {
	        if(prev1Li.attr('data-current-size')=='one_third')
	    	{
	    		jQuery(this).addClass('last');
	    		jQuery(this).attr('data-current-size', 'two_third last');
	        	jQuery(this).find('.ppb_setting_columns').attr('value', 'two_third last');
	    	}
	    }
	    else if(currentSize == 'two_third last')
	    {
	    	if(next1Li.attr('data-current-size')=='one_third')
	    	{
	    		jQuery(this).removeClass('last');
	    		jQuery(this).attr('data-current-size', 'two_third');
	        	jQuery(this).find('.ppb_setting_columns').attr('value', 'two_third');
	    	}
	    }
	});
}

function ppbReloadPreview()
{
	if(isLiveMode())
	{
		showLoading();
		jQuery('#ppb_live_preview_frame').contents().find('body').addClass('loading');
		jQuery('#ppb_live_preview_frame').contents().find('body').addClass('overflow_hidden');
		document.getElementById('ppb_live_preview_frame').contentDocument.location.reload(true);
	}
}

function ppbSetPreviewData()
{
	if(isLiveMode())
	{
		var actionURL = jQuery('#ppb_live_preview_frame').data('action');
		
		//Get current data string
		var dataString = ppbGetDataString();
		var dataSizeString = ppbGetDataSizeString();
		
		//Set page preview data
		jQuery.ajax({
		  type: "POST",
		  cache: false,
		  url: actionURL,
		  data: 'page_id='+jQuery('#ppb_page_id').val()+'&data_order='+jQuery('#ppb_form_data_order').val()+dataString+dataSizeString,
		  success: function (data) {
		  	refreshBuilderBlockEvents();
		  } 
		});
	}
}

function ppbSetUnsaveStatus()
{
	jQuery('#ppb_save').removeClass('inactive');
	var saveButtonTitle = jQuery('#ppb_save').data('save-title');
	jQuery('#ppb_save').find('.ppb_live_button_title').html(saveButtonTitle);
	jQuery('#ppb_options_unsaved').val(1);
	jQuery('#ppb_page_unsaved').addClass('visible');
}

function ppbRemoveUnsaveStatus()
{
	jQuery('#ppb_save').addClass('inactive');
	var saveButtonTitle = jQuery('#ppb_save').data('saved-title');
	jQuery('#ppb_save').find('.ppb_live_button_title').html(saveButtonTitle);
	jQuery('#ppb_options_unsaved').val();
	jQuery('#ppb_page_unsaved').removeClass('visible');
	jQuery(window).unbind('beforeunload');
}

function ppbGetDataString()
{
	var dataString = '';
	jQuery("#content_builder_sort > li").each(function(){
	    dataString+= '&'+jQuery(this).attr('id')+'_data='+encodeURIComponent(jQuery(this).data('ppb_setting'));
	});
	
	return dataString;
}

function ppbGetDataSizeString()
{
	var dataSizeString = '';
	jQuery("#content_builder_sort > li").each(function(){
	    dataSizeString+= '&'+jQuery(this).attr('id')+'_size='+encodeURIComponent(jQuery(this).attr('data-current-size'));
	});
	
	return dataSizeString;
}

function ppbSaveAll()
{
	//Check all elements size again
	jQuery("#content_builder_sort > li").each(function(){
	    var currentSize = jQuery(this).attr('data-current-size');
	
	    var prev1Li = jQuery(this).prev();
	    var prev2Li = prev1Li.prev();
	    var prev3Li = prev2Li.prev();
	    
	    if(currentSize == 'one_fourth' && prev1Li.attr('data-current-size')=='one_fourth' && prev2Li.attr('data-current-size')=='one_fourth' && prev3Li.attr('data-current-size')=='one_fourth')
	    {
	        jQuery(this).attr('data-current-size', 'one_fourth last');
	        jQuery(this).find('.ppb_setting_columns').attr('value', 'one_fourth last');
	
	    }
	    else if(currentSize == 'one_third')
	    {	
	    	if(prev1Li.attr('data-current-size')=='one_third' && prev2Li.attr('data-current-size')=='one_third' )
	    	{
	    		jQuery(this).attr('data-current-size', 'one_third last');
	    		jQuery(this).find('.ppb_setting_columns').attr('value', 'one_third last');
	
	    	}
	    	else if(prev1Li.attr('data-current-size')=='two_third')
	    	{
	        	jQuery(this).attr('data-current-size', 'one_third last');
	    		jQuery(this).find('.ppb_setting_columns').attr('value', 'one_third last');	
	    	}
	    }
	    else if(currentSize == 'one_half' && prev1Li.attr('data-current-size')=='one_half')
	    {
	    	jQuery(this).attr('data-current-size', 'one_half last');
	        jQuery(this).find('.ppb_setting_columns').attr('value', 'one_half last');
	    }
	    else if(currentSize == 'two_third' && prev1Li.attr('data-current-size')=='one_third')
	    {
	    	jQuery(this).attr('data-current-size', 'two_third last');
	        jQuery(this).find('.ppb_setting_columns').attr('value', 'two_third last');
	    }
	});
	
	jQuery("#content_builder_sort > li").each(function(){
	    jQuery(this).append('<textarea style="display:none" id="'+jQuery(this).attr('id')+'_data" name="'+jQuery(this).attr('id')+'_data">'+jQuery(this).data('ppb_setting')+'</textarea>');
	    jQuery(this).append('<input style="display:none" type="text" id="'+jQuery(this).attr('id')+'_size" name="'+jQuery(this).attr('id')+'_size" value="'+jQuery(this).attr('data-current-size')+'"/>');
	});
	
	var itemOrder = jQuery("#content_builder_sort").sortable('toArray');
	jQuery('#ppb_form_data_order').attr('value', itemOrder);
}

function refreshBuilderBlockEvents()
{
    //Double click to edit content
    jQuery('#content_builder_sort.ppb_sortable li').on( 'dblclick', function(e){
		if(!jQuery(this).hasClass('active') && !jQuery(this).hasClass('ppb_divider'))
		{
    		jQuery(this).find('.item_action').find('.ppb_edit').trigger('click');
    	}
    });
    
    //Click to scroll to content
    jQuery('#content_builder_sort.ppb_sortable li').on( 'click', function(e){
    	//If in live mode
    	if(isLiveMode())
		{
    		var livePreviewIframe = jQuery('#ppb_live_preview_frame');
    		var positionToScroll = parseInt(livePreviewIframe.contents().find('#live_'+jQuery(this).attr('id')).offset().top-100);
    		if(positionToScroll < 0)
    		{
    			positionToScroll = 0;
    		}
    		
    		livePreviewIframe.contents().find("html, body").stop().animate({ scrollTop: positionToScroll });
    		
    		livePreviewIframe.contents().find('.ppb_live_edit_wrapper').removeClass('hover');
    		livePreviewIframe.contents().find('#live_'+jQuery(this).attr('id')).addClass('hover');
    	}
    });
    
    //Mouseover to inspect live preview element
    jQuery('#content_builder_sort.ppb_sortable li').on( 'mouseenter', function(e){
    	//If in live mode
    	if(isLiveMode())
		{
    		var livePreviewIframe = jQuery('#ppb_live_preview_frame');
    		livePreviewIframe.contents().find('.ppb_live_edit_wrapper').removeClass('hover');
    		livePreviewIframe.contents().find('#live_'+jQuery(this).attr('id')).addClass('hover');
    	}
    });
    
    jQuery('#content_builder_sort.ppb_sortable li').on( 'mouseleave', function(e){
    	//If in live mode
    	if(isLiveMode())
		{
    		var livePreviewIframe = jQuery('#ppb_live_preview_frame');
    		livePreviewIframe.contents().find('#live_'+jQuery(this).attr('id')).removeClass('hover');
    	}
    });
}

function ppbBuildItem()
{	
	jQuery(window).bind('beforeunload', function(){
	    if(jQuery('#ppb_options_unsaved').val()==1)
	    {
	    	return 'There are unsaved content builder settings';
	    }
	});

	jQuery("#content_builder_sort li a.ppb_add_after").on( 'mouseover', function(){
		var parentBlock = jQuery(this).parent('.item_action').parent('li');
		var parentID = parentBlock.attr('id');
		
		//Check if already add helper
		var helperBlock = parentBlock.next('li.ppb_add_after_helper');
		
		if(helperBlock.length == 0)
		{
			var addHelper = '<li class="ppb_add_after_helper"></li>';
			parentBlock.after(addHelper);
		}
	});
	
	jQuery("#content_builder_sort li a.ppb_add_after").on( 'mouseleave', function(){
		var parentBlock = jQuery(this).parent('.item_action').parent('li');
		
		parentBlock.next('li.ppb_add_after_helper').remove();
	});
	
	jQuery("#content_builder_sort li a.ppb_add_after").on( 'click', function(){
		var parentBlock = jQuery(this).parent('.item_action').parent('li');
		var parentID = parentBlock.attr('id');
		
		//Check if already add helper
		var helperBlock = parentBlock.next('li.ppb_add_after_helper');
		
		if(helperBlock.length == 0)
		{
			var addHelper = '<li class="ppb_add_after_helper"></li>';
			parentBlock.after(addHelper);
		}
		
		jQuery('#ppb_sortable_add_button').attr('data-after', parentID);
		
		jQuery('#ppb_sortable_add_button').trigger('click');
	});

	jQuery("#content_builder_sort li a.ppb_duplicate").unbind();

	jQuery("#content_builder_sort li a.ppb_duplicate").on( 'click', function(){
		//Save undo data to localstorage
		ppbAddHistory('undo');
	
		var parentItem = jQuery(this).parent('div').parent('li');
		var parentItemId = jQuery(this).parent('div').parent('li').attr('id');
		var parentItemDataJSON = jQuery('#'+parentItemId).data('ppb_setting');
		var parentItemColumns = jQuery(this).parent('div').parent('li').find('.ppb_setting_columns').val();
		
		parentItemData = jQuery.parseJSON(parentItemDataJSON);
		
	    var targetSelect = parentItemData.shortcode;
	    var targetTitle = decodeURIComponent(parentItemData[targetSelect+'_title']);
	    
	    randomId = jQuery.now();
	    myCheckId = targetSelect;
	    myCheckTitle = targetTitle;
	    var targetShortcode = jQuery(this).parent('div').parent('li').data('shortcode');
	    var targetIcon = jQuery(this).parent('div').parent('li').data('icon');
	    postType = jQuery('#ppb_post_type').val();
	    
	    var builderItemData = {};
	    builderItemData.id = randomId;
	    builderItemData.shortcode = parentItemData.shortcode;
	    builderItemData.ppb_text_title = parentItemData;
	    builderItemData.ppb_text_content = parentItemData[targetSelect+'_content'];
	    builderItemData.ppb_header_content = '';
	
	    builderItem = '<li id="'+randomId+'" class="ui-state-default '+parentItemColumns+' '+myCheckId+'" data-current-size="'+parentItemColumns+'">';
	    builderItem+= '<div class="size"><a href="javascript:;" class="ppb_plus button">+</a>';
	    builderItem+= '<a href="javascript:;" class="ppb_minus button">-</a></div>';
	    
	    builderItem+= '<div class="thumb"><img src="'+targetIcon+'" alt=""></div>';
	    builderItem+= '<div class="title"><div class="shortcode_title">'+targetShortcode+'</div>'+myCheckTitle+'</div>';
	    
	    //Display module action
	    builderItem+= '<div class="item_action">';
	    
	    //Display remove button
	    builderItem+= '<a href="javascript:;" class="ppb_remove"><i class="fa fa-trash"></i></a>';
		
		//Display edit button
	    var editURL = tgAjax.ajaxurl+'?action=grandtour_ppb&ppb_post_type='+postType+'&shortcode='+myCheckId+'&rel='+randomId+'&width=800&height=900&page_id='+jQuery('#ppb_page_id').val();
	    builderItem+= '<a data-rel="'+randomId+'" href="'+editURL+'" class="ppb_edit"><i class="fa fa-edit"></i></a>';
	    
	    //End display module action
	    builderItem+= '</div>';
	    
	    builderItem+= '<input type="hidden" class="ppb_setting_columns" value="'+parentItemColumns+'"/>';
	    builderItem+= '</li>';
	
		//Insert after parent element
	    parentItem.after(builderItem);
	    jQuery('#content_builder_sort').removeClass('empty');
	    jQuery('#'+randomId).data('ppb_setting', parentItemDataJSON);
	    jQuery('#'+randomId).find('.ppb_setting_columns').attr('value', parentItemColumns);
	    
	    ppbSetUnsaveStatus();
	    ppbBuildEdit();
	    ppbBuildItem();
	    ppbUpdateAllSize();
	    
	    //If in live mode reload preview frame
    	if(isLiveMode())
		{
			//Save all content
			ppbSaveAll();
	    	
	    	//Set preview frame data
			ppbSetPreviewData();
			
			//Reload preview frame
			ppbReloadPreview();
			
			//Fix for fancybox display bug
			jQuery('body').addClass('ppb_duplicated');
		}
	    
	    jQuery('.tooltipster').tooltipster();
	});
	
	jQuery("#content_builder_sort li a.ppb_plus").on( 'click', function(){
	    var currentSize = jQuery(this).parent('div').parent('li').attr('data-current-size');

	    var prev1Li = jQuery(this).parent('div').parent('li').prev();
	    var prev2Li = prev1Li.prev();
	    var prev3Li = prev2Li.prev();
	    
	    if(currentSize == 'one_fourth' || currentSize == 'one_fourth last')
	    {
	    	if(prev1Li.attr('data-current-size')=='one_third' && prev2Li.attr('data-current-size')=='one_third')
	    	{
	    		jQuery(this).parent('div').parent('li').addClass('one_third');
		    	jQuery(this).parent('div').parent('li').attr('data-current-size', 'one_third last');
		    	jQuery(this).parent('div').parent('li').find('.ppb_setting_columns').attr('value', 'one_third last');	

	    	}
	    	else if(prev1Li.attr('data-current-size')=='two_third')
	    	{
	    		jQuery(this).parent('div').parent('li').addClass('one_third');
		    	jQuery(this).parent('div').parent('li').attr('data-current-size', 'one_third last');
		    	jQuery(this).parent('div').parent('li').find('.ppb_setting_columns').attr('value', 'one_third last');	

	    	}
	    	else
	    	{
		    	jQuery(this).parent('div').parent('li').addClass('one_third');
		    	jQuery(this).parent('div').parent('li').attr('data-current-size', 'one_third');
		    	jQuery(this).parent('div').parent('li').find('.ppb_setting_columns').attr('value', 'one_third');	
	    	}
	    	
	    	jQuery(this).parent('div').parent('li').removeClass('one_fourth');
	    }
	    else if(currentSize == 'one_third' || currentSize == 'one_third last')
	    {	
	    	if(prev1Li.attr('data-current-size')=='one_half')
	    	{
	    		jQuery(this).parent('div').parent('li').addClass('one_half');
		    	jQuery(this).parent('div').parent('li').attr('data-current-size', 'one_half last');
		    	jQuery(this).parent('div').parent('li').find('.ppb_setting_columns').attr('value', 'one_half last');	

	    	}
	    	else
	    	{
		    	jQuery(this).parent('div').parent('li').addClass('one_half');
		    	jQuery(this).parent('div').parent('li').attr('data-current-size', 'one_half');
		    	jQuery(this).parent('div').parent('li').find('.ppb_setting_columns').attr('value', 'one_half');	
	    	}
	    	
	    	jQuery(this).parent('div').parent('li').removeClass('one_third');
	    }
	    else if(currentSize == 'one_half' || currentSize == 'one_half last')
	    {
	    	if(prev1Li.attr('data-current-size')=='one_third')
	    	{
	    		jQuery(this).parent('div').parent('li').addClass('two_third');
		    	jQuery(this).parent('div').parent('li').attr('data-current-size', 'two_third last');
		    	jQuery(this).parent('div').parent('li').find('.ppb_setting_columns').attr('value', 'two_third last');	
	    	}
	    	else
	    	{
		    	jQuery(this).parent('div').parent('li').addClass('two_third');
		    	jQuery(this).parent('div').parent('li').attr('data-current-size', 'two_third');
		    	jQuery(this).parent('div').parent('li').find('.ppb_setting_columns').attr('value', 'two_third');	
	    	}

	    	jQuery(this).parent('div').parent('li').removeClass('one_half');
	    }
	    else if(currentSize == 'two_third' || currentSize == 'two_third last')
	    {
	    	jQuery(this).parent('div').parent('li').addClass('one');
	    	jQuery(this).parent('div').parent('li').attr('data-current-size', 'one');
	    	jQuery(this).parent('div').parent('li').find('.ppb_setting_columns').attr('value', 'one');
	    	jQuery(this).parent('div').parent('li').removeClass('two_third');
	    }
	    else if(currentSize == 'one')
	    {
	    	return false;
	    }
	    else
	    {
	    	return false;
	    }
	    
	    //If in live mode reload preview frame
    	if(isLiveMode())
		{
			//Save all content
			ppbSaveAll();
	    	
	    	//Set preview frame data
			ppbSetPreviewData();
			
			//Reload preview frame
			ppbReloadPreview();
		}
	});
	
	jQuery("#content_builder_sort li a.ppb_minus").on( 'click', function(){
	    var currentSize = jQuery(this).parent('div').parent('li').attr('data-current-size');
	    var prev1Li = jQuery(this).parent('div').parent('li').prev();
	    var prev2Li = prev1Li.prev();
	    var prev3Li = prev2Li.prev();
	    
	    if(currentSize == 'one_fourth' || currentSize == 'one_fourth last')
	    {
	    	return false;
	    }
	    else if(currentSize == 'one_third' || currentSize == 'one_third last')
	    {
	    	if(prev1Li.attr('data-current-size')=='one_fourth' && prev2Li.attr('data-current-size')=='one_fourth' && prev3Li.attr('data-current-size')=='one_fourth')
	    	{
	    		jQuery(this).parent('div').parent('li').addClass('one_fourth');
		    	jQuery(this).parent('div').parent('li').attr('data-current-size', 'one_fourth last');
		    	jQuery(this).parent('div').parent('li').find('.ppb_setting_columns').attr('value', 'one_fourth last');
	    	}
	    	else
	    	{
		    	jQuery(this).parent('div').parent('li').addClass('one_fourth');
		    	jQuery(this).parent('div').parent('li').attr('data-current-size', 'one_fourth');
		    	jQuery(this).parent('div').parent('li').find('.ppb_setting_columns').attr('value', 'one_fourth');
	    	}
	    	
	    	jQuery(this).parent('div').parent('li').removeClass('one_third');
	    }
	    else if(currentSize == 'one_half' || currentSize == 'one_half last')
	    {
	    	if(prev1Li.attr('data-current-size')=='one_third' && prev2Li.attr('data-current-size')=='one_third')
	    	{
	    		jQuery(this).parent('div').parent('li').addClass('one_third');
		    	jQuery(this).parent('div').parent('li').attr('data-current-size', 'one_third last');
		    	jQuery(this).parent('div').parent('li').find('.ppb_setting_columns').attr('value', 'one_third last');	

	    	}
	    	else if(prev1Li.attr('data-current-size')=='two_third')
	    	{
	    		jQuery(this).parent('div').parent('li').addClass('one_third');
		    	jQuery(this).parent('div').parent('li').attr('data-current-size', 'one_third last');
		    	jQuery(this).parent('div').parent('li').find('.ppb_setting_columns').attr('value', 'one_third last');	

	    	}
	    	else
	    	{
		    	jQuery(this).parent('div').parent('li').addClass('one_third');
		    	jQuery(this).parent('div').parent('li').attr('data-current-size', 'one_third');
		    	jQuery(this).parent('div').parent('li').find('.ppb_setting_columns').attr('value', 'one_third');	
	    	}
	    	
	    	jQuery(this).parent('div').parent('li').removeClass('one_half');
	    }
	    else if(currentSize == 'two_third' || currentSize == 'two_third last')
	    {
	    	if(prev1Li.attr('data-current-size')=='one_half')
	    	{
	    		jQuery(this).parent('div').parent('li').addClass('one_half');
		    	jQuery(this).parent('div').parent('li').attr('data-current-size', 'one_half last');
		    	jQuery(this).parent('div').parent('li').find('.ppb_setting_columns').attr('value', 'one_half last');	

	    	}
	    	else
	    	{
		    	jQuery(this).parent('div').parent('li').addClass('one_half');
		    	jQuery(this).parent('div').parent('li').attr('data-current-size', 'one_half');
		    	jQuery(this).parent('div').parent('li').find('.ppb_setting_columns').attr('value', 'one_half');	
	    	}
	    	
	    	jQuery(this).parent('div').parent('li').removeClass('two_third');
	    }
	    else if(currentSize == 'one')
	    {
	    	if(prev1Li.attr('data-current-size')=='one_third')
	    	{
	    		jQuery(this).parent('div').parent('li').addClass('two_third');
		    	jQuery(this).parent('div').parent('li').attr('data-current-size', 'two_third last');
		    	jQuery(this).parent('div').parent('li').find('.ppb_setting_columns').attr('value', 'two_third last');	
	    	}
	    	else
	    	{
		    	jQuery(this).parent('div').parent('li').addClass('two_third');
		    	jQuery(this).parent('div').parent('li').attr('data-current-size', 'two_third');
		    	jQuery(this).parent('div').parent('li').find('.ppb_setting_columns').attr('value', 'two_third');	
	    	}
	    	
	    	jQuery(this).parent('div').parent('li').removeClass('one');
	    }
	    else
	    {
	    	return false;
	    }
	    
	    //If in live mode reload preview frame
    	if(isLiveMode())
		{
			//Save all content
			ppbSaveAll();
	    	
	    	//Set preview frame data
			ppbSetPreviewData();
			
			//Reload preview frame
			ppbReloadPreview();
		}
	});
	
	jQuery(".pp_fancybox").fancybox({
	    maxWidth	: 600,
	    maxHeight	: 2000,
	    minHeight	: 200,
	    margin: 50,
	    height		: 'auto',
	    autoSize	: false,
	    closeClick	: false,
	    openEffect	: 'none',
	    closeEffect	: 'none',
	    helpers : {
	    	overlay : {
	            css : {
	                'background-color' : 'rgba(0, 0, 0, 0.2)'
	            },
			    closeClick: false
	        }
	    },
	    onCancel: function(current, previous) {
	    	jQuery("textarea.ppb_input").each(function(){
				tinymce.EditorManager.execCommand( 'mceRemoveEditor', false, jQuery(this).attr('id') );	
			});
	    }
	});
	
	jQuery(".pp_fancybox_inline").fancybox({
	    maxWidth	: 600,
	    maxHeight	: 900,
	    margin: 50,
	    height		: 'auto',
	    padding		: 0,
	    autoSize	: false,
	    closeClick	: false,
	    openEffect	: 'none',
	    closeEffect	: 'none',
	    helpers : {
	    	overlay : {
	            css : {
	                'background' : 'rgba(0, 0, 0, 0.2)'
	            },
			    closeClick: false
	        }
	    },
	    beforeLoad: function(current, previous) {
	    	jQuery('body').addClass('ppb_open');
		},
	    afterClose: function(current, previous) {
	    	jQuery('body').removeClass('ppb_open');
		}
	});
	
	jQuery(".pp_fancybox_inline_fullheight").fancybox({
	   	fitToView: false,
	    width: 500,
		minHeight: '100%',
	    margin: 50,
	    leftRatio: 1,
	    autoSize: false,
	    autoResize: true,
	    autoHeight: false,
	    autoCenter: false,
	    closeClick: false,
	    openEffect: 'none',
	    closeEffect: 'none',
	    padding: 0,
	    helpers : {
		  	overlay : {
		          css : {
		              'background-color' : 'rgba(0, 0, 0, 0.2)'
		          },
		          closeClick: false
		      },
		 },
	    beforeLoad: function(current, previous) {
	    	jQuery('body').addClass('ppb_open');
		},
	    afterClose: function(current, previous) {
	    	jQuery('body').removeClass('ppb_open');
		}
	});
}

function ppbBuildEdit()
{
	jQuery("#content_builder_sort li a.ppb_edit").on( 'click', function(e){
		e.preventDefault();
		jQuery(this).parent('div.item_action').parent('li').addClass('active');
		jQuery('#ppb_inline_current').val(jQuery(this).attr('data-rel'));
		jQuery('body').addClass('ppb_editing');
		
		jQuery.fancybox.showLoading();
		var actionURL = jQuery(this).attr('href');
		
		jQuery.ajax({
	      type: "GET",
	      url: actionURL,
	      data: '',
	      success: function (data) {
	        jQuery.fancybox(data, {
	          fitToView: false,
	          width: 500,
	          height: '100%',
	          minHeight: '100%',
	          leftRatio: 1,
	          margin: 50,
	          autoSize: false,
	          autoResize: true,
	          autoHeight: false,
	          autoCenter: false,
	          closeClick: false,
	          openEffect: 'none',
	          closeEffect: 'none',
	          padding: 0,
	          helpers : {
			    	overlay : {
			            css : {
			                'background-color' : 'rgba(0, 0, 0, 0.2)'
			            },
			            closeClick: false
			        },
			   },
			  beforeClose: function(current, previous) {
			    jQuery("textarea.ppb_input").each(function(){
				    tinymce.EditorManager.execCommand( 'mceRemoveEditor', false, jQuery(this).attr('id') );	
				});
			    jQuery('#content_builder_sort.ppb_sortable li').removeClass('active');
			    
			    jQuery('body').removeClass('ppb_editing');
			  },
			  afterClose: function(current, previous) {
			  	jQuery('body').removeClass('ppb_editing');
			  }
	        }); 
	      } 
	    });
	    
	    return false;
	});
	
	jQuery("#content_builder_sort li a.ppb_remove").on( 'click', function(){
		//Save undo data to localstorage
		ppbAddHistory('undo');
	
		//Remove from buidler sortable blocks
	    if(jQuery(this).parent('div').parent('li').length > 0)
	    {
	    	jQuery(this).parent('div').parent('li').remove();
	    }
	    
	    if(jQuery(this).parent('li').length > 0)
	    {
	    	jQuery(this).parent('li').remove();
	    }
	    
	    if(jQuery("#content_builder_sort li").length)
	    {
		    jQuery("#ppb_remove_all").val(1);
	    }
	    
	    //If in live mode reload preview frame
    	if(isLiveMode())
		{
			//Save all content
			ppbSaveAll();
	    	
	    	//Set preview frame data
			ppbSetPreviewData();
			
			//Reload preview frame
			ppbReloadPreview();
		}
	    
	    ppbSetUnsaveStatus();
	});
	
	jQuery("#content_builder_sort li a.ppb_preview").on( 'click', function(e){
		e.preventDefault();
		jQuery('#ppb_inline_current').attr('value', jQuery(this).attr('data-rel'));
		
		jQuery.fancybox.showLoading();
		var actionURL = jQuery(this).attr('href');
		
		jQuery.ajax({
	      type: "GET",
	      cache: false,
	      url: actionURL,
	      data: '',
	      success: function (data) {
	        jQuery.fancybox(data, {
	          fitToView: false,
	          width: 1024,
	          minHeight: '100%',
	          autoSize: false,
	          autoResize: true,
	          autoHeight: true,
	          closeClick: false,
	          openEffect: 'none',
	          closeEffect: 'none',
	          helpers : {
				  	overlay : {
				          css : {
				              'background-color' : 'rgba(0, 0, 0, 0.2)'
				          }
				      }
				 },
	          padding: 0
	        }); 
	      } 
	    });
	    
	    return false;
	});
}

jQuery(document).ready(function(){

    jQuery('#current_sidebar li a.sidebar_del').on( 'click', function(){
    	if(confirm('Are you sure you want to delete this sidebar? (this can not be undone)'))
    	{
    		sTarget = jQuery(this).attr('href');
    		sSidebar = jQuery(this).attr('rel');
    		objTarget = jQuery(this).parent('li');
    		
    		jQuery.ajax({
        		type: 'POST',
        		url: sTarget,
        		data: 'sidebar_id='+sSidebar,
        		success: function(msg){ 
        			objTarget.fadeOut();
        			setTimeout(function() {
                      location.reload();
                    }, 1000);
        		}
        	});
    	}
    	
    	return false;
    });
    
    jQuery('#current_ggfont li a.ggfont_del').on( 'click', function(){
	    if(confirm('Are you sure you want to delete this font? (this can not be undone)'))
	    {
	    	sTarget = jQuery(this).attr('href');
	    	sGGFont = jQuery(this).attr('rel');
	    	objTarget = jQuery(this).parent('li');
	    	
	    	jQuery.ajax({
  	    		type: 'POST',
  	    		url: sTarget,
  	    		data: 'ggfont='+sGGFont,
  	    		success: function(msg){ 
  	    			objTarget.fadeOut();
  	    		}
	    	});
	    }
	    
	    return false;
	});
    
    jQuery('a.image_del').on( 'click', function(){
    	if(confirm('Are you sure you want to delete this image? (this can not be undone)'))
    	{
    		sTarget = jQuery(this).attr('href');
    		sFieldId = jQuery(this).attr('rel');
    		objTarget = jQuery('#'+sFieldId+'_wrapper');
    		
    		jQuery.ajax({
        		type: 'POST',
        		url: sTarget,
        		data: 'field_id='+sFieldId,
        		success: function(msg){ 
        			objTarget.fadeOut();
        			jQuery('#'+sFieldId).val('');
        		}
        	});
    	}
    	
    	return false;
    });
    
    jQuery('#pp_export_current_button').on( 'click', function(){
    	jQuery('#pp_export_current').val(1);
    });
    
    jQuery('#ppb_export_current_button').on( 'click', function(){
    	jQuery('#ppb_export_current').val(1);
    });
    
    jQuery('#ppb_import_current_button').on( 'click', function(){
    	jQuery('#ppb_import_current').val(1);
    });
    
    jQuery('#pp_advance_clear_cache').on( 'click', function(){
    	if(confirm('Are you sure you want to clear all cache'))
    	{
    		sTarget = jQuery(this).attr('href');
    		
    		jQuery.ajax({
        		type: 'POST',
        		url: sTarget,
        		data: 'method=clear_cache',
        		success: function(msg){ 
        			jQuery('#pp_advance_clear_cache').html('Cache files were successfully cleared.');
        			jQuery('#pp_advance_clear_cache').attr("disabled", "disabled");
        		}
        	});
    	}
    	
    	return false;
    });
    
    if(jQuery('#pp_custom_css').length > 0)
    {
	    var editor = CodeMirror.fromTextArea(document.getElementById("pp_custom_css"));
		setTimeout(function() {
		    editor.refresh();
		},1);
	}
	
	if(jQuery('#pp_custom_css_tablet_portrait').length > 0)
    {
		var editor2 = CodeMirror.fromTextArea(document.getElementById("pp_custom_css_tablet_portrait"));
		setTimeout(function() {
		    editor2.refresh();
		},1);
	}
	
	if(jQuery('#pp_custom_css_mobile_landscape').length > 0)
    {
		var editor3 = CodeMirror.fromTextArea(document.getElementById("pp_custom_css_mobile_landscape"));
		setTimeout(function() {
		    editor3.refresh();
		},1);
	}
	
	if(jQuery('#pp_custom_css_mobile_portrait').length > 0)
    {
		var editor4 = CodeMirror.fromTextArea(document.getElementById("pp_custom_css_mobile_portrait"));
		setTimeout(function() {
		    editor4.refresh();
		},1);
	}
    
    jQuery('#pp_panel a').on( 'click', function(){
    	jQuery('#pp_panel a').removeClass('nav-tab-active');
    	jQuery(this).addClass('nav-tab-active');
    	
    	jQuery('.rm_section').css('display', 'none');
    	jQuery(jQuery(this).attr('href')).fadeIn();
    	jQuery('#current_tab').val(jQuery(this).attr('href'));
    	
    	setTimeout(function() {
		    editor.refresh();
		},1);
		
		setTimeout(function() {
		    editor2.refresh();
		},1);
		
		setTimeout(function() {
		    editor3.refresh();
		},1);
		
		setTimeout(function() {
		    editor4.refresh();
		},1);
    	
    	return false;
    });
    
    jQuery('.color_picker').each(function()
	{	
	    var inputID = jQuery(this).attr('id');
	    
	    jQuery(this).ColorPicker({
	    	color: jQuery(this).val(),
	    	onShow: function (colpkr) {
	    		jQuery(colpkr).fadeIn(200);
	    		return false;
	    	},
	    	onHide: function (colpkr) {
	    		jQuery(colpkr).fadeOut(200);
	    		return false;
	    	},
	    	onChange: function (hsb, hex, rgb, el) {
	    		jQuery('#'+inputID).val('#' + hex);
	    		jQuery('#'+inputID+'_bg').css('backgroundColor', '#' + hex);
	    	}
	    });	
	    
	    jQuery(this).css('float', 'left');
	});
	
	var elems = document.querySelectorAll('.iphone_checkboxes');

	for (var i = 0; i < elems.length; i++) {
	  var switchery = new Switchery(elems[i], { color: '#1C58F6', size: 'small' });
	}
	
	jQuery('.CodeMirror').trigger('click');
		
	jQuery('.rm_section').css('display', 'none');
    
    //if URL has #
    if(self.document.location.hash != '')
	{
		//Check if Instagram request
		var stringAfterHash = self.document.location.hash.substr(1);
		var hashDataArr = stringAfterHash.split('=');
		
		//If not access token
		if(hashDataArr[0] != 'access_token')
		{
		    jQuery('html, body').stop().animate({scrollTop:0}, 'fast');
		    jQuery('.nav-tab').removeClass('nav-tab-active');
		    jQuery('a'+self.document.location.hash+'_a').addClass('nav-tab-active');
		    jQuery('div'+self.document.location.hash).css('display', 'block');
		    jQuery('#current_tab').val(self.document.location.hash);
		}
		else
		{
			var instagarmAccessToken = hashDataArr[1];
			jQuery('#pp_instagram_access_token').val(instagarmAccessToken);
			
			jQuery('.nav-tab').removeClass('nav-tab-active');
		    jQuery('a#pp_panel_social-profiles_a').addClass('nav-tab-active');
		    jQuery('div#pp_panel_social-profiles').css('display', 'block');
		    jQuery('#current_tab').val('#pp_panel_social-profiles');
		    
		    setTimeout(function() {
				jQuery('#save_ppsettings').trigger('click');
            }, 500);
		}
	}
	else
	{
	    jQuery('div#pp_panel_home').css('display', 'block');
	}
    
    jQuery( ".pp_sortable" ).sortable({
	    placeholder: "ui-state-highlight",
	    create: function(event, ui) { 
	    	myCheckRel = jQuery(this).attr('rel');
	    
	    	var order = jQuery(this).sortable('toArray');
        	jQuery('#'+myCheckRel).val(order);
	    },
	    update: function(event, ui) {
	    	myCheckRel = jQuery(this).attr('rel');
	    
	    	var order = jQuery(this).sortable('toArray');
        	jQuery('#'+myCheckRel).val(order);
	    }
	});
	jQuery( ".pp_sortable" ).disableSelection();
	
	jQuery(".pp_checkbox input").change(function(){
	    myCheckId = jQuery(this).val();
	    myCheckRel = jQuery(this).attr('rel');
	    myCheckTitle = jQuery(this).attr('alt');
	    
	    if (jQuery(this).is(':checked')) { 
	    	jQuery('#'+myCheckRel).append('<li id="'+myCheckId+'_sort" class="ui-state-default">'+myCheckTitle+'</li>');
	    } 
	    else
	    {
	    	jQuery('#'+myCheckId+'_sort').remove();
	    }

	    var order = jQuery('#'+myCheckRel).sortable('toArray');

        jQuery('#'+myCheckRel+'_data').val(order);
	});
	
	jQuery(".pp_sortable_button").on( 'click', function(){
	    var targetSelect = jQuery('#'+jQuery(this).attr('data-rel'));
	    
	    myCheckId = targetSelect.find("option:selected").val();
	    myCheckRel = targetSelect.find("option:selected").attr('data-rel');
	    myCheckTitle = targetSelect.find("option:selected").attr('title');

	    if (jQuery('#'+myCheckRel).children('li#'+myCheckId+'_sort').length == 0)
	    {
	    	jQuery('#'+myCheckRel).append('<li id="'+myCheckId+'_sort" class="ui-state-default"><div class="title">'+myCheckTitle+'</div><a data-rel="'+myCheckRel+'" href="javascript:removeSortRecord(\''+myCheckId+'\', \''+myCheckRel+'\');" class="remove">x</a><br style="clear:both"/></li>');
	    	//jQuery('#'+myCheckId+'_sort').remove();
	    	
	    	var order = jQuery('#'+myCheckRel).sortable('toArray');
        	jQuery('#'+myCheckRel+'_data').val(order);
        }
        else
        {
        	alert('You have already added "'+myCheckTitle+'"');
        }
	});
	
	jQuery(".pp_sortable li a.remove").on( 'click', function(){
	    jQuery(this).parent('li').remove();
	    var order = jQuery('#'+jQuery(this).attr('data-rel')).sortable('toArray');
        jQuery('#'+jQuery(this).attr('data-rel')+'_data').val(order);
	});
    
    jQuery(".pp_font").change(function(){
    	var valueElement = jQuery(this).data('value');
    	var sampleElement = jQuery(this).data('sample');
    	jQuery("#"+valueElement).attr('value', jQuery(this).children("option:selected").attr('data-family'));
    
    	var ppGGFont = 'http://fonts.googleapis.com/css?family='+jQuery(this).val();
    	jQuery('head').append('<link rel="stylesheet" id="google_fonts_'+valueElement+'" href="'+ppGGFont+'" type="text/css" media="all">');
    	
    	if(jQuery(this).children("option:selected").attr('data-family') != '')
    	{
    		jQuery('#'+sampleElement).css('font-family', '"'+jQuery(this).children("option:selected").attr('data-family')+'"');
    	}
    });
    
    jQuery(".pp_font").each(function(){
    	jQuery(this).trigger('change');
    });
    
    jQuery('#ppb_tab').tabs();
    jQuery('.ppb_tab').tabs();
    jQuery('#ppb_import_tab').tabs();
        
    var formfield = '';
	
	jQuery('.metabox_upload_btn').on( 'click', function() {
	    jQuery('.fancybox-overlay').css('visibility', 'hidden');
	    jQuery('.fancybox-wrap').css('visibility', 'hidden');
     	formfield = jQuery(this).attr('rel');
	    
	    var send_attachment_bkp = wp.media.editor.send.attachment;
	    wp.media.editor.send.attachment = function(props, attachment) {
	     	jQuery('#'+formfield).attr('value', attachment.url);
	
	        wp.media.editor.send.attachment = send_attachment_bkp;
	        jQuery('.fancybox-overlay').css('visibility', 'visible');
	     	jQuery('.fancybox-wrap').css('visibility', 'visible');
	    }
	
	    wp.media.editor.open();
     	return false;
    });
    
    jQuery("input.upload_text").on( 'click', function() { jQuery(this).select(); } );
	
	ppbBuildItem();
	ppbBuildEdit();
	
	//Open add content lightbox
	jQuery("#ppb_module_wrapper li").on( 'click', function(){
		//Prepare selected module data
		jQuery('#ppb_module_wrapper li').removeClass('selected');
		jQuery(this).addClass('selected');
		
		var moduleSelectedId = jQuery(this).data('module');
		var moduleSelectedTitle = jQuery(this).data('title');
		
		jQuery('#ppb_options').val(moduleSelectedId);
		jQuery('#ppb_options_title').val(moduleSelectedTitle);
	
		//Open selected module lightbox options
	    var targetSelect = jQuery('#ppb_options');
	    var targetTitle = jQuery('#ppb_options_title');
	    var targetType = jQuery('#ppb_module_'+targetSelect.val()).data('type');
	    var targetShortcode = jQuery(this).data('shortcode');
	    var targetIcon = jQuery(this).data('icon');
	    
	    randomId = jQuery.now();
	    myCheckId = targetSelect.val();
	    myCheckTitle = targetTitle.val();
	    postType = jQuery('#ppb_post_type').val();
	    
	    if(typeof targetType === 'undefined'){
			targetType = 'module'; 
		};
		
		jQuery.fancybox.close();
	    
	    //If select content builder module
	    if(myCheckId != '' && targetType == 'module')
	    {
	    	var builderItemData = {};
	    	builderItemData.id = randomId;
	    	builderItemData.shortcode = myCheckId;
	    	builderItemData.ppb_text_title = myCheckTitle;
	    	builderItemData.ppb_text_content = '';
	    	builderItemData.ppb_header_content = '';
	    	var builderItemDataJSON = JSON.stringify(builderItemData);
	
	    	builderItem = '<li id="'+randomId+'" class="ui-state-default one '+myCheckId+'" data-current-size="one">';
	    	builderItem+= '<div class="size"><a href="javascript:;" class="ppb_plus button">+</a>';
	    	builderItem+= '<a href="javascript:;" class="ppb_minus button">-</a></div>';
	    	builderItem+= '<div class="thumb"><img src="'+targetIcon+'" alt=""></div>';
	    	builderItem+= '<div class="title"><div class="shortcode_title">'+targetShortcode+'</div>'+myCheckTitle+'</div>';
	    	
	    	//Display module action
	    	builderItem+= '<div class="item_action">';
	    	
	    	//Display remove button
	    	builderItem+= '<a href="javascript:;" class="ppb_remove"><i class="fa fa-trash"></i></a>';
			
			//Display edit button
	    	var editURL = tgAjax.ajaxurl+'?action=grandtour_ppb&ppb_post_type='+postType+'&shortcode='+myCheckId+'&rel='+randomId+'&width=800&height=900&page_id='+jQuery('#ppb_page_id').val()+'&builder_action=add';
	    	builderItem+= '<a data-rel="'+randomId+'" href="'+editURL+'" class="ppb_edit"><i class="fa fa-edit"></i></a>';
	    	
	    	//Display add after button
	    	builderItem+= '<a data-rel="'+randomId+'" href="javascript:;" class="ppb_add_after"><i class="fa fa-plus"></i></a>';
	    	
	    	//End display module action
	    	builderItem+= '</div>';
	    	
	    	builderItem+= '<input type="hidden" class="ppb_setting_columns" value="one_fourth"/>';
	    	builderItem+= '</li>';
			
			var addAfter = jQuery('#ppb_sortable_add_button').attr('data-after');
			
			if(addAfter == '')
			{
	    		jQuery('#content_builder_sort').append(builderItem);
	    	}
	    	else
	    	{
	    		jQuery('#content_builder_sort').find('li#'+addAfter).after(builderItem);
	    		
	    		//Remove helper
	    		jQuery('#content_builder_sort').find('li#'+addAfter).next('li.ppb_add_after_helper').remove();
	    	}
	    	
	    	jQuery('#content_builder_sort').removeClass('empty');
	    	jQuery('#'+randomId).data('ppb_setting', builderItemDataJSON);
	    	
	    	ppbBuildItem();
	    	ppbBuildEdit();
	    	jQuery('.tooltipster').tooltipster();
	    	
	    	var prev1Li = jQuery('#'+randomId).prev();
	        var prev2Li = prev1Li.prev();
	        var prev3Li = prev2Li.prev();
	        
	        if(prev1Li.attr('data-current-size')=='one_third' && prev2Li.attr('data-current-size')=='one_third')
	    	{
	        	jQuery('#'+randomId).attr('data-current-size', 'one_third last');
	        	jQuery('#'+randomId).find('.ppb_setting_columns').attr('value', 'one_third last');
	
	    	}
	    	
	    	if(myCheckId!='ppb_divider' && myCheckId!='ppb_empty_line')
	    	{
	    		jQuery('#'+randomId).find('.ppb_edit').trigger('click');
	    	}
	    	//If add divider then refresh frame
	    	else
	    	{
	    		ppbSetUnsaveStatus();
	    	
	    		//Save all content
				ppbSaveAll();
	    	
	    		//Set preview frame data
				ppbSetPreviewData();
				
				//Reload preview frame
				ppbReloadPreview();
	    	}
	    }
	    
	    //Remove get started content
	    jQuery('#ppb_add_content_wrapper_started').hide();
	    jQuery('#ppb_sortable_template_button').hide();
	    jQuery('#ppb_sortable_add_button').addClass('not_started');
	    jQuery('#ppb_sortable_add_button').attr('data-after', '');
	    
	    return false;
	});
	
	//Import selected demo templates
	jQuery("#ppb_demo_pages_wrapper li a.confirm_import").on( 'click', function(){
		if(confirm('Are you sure you want to import this demo page. All current content builder data for this page will be overwrite? (this can not be undone)'))
		{
			//Prepare selected module data
			jQuery('#ppb_demo_pages_wrapper li').removeClass('selected');
			jQuery(this).parent('li').addClass('selected');
			
			var moduleSelectedId = jQuery(this).parent('li').data('module');
			var moduleSelectedTitle = jQuery(this).parent('li').data('title');
			
			jQuery('#ppb_options').val(moduleSelectedId);
			jQuery('#ppb_options_title').val(moduleSelectedTitle);
		    jQuery('#ppb_import_current').val(1);
		    
		    var targetSelect = jQuery('#ppb_options');
		    var demoPageFile = jQuery('#ppb_demo_page_'+targetSelect.val()).data('file');
		    
		    jQuery('#ppb_import_demo_file').val(demoPageFile);
		    jQuery('#ppb_import_current_button').trigger('click');
		}
	});
	
	//Import selected my template
	jQuery("#ppb_my_templates_wrapper li").on( 'click', function(){
		if(confirm('Are you sure you want to import this demo page. All current content builder data for this page will be overwrite? (this can not be undone)'))
		{
			//Prepare selected module data
			var templateKey = jQuery(this).data('key');
		    
		    jQuery('#ppb_import_current').val(1);
		    jQuery('#ppb_import_template_key').val(templateKey);
		    jQuery('#ppb_import_current_button').trigger('click');
		}
	});
	
	//Remove selected my template
	jQuery("#ppb_my_templates_wrapper li a.delete_link").on( 'click', function(e){
		e.stopPropagation();
		e.preventDefault();
		var selectedTemplate = jQuery(this).parent('li');
		
		if(confirm('Are you sure you want to remove this template? (this can not be undone)'))
		{
			e.stopPropagation();
			e.preventDefault();
			var actionURL = jQuery(this).attr('href');
		
			//Remove template in AJAX
			jQuery.ajax({
			  type: "POST",
			  cache: false,
			  url: actionURL,
			  data: '',
			  success: function (data) {
			  	if(data != '')
			  	{
				  	selectedTemplate.remove();
			  	}
			  } 
			});
		}
	});
	
	jQuery('#ppb_save').on( 'click', function(e){
		e.preventDefault();
		showLoading();
		jQuery(this).addClass('inactive');
		jQuery('#wpwrap').append('<div class="fancybox-overlay"></div>');
		
		//Save all content
		ppbSaveAll();
		
		//Get current data string
		var actionURL = jQuery(this).attr('href');
		var dataString = ppbGetDataString();
		var dataSizeString = ppbGetDataSizeString();
		
		var itemOrder = jQuery("#content_builder_sort").sortable('toArray');
		jQuery('#ppb_form_data_order').attr('value', itemOrder);
		
		//Save post in AJAX
		jQuery.ajax({
		  type: "POST",
		  cache: false,
		  url: actionURL,
		  data: 'data_order='+jQuery('#ppb_form_data_order').val()+dataString+dataSizeString,
		  success: function (data) {
		  	hideLoading();
		    ppbRemoveUnsaveStatus();
		  } 
		});
	});
	
	jQuery('#ppb_add').on( 'click', function(){
		jQuery('#ppb_sortable_add_button').trigger('click');
	});
	
	jQuery('#ppb_sortable_add_button').on( 'click', function(){
		showLoading();
	});
	
	jQuery('#publish').on( 'click', function(){
		jQuery(window).unbind('beforeunload');
		ppbSaveAll();
	})
	
	jQuery('#ppb_undo').on( 'click', function(){
		ppbGetHistory('undo');
	});
	
	jQuery('#ppb_redo').on( 'click', function(){
		ppbGetHistory('redo');
	});
	
	jQuery(".pp_fancybox_inline_fullheight").on( 'click', function(){
		showLoading();
	});
	
	jQuery('#ppb_preview_page').on( 'click', function(){
		//If not in live mode
		if(!isLiveMode())
		{
			jQuery(window).unbind('beforeunload');
			
			//Save all content
			ppbSaveAll();
		
			//Get current data string
			var dataString = ppbGetDataString();
			var dataSizeString = ppbGetDataSizeString();
		    
		    var itemOrder = jQuery("#content_builder_sort").sortable('toArray');
		    jQuery('#ppb_form_data_order').attr('value', itemOrder);
		    
		    //Temporary call AJAX to save current content builder data
		    jQuery.fancybox.showLoading();
			var actionURL = jQuery(this).data('action');
			var previewURL = jQuery(this).data('preview');
			var pageID = jQuery(this).data('page');
			var fancyboxMargin = 32;
			
			jQuery.ajax({
		      type: "POST",
		      cache: false,
		      url: actionURL,
			  data: 'page_id='+pageID+'&data_order='+jQuery('#ppb_form_data_order').val()+dataString+dataSizeString,
		      success: function (data) {
		        	jQuery.ajax({
				      type: "GET",
				      cache: false,
				      url: previewURL,
				      data: 'rel='+pageID,
				      success: function (data) {
				        jQuery.fancybox(data, {
				          fitToView: false,
				          width: 1024,
				          minHeight: '100%',
				          margin: fancyboxMargin,
				          autoSize: false,
				          autoResize: true,
				          autoHeight: true,
				          closeClick: false,
				          openEffect: 'none',
				          closeEffect: 'none',
				          helpers : {
						    	overlay : {
						            css : {
						                'background-color' : 'rgba(0, 0, 0, 0.2)'
						            }
						        }
						   },
				          padding: 0
				        }); 
				      } 
				    });
		      } 
		    });
		} 
		//If in live mode
		else {
			jQuery(this).toggleClass('active');
			jQuery('#content_builder_classic_wrapper').toggleClass('hide');
			jQuery('#ppb_live_preview_frame_wrapper').toggleClass('expand');
			parent.triggerResize();
		}
	    
	    return false;
	});
	
	jQuery('#ppb_preview_devices a.ppb_device').on('click', function(){
		if(!jQuery(this).hasClass('active'))
		{
			jQuery('#ppb_preview_devices a.ppb_device').removeClass('active');
			jQuery(this).addClass('active');
			
			var selectedDevice = jQuery(this).data('preview');
			jQuery('#ppb_live_preview_frame_wrapper').attr('rel', selectedDevice);
			
			if(jQuery(window).height() > 1080 && selectedDevice == 'ppb_preview_tablet')
			{
				jQuery('#ppb_live_preview_frame_wrapper').css('margin-top', 'auto');
				jQuery('#ppb_live_preview_frame_wrapper').vercenter();
			}
			else
			{
				jQuery('#ppb_live_preview_frame_wrapper').css('margin-top', 'auto');
			}
			
			//Reload preview frame
			ppbReloadPreview();
		}
	});
	
	jQuery('#ppb_page_title_header').on('mouseenter', function(){
		jQuery('#ppb_page_option_wrapper').addClass('expand');
	});
	
	jQuery('#ppb_page_title_header').on('mouseleave', function(){
		jQuery('#ppb_page_option_wrapper').removeClass('expand');
	});
	
	jQuery('#ppb_page_menu_transparent').on('ifToggled', function(event){
		var checked = jQuery(this).parent('[class*="icheckbox"]').hasClass("checked");
		var checkedData = 1;

		//If checked
		if(!checked) 
		{
		  	checkedData = 1;
		}
		//If unchecked
		else
		{
			checkedData = 0;
		}
	
		var actionURL = jQuery(this).attr('data-action');
		
		//Save post in AJAX
		jQuery.ajax({
		  type: "POST",
		  cache: false,
		  url: actionURL,
		  data: 'field=page_menu_transparent&data='+checkedData,
		  success: function (data) {
		  	//If checked
			if(!checked) 
			{
			  	jQuery('#page_menu_transparent').parent('[class*="icheckbox"]').addClass("checked");
			}
			//If unchecked
			else
			{
				jQuery('#page_menu_transparent').parent('[class*="icheckbox"]').removeClass("checked");
			}
		  
		  	//Reload preview frame
			ppbReloadPreview();
		  } 
		});
	});
	
	jQuery('#ppb_page_show_title').on('ifToggled', function(event){
		var checked = jQuery(this).parent('[class*="icheckbox"]').hasClass("checked");
		var checkedData = 1;

		//If checked
		if(!checked) 
		{
		  	checkedData = 1;
		}
		//If unchecked
		else
		{
			checkedData = 0;
		}
	
		var actionURL = jQuery(this).attr('data-action');
		
		//Save post in AJAX
		jQuery.ajax({
		  type: "POST",
		  cache: false,
		  url: actionURL,
		  data: 'field=page_show_title&data='+checkedData,
		  success: function (data) {
		  	//If checked
			if(!checked) 
			{
			  	jQuery('#page_show_title').parent('[class*="icheckbox"]').addClass("checked");
			}
			//If unchecked
			else
			{
				jQuery('#page_show_title').parent('[class*="icheckbox"]').removeClass("checked");
			}
		  
		  	//Reload preview frame
			ppbReloadPreview();
		  } 
		});
	});
	
	jQuery(window).resize(function() {
		if(jQuery(this).height() > 1080 && jQuery('#ppb_live_preview_frame_wrapper').attr('rel') == 'ppb_preview_tablet')
		{
			jQuery('#ppb_live_preview_frame_wrapper').css('margin-top', 'auto');
			jQuery('#ppb_live_preview_frame_wrapper').vercenter();
		}
		else
		{
			jQuery('#ppb_live_preview_frame_wrapper').css('margin-top', 'auto');
		}
	});
	
	jQuery('#ppb_sortable_save_template_button').on( 'click', function(e){
		e.preventDefault();
		jQuery(this).hide();
		jQuery('#template_save_form').show();
		triggerResize();
	});
	
	jQuery('#ppb_do_save_template_button').on( 'click', function(e){
		e.preventDefault();
		
		var newTemplateName = jQuery('#ppb_new_template_name').val();
		
		//If template name has more than 3 characters
		if(newTemplateName.length >= 3)
		{
			var actionURL = jQuery(this).attr('href');
			jQuery.fancybox.showLoading();
			
			jQuery.ajax({
			  type: "POST",
			  cache: false,
			  url: actionURL,
			  data: 'template_name='+newTemplateName,
			  success: function (data) {
			    jQuery.fancybox.hideLoading();
			    
			    //If not empty add new template block
			    if(data != '')
			    {
			    	var newTemplateKey = data;
			    	var newTemplateHTMLBlock = '';
			    	newTemplateHTMLBlock+= '<li id="ppb_my_page_'+newTemplateKey+'" data-module="'+newTemplateKey+'" data-title="'+newTemplateName+'" data-key="'+newTemplateKey+'">';
					newTemplateHTMLBlock+= '<a href="javascript:;" class="confirm_import"><div class="builder_title">'+newTemplateName+'</div></a>';
					newTemplateHTMLBlock+= '</li>';
			    
				    jQuery('#ppb_my_templates_wrapper').append(newTemplateHTMLBlock);
				    
				    jQuery('#ppb_new_template_name').val('');
			    }
			  } 
			});
		}
		else
		{
			jQuery('#ppb_new_template_name').focus();
		}
	});
	
	jQuery(".ppb_sortable").each(function(){
		if(jQuery(this).attr('id') == 'content_builder_sort')
		{
			jQuery(this).sortable({
				helper: "clone",
			    start: function(event, ui) {
			        
			    },
			    stop: function(event, ui) {
			    	//Update all elements size
			    	ppbUpdateAllSize();
			    
			        //Save all content
					ppbSaveAll();
		    	
		    		//Set preview frame data
					ppbSetPreviewData();
					
					//Reload preview frame
					ppbReloadPreview();
					
					ppbSetUnsaveStatus();
			    }
			});
		}
		else
		{
			jQuery(this).sortable({
				helper: "clone",
				placeholder: "sortable-placeholder"
			});
		}
		
		jQuery(this).disableSelection();
	});
	
	jQuery(window).scroll(function(){
	    if(jQuery(this).scrollTop() >= 100){
	    	jQuery('.header_wrap').addClass('fixed');
	    }
	    else if(jQuery(this).scrollTop() < 100)
	    {
	        jQuery('.header_wrap').removeClass('fixed');
	    }
	});
	
	//Enable content builder button click
	jQuery('#enable_builder').on( 'click', function(){
	    jQuery('#ppb_enable').val(1);
	    
	    jQuery('#postdivrich').hide();
	    jQuery('#preview-action').hide();
	    jQuery('#page_option_page_custom_template').hide();
	    
	    jQuery('#page_template').val('default');
	    jQuery('#page_template').attr('disabled','disabled');
	    jQuery('#content_metabox').addClass('visible');
	    
	    jQuery(this).addClass('hidden');
	    jQuery('#enable_classic_builder').addClass('visible');
	    
	    //if new page then save as draft first so we can preview
	    if(jQuery(this).data('page-id') == '')
	    {
		    //Save as draft first
		    jQuery('#save-post').trigger('click');
	    }
	});
	
	//Enable classic editor button click
	jQuery('#enable_classic_builder').on( 'click', function(){
	    jQuery('#ppb_enable').val(0);
	    
	    jQuery('#postdivrich').show();
	    jQuery('#preview-action').show();
	    jQuery('#page_option_page_custom_template').show();
	    
	    jQuery('#page_template').removeAttr('disabled','disabled');
	    jQuery('#content_metabox').removeClass('visible');
	    
	    jQuery('#enable_builder').removeClass('hidden');
	    jQuery('#enable_classic_builder').removeClass('visible');
	    
	    jQuery(window).trigger('resize');
	});
	
	jQuery('#pp_import_default_button').on( 'click', function(){
	    jQuery('#pp_import_default').val(1);
	});
	
	jQuery('#import_demo li').on( 'click', function(){
	    jQuery('#import_demo li').removeClass('selected');
	    jQuery(this).addClass('selected');
	    
	    var selectedDemo = jQuery(this).data('demo');
	    jQuery('#pp_import_demo').val(selectedDemo);
	});
	
	jQuery('#import_demo_content li').on( 'click', function(){
	    jQuery('#import_demo_content li').removeClass('selected');
	    jQuery(this).addClass('selected');
	    
	    var selectedDemo = jQuery(this).data('demo');
	    jQuery('#grandtour_import_demo_content').val(selectedDemo);
	});
	
	jQuery('.pp_import_content_button').on( 'click', function(){
		if(jQuery(this).data('demo')=='')
		{
			alert('Please select demo content you want to import');
			return false;
		}
		
		var selectDemo = jQuery(this).data('demo');
	
	    import_true = confirm('Are you sure to import demo content? it will overwrite the existing data');
        if(import_true == false) return;

        jQuery('.import_message').show();
       
        var data = {
            'action': 'grandtour_import_demo_content',
            'demo': selectDemo
        };

        jQuery.post(ajaxurl, data, function(response) {
            jQuery('.import_message').html('<div class="import_message_success"><span class="dashicons dashicons-yes"></span>All done.</div>');
            //jQuery('.import_message').html('<div class="import_message_success">'+response+'</div>');
            
            jQuery('.import_message').addClass('clickable');
            jQuery('.import_message.clickable').on( 'click', function(e){
				jQuery(this).hide();
			});
        });
	});
	
	jQuery("#ppb_sortable_preview_button").on( 'click', function(e){
		e.preventDefault();
		var demoKey = jQuery('#ppb_module_wrapper li.selected').first().data('key');
		var actionURL = jQuery(this).attr('href');
		jQuery.fancybox.showLoading();
		
		jQuery.ajax({
		  type: "POST",
		  cache: false,
		  url: actionURL,
		  data: 'key='+demoKey,
		  success: function (data) {
		    jQuery.fancybox(data, {
		      fitToView: false,
		      width: 1024,
		      minHeight: '100%',
		      autoSize: false,
		      autoResize: true,
		      autoHeight: true,
		      closeClick: false,
		      openEffect: 'none',
		      closeEffect: 'none',
		      padding: 0
		    }); 
		  } 
		});
	
		return false;
	});
	
	//Initiate all builder blocks events
	refreshBuilderBlockEvents();
	
	//Open live mode
	jQuery('#ppb_live').on( 'click', function(e){
		jQuery(this).hide();
		jQuery('#ppb_classic').css('display', 'inline-block');
		jQuery('#ppb_refresh').css('display', 'inline-block');
		jQuery('#ppb_page_content').addClass('live');
		jQuery('#ppb_open_dev_bar').addClass('active');
		jQuery('body').addClass('ppb_live');
		jQuery('#ppb_edit_mode').val('live');
		jQuery.fancybox.showLoading();
		
		//Save all content
		ppbSaveAll();
		
		//Set preview frame data
		ppbSetPreviewData();
	
		//Set preview frame source URL
		var previewURL = jQuery('#ppb_live_preview_frame').data('preview');
		jQuery('#ppb_live_preview_frame').attr('src', previewURL);
	    
	    return false;
	});
	
	jQuery('#ppb_classic').on( 'click', function(e){
		jQuery(this).hide();
		jQuery('#ppb_refresh').hide();
		jQuery('#ppb_live').css('display', 'inline-block');
		jQuery('#ppb_page_content').removeClass('live');
		jQuery('body').removeClass('ppb_live');
		jQuery('#ppb_edit_mode').val('classic');
		
		//Remove frame content
		jQuery('#ppb_live_preview_frame').removeClass('live');
		jQuery('#ppb_live_preview_frame').attr('src', '');
		
		jQuery('#ppb_preview_page').removeClass('active');
		jQuery('#content_builder_classic_wrapper').removeClass('hide');
		jQuery('#ppb_live_preview_frame_wrapper').removeClass('expand');
	});
	
	jQuery('#ppb_refresh').on( 'click', function(e){
		ppbReloadPreview();
	});
	
	jQuery('#ppb_open_dev_bar').on( 'click', function(e){
		jQuery('#ppb_page_content.live #content_builder_classic_wrapper').toggleClass('hide');
		jQuery('#ppb_live_preview_frame_wrapper').toggleClass('expand');
		jQuery(this).toggleClass('active');
		triggerResize();
	});
	
	jQuery('#title').change(function() {
		jQuery('#ppb_page_link_title').html(jQuery(this).val());
	});
	
	jQuery('#pp_theme_go_update_bth').on( 'click', function(){
		update_true = confirm('Are you sure to update the theme?');
        if(update_true == false) return;

        jQuery('.update_message').show();
        jQuery(this).hide();
       
        var data = {
            'action': 'pp_update_theme'
        };

        jQuery.post(ajaxurl, data, function(response) {
            jQuery('.update_message').html('<div class="update_message_success">'+ response +'</div>');
        });
	});
	
	//Custom functions for handle tour options box
	var bookingMethod = jQuery('#tour_booking_method').val();
	switch(bookingMethod) 
	{
	    case 'contact_form7':
	        jQuery('#post_option_tour_booking_contactform7').show();
	        jQuery('#post_option_tour_booking_product').hide();
	        jQuery('#post_option_tour_booking_html').hide();
	        jQuery('#post_option_tour_booking_url').hide();
	    break;
	    
	    case 'woocommerce_product':
	        jQuery('#post_option_tour_booking_contactform7').hide();
	        jQuery('#post_option_tour_booking_product').show();
	        jQuery('#post_option_tour_booking_html').hide();
	        jQuery('#post_option_tour_booking_url').hide();
	    break;
	    
	    case 'external':
	        jQuery('#post_option_tour_booking_contactform7').hide();
	        jQuery('#post_option_tour_booking_product').hide();
	        jQuery('#post_option_tour_booking_html').hide();
	        jQuery('#post_option_tour_booking_url').show();
	    break;
	    
	    case 'html':
	        jQuery('#post_option_tour_booking_contactform7').hide();
	        jQuery('#post_option_tour_booking_product').hide();
	        jQuery('#post_option_tour_booking_url').hide();
	        jQuery('#post_option_tour_booking_html').show();
	    break;
	}
	
	jQuery('#tour_booking_method').on( 'change', function(){
		var bookingMethod = jQuery(this).val();
		switch(bookingMethod) 
		{
		    case 'contact_form7':
		        jQuery('#post_option_tour_booking_contactform7').show();
		        jQuery('#post_option_tour_booking_product').hide();
		        jQuery('#post_option_tour_booking_url').hide();
		        jQuery('#post_option_tour_booking_html').hide();
		    break;
		    
		    case 'woocommerce_product':
		        jQuery('#post_option_tour_booking_contactform7').hide();
		        jQuery('#post_option_tour_booking_product').show();
		        jQuery('#post_option_tour_booking_url').hide();
		        jQuery('#post_option_tour_booking_html').hide();
		    break;
		    
		    case 'external':
		        jQuery('#post_option_tour_booking_contactform7').hide();
		        jQuery('#post_option_tour_booking_product').hide();
		        jQuery('#post_option_tour_booking_url').show();
		        jQuery('#post_option_tour_booking_html').hide();
		    break;
		    
		    case 'html':
		        jQuery('#post_option_tour_booking_contactform7').hide();
		        jQuery('#post_option_tour_booking_product').hide();
		        jQuery('#post_option_tour_booking_url').hide();
		        jQuery('#post_option_tour_booking_html').show();
		    break;
		}
	});
	
	//Custom functions for handle tour options box
	var postType = jQuery('#tour_header_type').val();
	switch(postType) 
	{
	    case 'Vimeo Video':
	        jQuery('#post_option_tour_header_vimeo').show();
	        jQuery('#post_option_tour_header_youtube').hide();
	    break;
	    
	    case 'Youtube Video':
	        jQuery('#post_option_tour_header_youtube').show();
	        jQuery('#post_option_tour_header_vimeo').hide();
	    break;
	    
	    case 'Image':
	        jQuery('#post_option_tour_header_vimeo').hide();
	        jQuery('#post_option_tour_header_youtube').hide();
	    break;
	}
	
	jQuery('#tour_header_type').on( 'change', function(){
		var postType = jQuery(this).val();
		switch(postType) 
		{
		    case 'Vimeo Video':
		        jQuery('#post_option_tour_header_vimeo').show();
		        jQuery('#post_option_tour_header_youtube').hide();
		    break;
		    
		    case 'Youtube Video':
		        jQuery('#post_option_tour_header_youtube').show();
		        jQuery('#post_option_tour_header_vimeo').hide();
		    break;
		    
		    case 'Image':
		        jQuery('#post_option_tour_header_vimeo').hide();
		        jQuery('#post_option_tour_header_youtube').hide();
		    break;
		}
	});
	
	jQuery('#tour_days').on( 'change', function(){
		if(jQuery(this).val() == 1)
		{
			jQuery('#post_option_tour_available_days').show();
			jQuery('#post_option_tour_hours').show();
		}
		else
		{
			jQuery('#post_option_tour_available_days').hide();
			jQuery('#post_option_tour_hours').hide();
		}
	});
	
	if(jQuery('#tour_days').val() == 1)
	{
		jQuery('#post_option_tour_available_days').show();
		jQuery('#post_option_tour_hours').show();
	}
	else
	{
		jQuery('#post_option_tour_available_days').hide();
		jQuery('post_option_tour_hours').hide();
	}
	
	//Custom functions for handle page options box
	var postType = jQuery('#page_header_type').val();
	switch(postType) 
	{
	    case 'Vimeo Video':
	        jQuery('#page_option_page_header_vimeo').show();
	        jQuery('#page_option_page_header_youtube').hide();
	    break;
	    
	    case 'Youtube Video':
	        jQuery('#page_option_page_header_youtube').show();
	        jQuery('#page_option_page_header_vimeo').hide();
	    break;
	    
	    case 'Image':
	        jQuery('#page_option_page_header_vimeo').hide();
	        jQuery('#page_option_page_header_youtube').hide();
	    break;
	}
	
	jQuery('#page_header_type').on( 'change', function(){
		var postType = jQuery(this).val();
		switch(postType) 
		{
		    case 'Vimeo Video':
		        jQuery('#page_option_page_header_vimeo').show();
		        jQuery('#page_option_page_header_youtube').hide();
		    break;
		    
		    case 'Youtube Video':
		        jQuery('#page_option_page_header_youtube').show();
		        jQuery('#page_option_page_header_vimeo').hide();
		    break;
		    
		    case 'Image':
		        jQuery('#page_option_page_header_vimeo').hide();
		        jQuery('#page_option_page_header_youtube').hide();
		    break;
		}
	});
	
	//Custom functions for handle destination options box
	var postType = jQuery('#destination_header_type').val();
	switch(postType) 
	{
	    case 'Vimeo Video':
	        jQuery('#post_option_destination_header_vimeo').show();
	        jQuery('#post_option_destination_header_youtube').hide();
	    break;
	    
	    case 'Youtube Video':
	        jQuery('#post_option_destination_header_youtube').show();
	        jQuery('#post_option_destination_header_vimeo').hide();
	    break;
	    
	    case 'Image':
	        jQuery('#post_option_destination_header_vimeo').hide();
	        jQuery('#post_option_destination_header_youtube').hide();
	    break;
	}
	
	jQuery('#destination_header_type').on( 'change', function(){
		var postType = jQuery(this).val();
		switch(postType) 
		{
		    case 'Vimeo Video':
		        jQuery('#post_option_destination_header_vimeo').show();
		        jQuery('#post_option_destination_header_youtube').hide();
		    break;
		    
		    case 'Youtube Video':
		        jQuery('#post_option_destination_header_youtube').show();
		        jQuery('#post_option_destination_header_vimeo').hide();
		    break;
		    
		    case 'Image':
		        jQuery('#post_option_destination_header_vimeo').hide();
		        jQuery('#post_option_destination_header_youtube').hide();
		    break;
		}
	});
	
	//Custom functions for handle post options box
	var postType = jQuery('#post_ft_type').val();
	switch(postType) 
	{
	    case 'Vimeo Video':
	        jQuery('#post_option_post_ft_vimeo').show();
	        jQuery('#post_option_post_ft_gallery').hide();
	        jQuery('#post_option_post_ft_youtube').hide();
	    break;
	    
	    case 'Youtube Video':
	        jQuery('#post_option_post_ft_youtube').show();
	        jQuery('#post_option_post_ft_vimeo').hide();
	        jQuery('#post_option_post_ft_gallery').hide();
	    break;
	    
	    case 'Gallery':
	        jQuery('#post_option_post_ft_gallery').show();
	        jQuery('#post_option_post_ft_vimeo').hide();
	        jQuery('#post_option_post_ft_youtube').hide();
	    break;
	    
	    case 'Image':
	    	jQuery('#post_option_post_ft_gallery').hide();
	        jQuery('#post_option_post_ft_vimeo').hide();
	        jQuery('#post_option_post_ft_youtube').hide();
	    break;
	}
	
	jQuery('#post_ft_type').on( 'change', function(){
		var postType = jQuery(this).val();
		switch(postType) 
		{
		    case 'Vimeo Video':
	        jQuery('#post_option_post_ft_vimeo').show();
	        jQuery('#post_option_post_ft_gallery').hide();
	        jQuery('#post_option_post_ft_youtube').hide();
	    break;
	    
	    case 'Youtube Video':
	        jQuery('#post_option_post_ft_youtube').show();
	        jQuery('#post_option_post_ft_vimeo').hide();
	        jQuery('#post_option_post_ft_gallery').hide();
	    break;
	    
	    case 'Gallery':
	        jQuery('#post_option_post_ft_gallery').show();
	        jQuery('#post_option_post_ft_vimeo').hide();
	        jQuery('#post_option_post_ft_youtube').hide();
	    break;
	    
	    case 'Image':
	    	jQuery('#post_option_post_ft_gallery').hide();
	        jQuery('#post_option_post_ft_vimeo').hide();
	        jQuery('#post_option_post_ft_youtube').hide();
	    break;
		}
	});
	
	var pageTemplate = jQuery('#page_template').val();
	switch(pageTemplate) 
	{
	    case 'gallery.php':
	        jQuery('#page_option_page_gallery_id').show();
			jQuery('#page_option_page_ft_vimeo').hide();
			jQuery('#page_option_page_ft_youtube').hide();
	    break;
	    
	    case 'page-vimeo.php':
	        jQuery('#page_option_page_gallery_id').hide();
			jQuery('#page_option_page_ft_vimeo').show();
			jQuery('#page_option_page_ft_youtube').hide();
	    break;
	    
	    case 'page-youtube.php':
	        jQuery('#page_option_page_gallery_id').hide();
			jQuery('#page_option_page_ft_vimeo').hide();
			jQuery('#page_option_page_ft_youtube').show();
	    break;
	}
	
	jQuery("#page_template").change(function(){
		var pageTemplate = jQuery(this).val();
		
		if(pageTemplate == 'gallery.php')
		{
			jQuery('#page_option_page_gallery_id').show();
			jQuery('#page_option_page_ft_vimeo').hide();
			jQuery('#page_option_page_ft_youtube').hide();
			jQuery('#page_gallery_id').focus();
		}
		else if(pageTemplate == 'page-vimeo.php')
		{
			jQuery('#page_option_page_gallery_id').hide();
			jQuery('#page_option_page_ft_vimeo').show();
			jQuery('#page_option_page_ft_youtube').hide();
			jQuery('#page_ft_vimeo').focus();
		}
		else if(pageTemplate == 'page-youtube.php')
		{
			jQuery('#page_option_page_gallery_id').hide();
			jQuery('#page_option_page_ft_vimeo').hide();
			jQuery('#page_option_page_ft_youtube').show();
			jQuery('#page_ft_youtube').focus();
		}
	});
	
	jQuery('#get_styling_color_content li').on( 'click', function(){
		jQuery('.styling_message').show();
       
        var data = {
            'action': 'grandtour_get_styling',
            'styling': jQuery(this).attr('data-styling')
        };

        jQuery.post(ajaxurl, data, function(response) {
            jQuery('.styling_message').html('<div class="import_message_success"><span class="dashicons dashicons-yes"></span>All done!</div>');
            
            jQuery('.styling_message').addClass('clickable');
            jQuery('.styling_message.clickable').on( 'click', function(e){
				jQuery(this).hide();
			});
        });
	});
    
    jQuery('.pp_get_styling_button').on( 'click', function(){
	    if(jQuery(this).data('styling')=='')
		{
			alert('Please select styling you want to use');
			return false;
		}
		
		jQuery('.styling_message').show();
       
        var data = {
            'action': 'grandtour_get_styling',
            'styling': jQuery(this).attr('data-styling')
        };

        jQuery.post(ajaxurl, data, function(response) {
            jQuery('.styling_message').html('<div class="import_message_success"><span class="dashicons dashicons-yes"></span>All done!</div>');
            
            jQuery('.styling_message').addClass('clickable');
            jQuery('.styling_message.clickable').on( 'click', function(e){
				jQuery(this).hide();
			});
        });
	});
	
	jQuery('.tooltipster').tooltipster();
	
	jQuery('.meta_template_list li').on( 'click', function(){
		var selectedValue = jQuery(this).attr('data-value');
		var parentList = jQuery(this).attr('data-parent')+'_list';
		var parentID = jQuery(this).attr('data-parent');
		
		jQuery('#'+parentID).val(selectedValue);
		jQuery('#'+parentList+' li').removeClass('checked');
		jQuery(this).addClass('checked');
		
		if(jQuery(this).attr('data-type') == 'page')
		{
			jQuery("#page_template option").each(function(){
			    var currentPageTemplate = jQuery(this).text();
			
			    if(selectedValue == currentPageTemplate)
			    {
				    jQuery(this).attr('selected', true);
				    return false; 
			    }
			});
			
			if(selectedValue == 'Gallery')
			{
				jQuery('#page_option_page_gallery_id').show();
				jQuery('#page_option_page_ft_vimeo').hide();
				jQuery('#page_option_page_ft_youtube').hide();
				jQuery('#page_gallery_id').focus();
			}
			else if(selectedValue == 'Fullscreen Vimeo Video')
			{
				jQuery('#page_option_page_gallery_id').hide();
				jQuery('#page_option_page_ft_vimeo').show();
				jQuery('#page_option_page_ft_youtube').hide();
				jQuery('#page_ft_vimeo').focus();
			}
			else if(selectedValue == 'Fullscreen Youtube Video')
			{
				jQuery('#page_option_page_gallery_id').hide();
				jQuery('#page_option_page_ft_vimeo').hide();
				jQuery('#page_option_page_ft_youtube').show();
				jQuery('#page_ft_youtube').focus();
			}
		}
	});
	
	var selectedPageTemplate = jQuery('#page_template option:selected').text();
	jQuery("#page_template_list > li").each(function(){
	    var currentPageTemplate = jQuery(this).attr('data-value');
	
	    if(selectedPageTemplate == currentPageTemplate)
	    {
		    jQuery(this).addClass('checked');
		    return false; 
	    }
	});
	
	jQuery("#page_template").change(function(){
		var selectedPageTemplate = jQuery('#page_template option:selected').text();
		jQuery('#page_template_list li').removeClass('checked');
		
		jQuery("#page_template_list > li").each(function(){
		    var currentPageTemplate = jQuery(this).attr('data-value');
		
		    if(selectedPageTemplate == currentPageTemplate)
		    {
			    jQuery(this).addClass('checked');
			    return false; 
		    }
		});
	});
	
	jQuery('#ppb_template .ppb_tab ul.ui-tabs-nav li.ppb_tab_predefined_templates').on( 'click', function(){
		jQuery(window).trigger('resize');
	});
	
	jQuery(".adding_list_sortable tbody").sortable({
	    helper: "clone",
	    placeholder: "sortable-placeholder",
	    handle: ".sortable_handle"
	});
	addingListRemoveEvent();
});
