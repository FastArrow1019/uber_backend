var search_url = "";
var loaded_id = 0;

function search(){
	var search_data = document.getElementById("search_text");
	if(search_data.value.length > 0){
    	$(".loader").fadeIn("slow");
		$.get('http://article-guide.com/search', "search_data="+search_data.value, function(data){ 
	      display(data); 
	    });
    }
}

function display(data){
	data = JSON.parse(data);
	var search_contents = document.getElementById("search_contents");
	search_contents.innerHTML = data.html;
// 	window.setTimeout('removeIframe()', 30000);
 	var firstiframes = document.getElementsByTagName("iframe");
	$(".loader").fadeOut("slow");
// 	for(var i = 0; i < data.urls.length; i++){
//         var xmlHttp = new XMLHttpRequest();
//         xmlHttp.open( "GET", data.urls[i], false ); // false for synchronous request
//         xmlHttp.send( null );
//         return xmlHttp.responseText;z
// 	}
// 	for(var i = 0; i > iframes.length; i ++ ){
//         if(iFrameID) {
//             // here you can make the height, I delete it first, then I make it again
//             iframes[i].height = "";
//             iframes[i].height = iframes[i].contentWindow.document.body.scrollHeight + "px";
//         }
// 	}
    var real_ids = [];
    var total_ids = [];
    const iframesbyId = {};
	
    for(var i = 0; i < firstiframes.length; i++){
        var xmlString = "<iframe id='"+firstiframes[i].id+"' src='"+firstiframes[i].src+"' width = '100%' height = '100%'></iframe>";
        doc = new DOMParser().parseFromString(xmlString, "text/html");
        iframesbyId[firstiframes[i].id] = doc.getElementsByTagName('iframe')[0];
    }
//     firstiframes = "";
    
	var iframes = document.querySelectorAll("iframe");
    for(var i = 0; i < iframes.length; i++){
        total_ids.push(iframes[i].id);
        iframes[i].addEventListener('load', (evt) => {
            real_ids.push(evt.target.id);
            // if(evt.target === iframesbyId[evt.target.id]){
            //     evt.target.parentNode.removeChild(evt.target);
            // }
            // var $html = $(evt.target);    
            // var str = $html.prop('outerHTML');
            // var iframeWin = evt.target.contentWindow || evt.target.contentDocument.parentWindow;Object.toJSON(iframesbyId[evt.target.id])
    // 		console.log($(evt.target).outHtml);
    //         console.log($(iframesbyId[evt.target.id]));
            
    //         console.log($(evt.target).is($(iframesbyId[evt.target.id])));
            // (function($) {
            //     $('#'+evt.target.id).seamless({ 
            //       container: "body"
            //     });
            // }(jQuery));
            // console.log($( "#"+evt.target.id ).contents().find( "body" ));
            // console.log(iframesbyId[evt.target.id]);
            // console.log("after:");
            // console.log(evt.target);
            // console.log($("#"+evt.target.id).contents().find('body').text());
            // if(evt.target.id == 16){
            //     var total_iframes = document.querySelectorAll('iframe');
            //     for(var j = 0; j < total_iframes.length; j ++){
            //         console.log(real_ids);
            //         console.log(total_ids);
            //         // if(real_ids.indexOf(total_iframes[j].id) == -1){
            //         //     total_iframes[j].parentNode.removeChild(total_iframes[j]);
            //         // }
            //     }
            // }
        });
    }
	set_footer();
	return true;
}
function doOnload(){
	$(".loader").fadeOut("slow");
	set_footer();
}

function set_footer(){
    var main_height = document.getElementById("main");
    main_height = (main_height == null  ? 0 : main_height.offsetHeight);
    var footer_height = document.getElementById("footer");
    footer_height = (footer_height == null  ? 0 : footer_height.offsetHeight);

    var content_height = (window.innerHeight < main_height + footer_height ? 0 : window.innerHeight - main_height - footer_height);
   document.getElementById("search_contents").setAttribute("style", "min-height: "+ content_height +"px");
    // document.getElementById("footer").setAttribute("style", "margin-top: "+ content_height +"px");
}