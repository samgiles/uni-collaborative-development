
	if (!$) {
		throw new Exception("JQuery is required, make sure it is included.");
	}
	
	/*
	 * A sandbox for passing messages between modules.
	 */
	var sandbox = function() {
		
		var listeners = [];
		
		return {
			listen: function(message, callback) {
				listeners.push({"message": message, cb: callback});
			},
			
			notify: function(message, data) {
				var i = listeners.length;
				
				while (i--) {
					if (listeners[i].message == message) {
						listeners[i].cb(data);
					}
				}
			}
		};
	};
	
	
	var basket = (function() {
		// First we need to hook into any href links used for updating the quantities in the basket to use ajax.
		var ajaxifyLinks = function() {
			$(".basket-control-link").each(function(i){
				var href = this.href;
				this.href = "#";
				$(this).click(function(e){
					e.preventDefault();
					$("#basket-ajax").removeClass("hidden");
					// Make the ajax call.
					$.get(href, function(data){
						var container = $("#basket-container");
						container.html(data);
						$("#basket-ajax").addClass("hidden");
						ajaxifyLinks();
					});
					return false;
				});
			});
		};
		
		$(".add-to-basket").each(function(i) {
               var href = this.href;
               this.href = "#";
               
               $(this).click(function(e) {
                  e.preventDefault();
                  $("#basket-ajax").removeClass("hidden");
        			// Make the ajax call.
					$.get(href, function(data){
						var container = $("#basket-container");
						container.html(data);
						$("#basket-ajax").addClass("hidden");
						ajaxifyLinks();
					});
					return false;
               });
            });
            
		ajaxifyLinks();
		
		return {
			update: function() {
				ajaxifyLinks();
			},
			
			showWarning : function(warningMessage) {
				alert(warningMessage);
			}
		};
	}());