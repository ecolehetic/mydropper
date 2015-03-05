"use strict";

function renderTrackers(trackers){
    for(var i=0; i< trackers.length; i++){
        var tracker = trackers[i];
        var display = '<li><h3>'+tracker.stores.label+'</h3><span> <a target="_blank" href="'+tracker.full_url+'">'+tracker.on_url+'</a></span><span>'+tracker.created_at +'</span></li>';
        $('#trackerslist').append(display);
    }
    if(trackers.length < API.hist.pagination){
        document.getElementById('load_more').classList.add('hidden');
    }
}

$(document).ready(function(){
    API.start();
    if(API.path == '/history'){
        if(document.getElementById('load_more')){
            var pagesValue = document.getElementById('load_more').dataset.pagination;
        }
        API.hist.getStores(pagesValue, function(data){
            renderTrackers(data.trackers);
            document.getElementById('load_more').dataset.pagination ++;
        });
        $('#load_more').click(function(e){
            e.preventDefault();
            API.hist.getStores(e.target.dataset.pagination, function(data){
                renderTrackers(data.trackers);
                e.target.dataset.pagination ++;
            });

        });
    }

});