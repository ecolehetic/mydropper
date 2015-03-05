"use strict";

var historyView = {

    renderTrackers : function(trackers){
        for(var i=0; i< trackers.length; i++){
            var tracker = trackers[i];
            var display = '<li><h3>'+tracker.stores.label+'</h3><span> <a target="_blank" href="'+tracker.full_url+'">'+tracker.on_url+'</a></span><span>'+tracker.created_at +'</span></li>';
            $('#trackerslist').append(display);
        }
        if(trackers.length < API.hist.pagination){
            document.getElementById('load_more').classList.add('hidden');
        }
    }
};

