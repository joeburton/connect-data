AppRouter = Backbone.Router.extend({

	routes: {
		"":"list"
	},

	list: function () {

		this.before();
	
	},
	
	before:function () {
	
		this.contactList = new ContactCollection();

		this.contactList.fetch({

			success:function () {
				
				console.log(app.contactList.models[2].attributes, {collection:app.contactList}, {collection:"GEST"});
				 
				$('#lists').append(new ContactsView({collection:app.contactList}).render());

			}

		});
	
	}
	
});

app = new AppRouter();
Backbone.history.start();