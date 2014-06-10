jQuery(document).ready(function()
{
	jQuery(document).bind("keydown", function(e)
	{ 
		if (e.which == 27)
		{
			
			document.getElementById("gb_lightbox_container_div").style.display="none";
			document.getElementById("gb_lightbox_overlay_div").style.display="none";
		}
	});
	jQuery(window).resize(function() 
	{
		resize_div();
	});
});

function ShowImage(imageId)
{
	var imagePath = "";
	var title = "";
	var description = "";
	var type = "";
    imagePath = imageFullPath + jQuery("#ux_img_div_"+imageId).attr("imgpath");
    title = jQuery("#ux_img_div_"+imageId).attr("data-title");
    description = jQuery("#ux_img_div_"+imageId).attr("desc");
    type = jQuery("#ux_img_div_"+imageId).find("img").attr("type");
    if(type == "video")
    {
        ShowVideo(imageId);
        return;
    }
	if(type != "video")
	{
		jQuery("#contentHolderDiv h5").empty();
		jQuery("#contentHolderDiv p").empty();
		
		jQuery("<img id=\"imgFull\" style=\"cursor:pointer;\" />").bind("load", function()
		{
			jQuery("#gb_lightbox_container_div").css("display","block");
			jQuery("#image_holder_div").html(this);
			if(title_settings == 1 || description_settings == 1 || fb_settings == 1)
			{
				jQuery("#contentHolderDiv").css("display","inline-block");
			}
			if(title_settings == 1 && title != "" )
			{
				jQuery("#contentHolderDiv h5").html(title);
			}
			if(description_settings == 1 && description != "")
			{
				jQuery("#contentHolderDiv p").html(description);
			}
			if(social_sharing == 1 && (title_settings == 1 || description_settings == 1 || fb_settings == 1))
			{
				jQuery("#contentHolderDiv ul").css("display","block");
				jQuery("#social_div").attr("addthis:url",""+imagePath+"");
				jQuery("#social_div").attr("addthis:title",""+title+"");
				jQuery("#social_div").attr("addthis:description",""+description+"");
			}
			if(fb_settings == 1)
			{
				jQuery("#contentHolderDiv .gb-facebook-comments").css("display","block");
				jQuery("#contentHolderDiv div#gb-facebook-comments").find("div.fb-comments").attr("data-href",""+imagePath+"");
				FB.XFBML.parse(jQuery("#gb-facebook-comments").get(0));
			}
            jQuery("#gallery_prev").attr("href","JavaScript:prev("+imageId+");");
            jQuery("#gallery_next").attr("href","JavaScript:next("+imageId+");");
			resize_div();
		}).attr("src", imagePath);
	}
}

function CloseLightbox(time)
{
	jQuery("#gb_lightbox_container_div").css("display","none");
	jQuery("#videoFull").attr("src","");
	jQuery("#gb_lightbox_overlay_div").fadeOut(time);
}

function resize_div()
{
	var windowHeight = window.innerHeight - 250;
	var windowWidth = window.innerWidth - 250;
	jQuery("#imgFull").css("max-width", "660px");
	//jQuery("#imgFull").css("width", windowWidth + "px");
	jQuery("#imgFull").css("max-height",windowHeight + "px");
	jQuery(".gb_content_holder").css("max-width",windowWidth + "px");
	jQuery(".gb_content_holder").css("max-height",windowHeight + "px");
	jQuery("#videoFull").css("max-width",windowWidth + "px");
	jQuery("#videoFull").css("max-height",windowHeight + "px");
	var lightboxHeight = jQuery("#gb_lightbox_container_div").height();
	var lightboxWidth = jQuery("#gb_lightbox_container_div").width();
	
	var proposedTop =  (window.innerHeight - 400 - 50) / 2 ;
	var proposedLeft =  (window.innerWidth - lightboxWidth - 50) / 2 ;
	jQuery("#gb_lightbox_container_div").css("top",proposedTop + "px");
	jQuery("#gb_lightbox_container_div").css("left",proposedLeft + "px");
}

function ShowVideo(imageId)
{
	var path = "";
	var video_title = "";
	var video_description = "";
	var type = "";
	
	path = jQuery("#ux_img_div_"+imageId).attr("imgpath");
    video_title = jQuery("#ux_img_div_"+imageId).attr("data-title");
    video_description = jQuery("#ux_img_div_"+imageId).attr("desc");
    type = jQuery("#ux_img_div_"+imageId).find("img").attr("type");
	if(type == "image")
	{
		ShowImage(imageId);
		return;
	}
	if(type != "image")
	{
		jQuery("#imgFull").attr("src","");
		jQuery("#videoFull").attr("src","");
		jQuery("#contentHolderDiv h5").empty();
		jQuery("#contentHolderDiv p").empty();
		var src;
		if(path.match(/youtube\.com\/watch/i))
		{
			src = "http://www.youtube.com/embed/"+path.split("v=")[1];
			playVideo(src,imageId,video_title,video_description);
			resize_div();
		}
		else if(path.match(/youtu\.be\//i))
		{
			src = "http://www.youtube.com/embed/"+path.split(".be/")[1];
			playVideo(src,imageId,video_title,video_description);
			resize_div();
		}
		else if(path.match( /(?:vimeo(?:pro)?.com)\/(?:[^\d]+)?(\d+)(?:.*)/))
		{
			src = "http://player.vimeo.com/video/"+path.split("/")[3];
			playVideo(src,imageId,video_title,video_description);
			resize_div();
		}
		else if(path.match( /dailymotion\.com/i))
		{
			src = "http://dailymotion.com/embed/video/"+path.split(/[_]/)[0].split("/")[4];
			playVideo(src,imageId,video_title,video_description);
			resize_div();
		}
		else if(path.match( /metacafe\.com\/watch/i))
		{
			src = "http://www.metacafe.com/fplayer/"+path.split("/")[4]+"/.swf?playerVars";
			playVideo(src,imageId,video_title,video_description);
			resize_div();
		}
		else if(path.match(/facebook\.com/i))
		{
			src = "https://www.facebook.com/video/embed?video_id="+path.split("v=")[1];
			playVideo(src,imageId,video_title,video_description);
			resize_div();
		}
		else if(path.match(/flickr\.com(?!.+\/show\/)/i))
		{
			src = "http://www.flickr.com/apps/video/stewart.swf?photo_id="+path.split("/")[5];
			//flicker(src,video_title,video_description);
			playVideo(src,imageId,video_title,video_description);
			resize_div();
		}
		else if(path.match(/tudou\.com/i))
		{
			src = "http://www.tudou.com/v/"+path.split("/")[5];
			playVideo(src,imageId,video_title,video_description);
			resize_div();
		}
		else
		{
			src = "Wrong url";
			playVideo(src,imageId);
			resize_div();
		}
	}
}
function playVideo(videoSrc,imageId,videoTitle,videoDescription)
{
	if(videoSrc == "Wrong url")
	{
		var iframe = jQuery("<iframe id=\"videoFull\" height=\"400px\" width=\"600px\" ></iframe>").bind("load", function()
		{
			jQuery("#gb_lightbox_container_div").css("display","block");
			jQuery("#contentHolderDiv").css("display","none");
			jQuery("#image_holder_div").html(this);
			jQuery("<h1> Not Found</h1>");
			jQuery("<p> The requested Url not found on the server.</p>");
			
			jQuery("#gallery_prev").attr("href","JavaScript:prev("+imageId+");");
			jQuery("#gallery_next").attr("href","JavaScript:next("+imageId+");");
		}).attr("src",videoSrc);
		jQuery("#image_holder_div").append(iframe);
		resize_div();
	}
	else
	{
		var iframe = jQuery("<iframe id=\"videoFull\" height=\"400px\" width=\"600px\" ></iframe>").bind("load", function()
		{
			jQuery("#gb_lightbox_container_div").css("display","block");
			jQuery("#image_holder_div").html(this);
			if(title_settings == 1 || description_settings == 1 || social_sharing == 1 || fb_settings == 1)
			{
				jQuery("#contentHolderDiv").css("display","inline-block");
			}
			if(title_settings == 1)
			{
				jQuery("#contentHolderDiv h5").html(videoTitle);
			}
			if(description_settings == 1)
			{
				jQuery("#contentHolderDiv p").html(videoDescription);
			}
			if(social_sharing == 1)
			{
				jQuery("#contentHolderDiv ul").css("display","block");
			}
			if(fb_settings == 1)
			{
				jQuery("#contentHolderDiv .gb-facebook-comments").css("display","block");
				jQuery("#contentHolderDiv div#gb-facebook-comments").find("div.fb-comments").attr("data-href",""+videoSrc+"");
				FB.XFBML.parse(jQuery("#gb-facebook-comments").get(0));
			}
			jQuery("#gallery_prev").attr("href","JavaScript:prev("+imageId+");");
			jQuery("#gallery_next").attr("href","JavaScript:next("+imageId+");");
		}).attr("src",videoSrc);
		jQuery("#image_holder_div").append(iframe);
		resize_div();
	}
}
function flicker(path,vidTitle,vidDesc)
{
	var object = jQuery("<object id=\"videoFull\" height=\"400px\" width=\"600px\" data=\""+path+"\" classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\"></object>").bind("load",function()
	{
		if ( !this.complete || this.naturalWidth == 0 ) 
		{
			jQuery( this ).trigger("load");
		}
		else
		{
			resize_div();
		}
	});
	jQuery("#gb_lightbox_container_div").append(object);
	var flash = jQuery("<param name=\"flashvars\" value=\"intl_lang=en-us&amp;photo_secret=17e24437ff&amp;photo_id=2405820614&amp;show_info_box=true\" ></param>");
	object.append(flash);
	var flash1 = jQuery(" <param name=\"movie\" value=\""+path+"\"></param>");
	object.append(flash1);
	var flash2 = jQuery("<param name=\"allowFullScreen\" value=\"true\"></param>");
	object.append(flash2);
	var flash3 = jQuery("<embed type=\"application/x-shockwave-flash\" src=\""+path+"\" flashvars=\"intl_lang=en-us&amp;photo_secret=17e24437ff&amp;photo_id=2405820614&amp;flickr_show_info_box=true\" width=\"400px\" height=\"400px\"></embed>");
	object.append(flash3);
	jQuery("#gb_lightbox_container_div").css("display","block");
	if(title_settings == 1 || description_settings == 1 || social_sharing == 1 || fb_settings == 1)
	{
		jQuery("#contentHolderDiv").css("display","inline-block");
	}
	if(title_settings == 1)
	{
		jQuery("#contentHolderDiv h5").html(vidTitle);
	}
	if(description_settings == 1)
	{
		jQuery("#contentHolderDiv p").html(vidDesc);
	}
	if(social_sharing == 1)
	{
		jQuery("#contentHolderDiv ul").css("display","block");
	}
	if(fb_settings == 1)
	{
		jQuery("#contentHolderDiv .gb-facebook-comments").css("display","block");
		jQuery("#contentHolderDiv div#gb-facebook-comments").find("div.fb-comments").attr("data-href",""+path+"");
		FB.XFBML.parse(jQuery("#gb-facebook-comments").get(0));
	}
	resize_div();
}

function prev(imageId)
{

    PrevimageId = jQuery("#ux_img_div_"+imageId).prev().find("img").attr("imageid");
	if(PrevimageId != undefined)
	{
    	ShowImage(PrevimageId);
 	}
	resize_div();
}

function next(imageId)
{

    NextimageId = jQuery("#ux_img_div_"+imageId).next().find("img").attr("imageid");
    if(NextimageId != undefined)
	{
		ShowImage(NextimageId);
	}
	resize_div();
}