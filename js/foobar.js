var FooBar = function(self) {
	
	self.init = function() {
		console.log("init called");
	};
	
}(FooBar || {});
