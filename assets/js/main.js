Contact = Backbone.Model.extend({
	//urlRoot:"api/contacts",
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

AppRouter = Backbone.Router.extend({

	routes:{
		"":"list"
	},

	list:function () {

		this.before();
	
	},
	
	before:function () {
	
		this.contactList = new ContactCollection();

		this.contactList.fetch({

			success:function () {

				console.log({collection:app.contactList});
				 
				$('#lists').append(new ContactsView({collection:app.contactList}).render());

			}

		});
	
	}
	
});



ContactsView = Backbone.View.extend({
    
	el: $('#lists'),

    template: _.template($('#details').html()),

    render:function () {
		
        $(this.el).append(this.template( {details:this.collection.toJSON()} ));

    	console.log(this.collection);

        //return this;
        
    }

});



app = new AppRouter();
Backbone.history.start();
