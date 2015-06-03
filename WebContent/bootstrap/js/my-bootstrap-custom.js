var enrollment = null;

var initFns = {
		//tooltips need to initialize so that bootstrap functionality may be applied to them 
		initTooltips: function(){
			$('[data-toggle="tooltip"]').tooltip();
		},
		initMultiselect: function(){
			$('.multiselect').multiselect();
			$('form .form-group .multiselect').change(function(eventData){
				var id = '#'+eventData.target.id;
				if($(id+' option:selected').length > 0)
				{
					$(id).closest('.form-group').removeClass('has-error');
					$(id).siblings('.help-block.with-errors').html('');
				}
			});
		}
};

var ajaxCalls = {
		register: function(){
			$('#registerForm').validator().on('submit',function(e){
				if($('#registerEnrollment option:selected').length === 0){
					$('#registerEnrollment').closest('.form-group').addClass('has-error');
					$('#registerEnrollment').siblings('.help-block.with-errors').html('At least one enrollment must be selected');
					e.preventDefault();
				}
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
			            		$("#registerSuccess").html(msg);
			            		$("#registerError").html("");
			            	}
			            	else{
			            		$("#registerSuccess").html("");
			            		$("#registerError").html(msg); 
			            	}
			            },
			            error: function(){
			                alert("failure");
			            }
			        });
					e.preventDefault(); //prevent form from refreshing page
				}
		    });
		},
		setTreeview: function(enrollment){
			$.ajax({
				type:"POST",
				url: "tree.php",
				data: {"enrollment": enrollment},
				success: function(json){
					$('#tree').treeview({ 
						//enableLinks: true,
						selectedBackColor:'black',
						onhoverColor:'black',
						data: json,
						showTags:true,
						onNodeSelected: function(event, node){
							$('.btn-node-action').show();
							contentListeners.replaceContentResourcesActions(node);
						},
						onNodeUnselected: function(event,node){
							$('.btn-node-action').hide();
						} 
					});
				},
				error: function(){
					alert('could not retrieve enrollment resources');
				}
			});
		},
		/*
		optionSelected: function(choiceSettings){
			$.ajax({
				type:"POST",
				url:"settings.php",
				data: {"choiceSettings": choiceSettings},
				success: function(content){
					if(content){
						$(option).html(content);
					}
				},
				error: function(){
					alert('could not retrieve admin settings');
				}
			});
		},
		*/
		addEnrollment: function(){
			$('#addEnrollmentForm').validator().on('submit',function(e){
				if (e.isDefaultPrevented()) {
				}
				else {
					$.ajax({
			            type: "POST",
			            url: "addEnrollment.php",
			            data: $('#addEnrollmentForm').serialize(),
			            success: function(msg){
			            	var retCode = msg.charAt(0);
			            	msg = msg.substring(1);
			            	if(retCode == "0"){
			            		$("#addEnrollmentSuccess").html(msg);
			            		$("#addEnrollmentError").html("");
			            	}
			            	else{
			            		$("#addEnrollmentSuccess").html("");
			            		$("#addEnrollmentError").html(msg); 
			            	}
			            },
			            error: function(){
			                alert("Add Enrollment failure");
			            }
			        });
					e.preventDefault(); //prevent form from refreshing page
				}
		    });
		},
		addFolder: function(){
			$('#addFolderForm').validator().on('submit',function(e){
				if (e.isDefaultPrevented()) {
				}
				else {
					$.ajax({
			            type: "POST",
			            url: "addFolder.php",
			            data: $('#addFolderForm').serialize()+"&selectedFolderPath="+$('#tree').treeview('getSelected')[0].path,
			            success: function(msg){
			            	var retCode = msg.charAt(0);
			            	msg = msg.substring(1);
			            	if(retCode == "0"){
			            		$("#addFolderSuccess").html(msg);
			            		$("#addFolderError").html("");
			            		ajaxCalls.setTreeview(enrollment);
			            	}
			            	else{
			            		$("#addFolderSuccess").html("");
			            		$("#addFolderError").html(msg); 
			            	}
			            },
			            error: function(){
			                alert("Add Folder failure");
			            }
			        });
					e.preventDefault(); //prevent form from refreshing page
				}
		    });
		},
		removeFile: function(selectedFilePath){
			$.ajax({
	            type: "POST",
	            url: "removeFile.php",
	            data: "selectedFilePath="+selectedFilePath,
	            success: function(msg){
	            	var retCode = msg.charAt(0);
	            	msg = msg.substring(1);
	            	if(retCode == "0"){
	            		ajaxCalls.setTreeview(enrollment);
	            	}
	            	else{
	            	}
	            },
	            error: function(){
	                alert("Remove File failure");
	            }
	        });
		},
		removeFolder: function(selectedFolderPath){
			$.ajax({
	            type: "POST",
	            url: "removeFolder.php",
	            data: "selectedFolderPath="+selectedFolderPath,
	            success: function(msg){
	            	var retCode = msg.charAt(0);
	            	msg = msg.substring(1);
	            	if(retCode == "0"){
	            		ajaxCalls.setTreeview(enrollment);
	            	}
	            	else{
	            	}
	            },
	            error: function(){
	                alert("Remove Folder failure");
	            }
	        });
		},
		accountSettings: function(){
			$('#accountSettingsForm').validator().on('submit',function(e){
				if (e.isDefaultPrevented()) {
				}
				else {
					$.ajax({
			            type: "POST",
			            url: "accountSettings.php",
			            data: $('#accountSettingsForm').serialize(),
			            success: function(msg){
			            	var retCode = msg.charAt(0);
			            	msg = msg.substring(1);
			            	if(retCode == "0"){
			            		$("#accountSettingsSuccess").html(msg);
			            		$("#accountSettingsError").html("");
			            	}
			            	else{
			            		$("#accountSettingsSuccess").html("");
			            		$("#accountSettingsError").html(msg); 
			            	}
			            },
			            error: function(){
			                alert("Remove Folder failure");
			            }
			        });
					e.preventDefault(); //prevent form from refreshing page
				}
			});
		}
};

var contentListeners = {
	replaceContentResourcesActions: function(node){
		if(node === undefined)
		{
			$('.btn-node-action').hide();
		}
		else if(node.file)
		{
			$('#download-btn').show();
			$('#removeFile-btn').show();
			$('#addFiles-btn').hide();
			$('#addFolder-btn').hide();
			$('#removeFolder-btn').hide();
		}
		else
		{
			$('#download-btn').hide();
			$('#removeFile-btn').hide();
			$('#addFiles-btn').show();
			$('#addFolder-btn').show();
			if(!node.root)
			{
				$('#removeFolder-btn').show();
			}
			else
			{
				$('#removeFolder-btn').hide();
			}
			
		}
	},	
	replaceContentResources: function(caller){
		enrollment = caller.href.substring(caller.href.indexOf('#')+1);
		$('#noResourceSelected').hide();
		$('.fileBroswe').show();
		this.replaceContentResourcesActions();
		$('.btn-admin').hide();
		ajaxCalls.setTreeview(enrollment);
	},
	replaceContentAdmin: function(caller){
		var choiceSettings = caller.href.substring(caller.href.indexOf('#'));
		$('.settings').hide();
		$(choiceSettings).show();
		
		//ajaxCalls.optionSelected(choiceSettings);
		
	},
	replaceEnrollmentSettings: function(enrollment){
		
	}
};
var fileActions = {
	downloadFile: function(){
		if($('#tree').length > 0){
			var file = $('#tree').treeview('getSelected');
			if(file.length > 0 && file[0].path){
				window.location="download.php?path="+file[0].path+"&enrollment="+enrollment+"&isSingleFile=true";
			}
		}
	},
	downloadAll: function(){
		window.location="download.php?enrollment="+enrollment+"&isSingleFile=false";
	},
	addFiles: function(){
		var count = 0;
		var uploader = new plupload.Uploader({
			browse_button: 'addFiles-modal-btn',
			url: 'addFiles.php',
			//unique_names:true,
			multipart_params:{
				"enrollment":enrollment,
				"path":$('#tree').treeview('getSelected')[0]['path']
			}
		});
		uploader.init();
		uploader.bind('FilesAdded', function(up, files) {
			var html = '';
			plupload.each(files, function(file) {
				html += '<li class="list-group-item" id="' + file.id + '">' + file.name + ' (' + plupload.formatSize(file.size) + ')<span class="ico-pull pull-right"><i></i></span><span class="badge"></span></li>';
			});
			$('#fileList').html(html);
		});
		uploader.bind('UploadProgress', function(up, file) {
			$('#'+file.id+' .badge').html(file.percent+'%');
		});
		uploader.bind('FileUploaded', function(up, file, info) {
		    //You should find the "newfilename" in this object somewhere
			var isSuccess = $.parseJSON(info['response'])['OK'];
			if(isSuccess){
				$('#'+file.id+' i').addClass('successText glyphicon glyphicon-ok-circle');
			}
			else{
				$('#'+file.id+' i').addClass('errorText glyphicon glyphicon-remove-circle');
			}
		});
		uploader.bind('Error', function(up, err) {
		  document.getElementById('console').innerHTML += "\nError #" + err.code + ": " + err.message;
		});
		uploader.bind('UploadComplete', function(up, files) {
			ajaxCalls.setTreeview(enrollment);
		});
		$('#startUpload-modal-btn').click(function(){
			uploader.start();
		});
		
		
	},
	addFolder: function(){
		if($('#tree').length > 0){
			var folder = $('#tree').treeview('getSelected');
			if(folder.length > 0 && folder[0].path && !folder[0].file){
				ajaxCalls.addFolder();
			}
		}
	},
	removeFile: function(){
		if($('#tree').length > 0){
			var file = $('#tree').treeview('getSelected');
			if(file.length > 0 && file[0].path && file[0].file){
				ajaxCalls.removeFile(file[0].path);
			}
		}
	},
	removeFolder: function(){
		if($('#tree').length > 0){
			var folder = $('#tree').treeview('getSelected');
			if(folder.length > 0 && folder[0].path && !folder[0].file && !folder[0].root){
				ajaxCalls.removeFolder(folder[0].path);
			}
		}
	}
}

$(initFns.initTooltips);
$(initFns.initMultiselect);
$(ajaxCalls.register);
$(ajaxCalls.addEnrollment);
$(ajaxCalls.accountSettings)



