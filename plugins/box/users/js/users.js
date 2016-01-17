if (typeof $.monstra == 'undefined') $.monstra = {};

$.monstra.users = {

    init: function() {
        this.usersFrontendRegistration();
    },

    usersFrontendRegistration: function() {
        $('#users_public_listing').on('ifChanged', function(event){
			$("form[name=users_frontend]").submit();
		});
		$('#users_frontend_registration').on('ifChanged', function(event){
			$("form[name=users_frontend]").submit();
		});
    }

};


$(document).ready(function(){
    $.monstra.users.init();
});