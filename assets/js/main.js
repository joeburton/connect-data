/*
Models and collection structure
*/

Contact = Backbone.Model.extend({
	defaults:{
		id: null,
		firstname: "",
		surname: "",
		mobile: "",
		email: "",
		dob: ""
	}
});

ContactCollection = Backbone.Collection.extend({
	model:Contact,
	url:"api/contacts"
});

ContactsView = Backbone.View.extend({
    
	el: $('#lists'),

    template: _.template($('#details').html()),

    render:function () {
		
        $(this.el).append(this.template({details:this.collection.toJSON()}));

    	//console.log(this.collection);
        
    }

});


