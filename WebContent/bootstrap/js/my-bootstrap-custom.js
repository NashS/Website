var initFns = {
		//tooltips need to initialize so that bootstrap functionality may be applied to them 
		initTooltips: function(){
			$('[data-toggle="tooltip"]').tooltip();
		},
};

var ajaxCalls = {
		register: function(){
			$("#registerForm").validator().on('submit',function(e){
				if (e.isDefaultPrevented()) {
				}
				else {
					$.ajax({
			            type: "POST",
			            url: "register.php", //register process from server side
			            data: $('#registerForm').serialize(),
			            success: function(msg){
			            	var retCode = msg.charAt(0);
			            	msg = msg.substring(1);
			            	if(retCode == "0"){
			            		$("#responseSuccess").html(msg);
			            		$("#responseError").html("");
			            	}
			            	else{
			            		$("#responseSuccess").html("");
			            		$("#responseError").html(msg); 
			            	}
			            },
			            error: function(){
			                alert("failure");
			            }
			        });
					e.preventDefault(); //prevent form from refreshing page
				}
		        
		    });
		}

}
$(document).ready(initFns.initTooltips());
$(document).ready(ajaxCalls.register());


