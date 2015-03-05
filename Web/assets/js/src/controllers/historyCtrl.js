"use strict";

$(document).ready(function(){
    API.start();
    if(API.path == '/history'){
        if(document.getElementById('load_more')){
            var pagesValue = document.getElementById('load_more').dataset.pagination;
        }
        API.hist.getStores(pagesValue, function(data){
            if(data && data.trackers){
                historyView.renderTrackers(data.trackers);
                document.getElementById('load_more').dataset.pagination ++;
            }
        });
        $('#load_more').click(function(e){
            e.preventDefault();
            API.hist.getStores(e.target.dataset.pagination, function(data){
                if(data && data.trackers){
                    historyView.renderTrackers(data.trackers);
                    e.target.dataset.pagination ++;
                }
            });

        });
    }

});