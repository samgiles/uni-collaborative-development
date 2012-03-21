var registrationDialog = {
		autoOpen: false,
		height: 610,
		width: 700,
		modal: true,
		buttons: {
            
			"Create an account": function() {
                var tips = $( ".validateTips" );
                
            function updateTips(value) {
                tips.text( value ).addClass( "ui-state-highlight" );
		        setTimeout(function() {
			      tips.removeClass( "ui-state-highlight", 1500 );
		        }, 500 );
            }
                
             function checkLength( o, n, min, max ) {
		       if ( o.val().length > max || o.val().length < min ) {
			     o.addClass( "ui-state-error" );
			     updateTips( "Length of " + n + " must be between " +
				   min + " and " + max + "." );
			      return false;
		        } else {
                  o.removeClass( "ui-state-error" );
			      return true;
		        }
	          }
              
              function checkEquality(a,b, message) {
                if ( a.val() != b.val()) {
			     b.addClass( "ui-state-error" );
			     updateTips( message );
			      return false;
		        } else {
                  b.removeClass( "ui-state-error" );
			      return true;
		        }  
              }
              
			  var forename = $('#fname');
              var lastname = $('#lname'); // LNAME
              var usernameA = $('#uname'); // USERNAME
              var password = $('#password'); // PASSWORD
              var passwordRepeat = $('#rpassword');
              var email = $('#email'); // EMAIL
              var addressLineOne = $('#addrlineone'); // ADDRESS LINE ONE.
              var addressLineTwo = $('#addrlinetwo'); // ADDRESS LINE TWO
              var postcode = $('#postcode'); // POSTCODE
              
              var bValid = true;
              
              bValid = bValid && checkLength(forename, "First Name", 1, 30);
              bValid = bValid && checkLength(lastname, "Last Name", 1, 30);
              bValid = bValid && checkLength(email, "Email", 1, 40);
              bValid = bValid && checkLength(usernameA, "User Name", 1, 10);
              bValid = bValid && checkLength(password, "Password", 1, 30);
              bValid = bValid && checkEquality(password, passwordRepeat, "Check passwords are matching");
              bValid = bValid && checkLength(addressLineOne, "Address Line One", 1, 50);
              bValid = bValid && checkLength(addressLineTwo, "Address Line Two", 0, 40);
              bValid = bValid && checkLength(postcode, "Post Code", 4, 8);
              
              if (!bValid) {
                return;
              }
              // Submit form.
              //$('#registration-form').submit();
              $.post('./?c=Register', {
            	  "fname": forename,
            	  "lname": lastname,
            	  "uname": usernameA,
            	  "password": password,
            	  "email" : email,
            	  "addrlineone" : addressLineOne,
            	  "addrlinetwo" : addressLineTwo,
            	  "postcode" : postcode
               }, function(data){
            	   $('#register-box').html(data);
              });
              
			},
			Cancel: function() {
				$( this ).dialog( "close" );
			}
		}
	};