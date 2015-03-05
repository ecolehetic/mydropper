"use strict";

var admin = {
    tokenApi : null,
    userId : null,
    origin : '',
    path : window.location.pathname,
    pagination : 10,

    start : function(){
        admin.tokenApi = $('#token_api').text();
        admin.userId = $('#user_id').text();
    },
    getStores : function(currentPage, callback){

        $.post(admin.origin+"/api/admin/users", {user_id: admin.userId, token_api: admin.tokenApi, pagination: admin.pagination, pages : currentPage}, "json")
            .done(function(response) {
                callback.call(this, response);
            }).fail(function(response) {
                console.log('error : ', response);
            });
    },
    renderUsersList : function(users){
        for(var i=0; i< users.length; i++){
            var user = users[i];
            var display = '<li><div class="card_section top"><img src="/'+user.avatar_url+'" alt=""/><h3>'+user.username+'</h3><span class="role '+user.roles.label+'">A</span></div><div class="card_section infos"><p class="name">'+user.firstname+' '+user.name+'</p><p class="mail">'+user.mail+'</p></div><div class="card_section controls"><a href="/admin/users/edit/'+user.id+'"><span class="icon-pencil" ></span></a><a data-del="snippet" href="/admin/users/delete/'+user.id+'"><span class="icon-bin deleteLink" ></span></a><div class="clearfix"></div></div></li>';
            $('#userslist').append(display);
            if(users.length < admin.pagination){
                document.getElementById('load_more').classList.add('hidden');
            }
        }
    }
};

$(document).ready(function(){
    admin.start();
    if(admin.path == '/admin'){
        var pagesValue = document.getElementById('load_more').dataset.pagination;
        admin.getStores(pagesValue, function(data){
            admin.renderUsersList(data.users);
            document.getElementById('load_more').dataset.pagination ++;
        });
        $('#load_more').click(function(e){
            e.preventDefault();
            admin.getStores(e.target.dataset.pagination, function(data){
                admin.renderUsersList(data.users);
                e.target.dataset.pagination ++;
            });
        });
    }

});