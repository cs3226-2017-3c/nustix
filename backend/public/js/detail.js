var MAX_CONTENT_LENGTH = 35;
var captions;


function getCaptions(image_id, caption_id) {
	var url = "/caption?likes=1&image_id=";
	var has_selected_caption = false;
	url = url.concat(image_id);
	$.getJSON(url, function(data){
		captions = data;
		$.each(data, function(i, object){
			if (object['liked']) {
				liked[object['id']] = 1;
			} else {
				liked[object['id']] = 0;
			}

	  		var like_button = generateLikeBadge(object['id'], object['likes']);
	  		var caption_content = shrinkContent(object['content']);
	  		var li_content = caption_content + like_button;
      		
      		if (caption_id == object['id']) {
      			updateCaptionDisplay(object);
      			$("#all_caption").append("<a onclick=changeCaption(event) class='list-group-item active' href='#'>"+li_content+"</a>");
      			like_button = generateLike(object['id'], object['likes']);
				$("#likes").html(like_button);
				has_selected_caption = true;
      		} else {
      			$("#all_caption").append("<a onclick=changeCaption(event) class='list-group-item' href='#'>"+li_content+"</a>");
      		}
    	});

    	if (!has_selected_caption) {
    		$("div#all_caption").children().first().addClass("active");
    		updateCaptionDisplay(data[0]);
    		var like_button = generateLike(data[0]['id'], data[0]['likes']);
			$("#likes").html(like_button);
			var url = document.location.href+"?caption_id="+data[0]['id'];
    	}
	}).error(function(){
		$("#caption_panel").css("display","none");
	});
}

function changeCaption(event){
	event.preventDefault();
	if (!$(event.target).is("a")) {
		return ;
	}
	$(".active").removeClass("active");
	$(event.target).addClass("active");
	var this_caption_id = $(event.target).children().first().attr("id");

	var this_caption;
	$.each(captions, function(i, object){
		if (this_caption_id == object['id']) {
			this_caption = object;
		}
	});
	updateCaptionDisplay(this_caption);
	
	var this_likes = $(event.target).children().first().html();
	var like_button = generateLike(this_caption_id, this_likes);
	$("#likes").html(like_button);
	var url = window.location.pathname.concat("?caption_id=");
	url = url.concat(this_caption_id);
	window.history.replaceState(null, null, url);
};

function updateCaptionDisplay(caption) {
	var hashtags="";
	for (var i=0; i<caption['hashtags'].length; i++) {
		var aTagName=caption['hashtags'][i].name;
		var aTag="<a class='hashtag' href='/search?query="+aTagName+"'> #"+aTagName+"</a>"
		hashtags=hashtags+aTag;
	};
	var caption_content = "<p>"+caption['content']+"</p>";
	var post_by = "<h5>"+"<img class='img-rounded panel-resize-photo' src="+caption['path']+"> "+caption['character']['name']+"</h5>";
	var post_date;
	if (caption['created_at'] == null) {
		post_date = "";
	} else {
		var date = caption['created_at'].split(" ")[0];
		post_date = "<div>on "+date+"</div>";
	}

	$("#caption").html(caption_content+hashtags);
	$("#author").html(post_by+post_date);
}

function shrinkContent(content) {
	if (content.length>MAX_CONTENT_LENGTH) {
		return content.substring(0,MAX_CONTENT_LENGTH) + "...";
	} else {
		return content;
	}
}

function generateLikeBadge(id, likes) {
	return "<div class='badge' id="+id+">"+likes+"</div>";
}

function generateShareLink(url){
	var share_url = "https://www.facebook.com/sharer/sharer.php?u=";
	var this_url = encodeURI(url);
	share_url.concat(this_url);
	return share_url;
}