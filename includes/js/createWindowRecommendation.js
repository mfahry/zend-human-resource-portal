$(function(){
	var dhxWins = null;
	var dhxWins = new dhtmlXWindows();
	dhxWins.setImagePath("includes/dhtmlx/dhtmlxWindows/imgs/");
	dhxWins.setSkin("dhx_skyblue"); 		
		
	$('.sakit').click(function() {
		var dataApprove = $(this).attr("id"); 
		dataApprove = dataApprove.split('_'); 
		 $("#window_absenRekomendasi").load(location.href+" #window_absenRekomendasi>*",
			{userid:dataApprove[0],
			 username:dataApprove[1],
			 typeid:dataApprove[2]}, 
			 function(){ 
				createWindow0(); 
				//alert(dataApprove);
		 });  
		 return false;
	})
	
	function createWindow0(){ 
		if (!dhxWins.window("winFin")) {
			document.getElementById("window_absenRekomendasi").style.display = "block";
			var winFin = dhxWins.createWindow("w1", 400, 200, 400, 300);
			winFin.setText("User Detail"); 
			winFin.button("park").hide();
			winFin.setModal(true); 
			winFin.button("minmax1").hide();
			winFin.button("minmax2").hide();
			winFin.attachEvent("onClose",function(win){
				if (win.getId() == "w1") {
					win.detachObject();
					win.hide();
					winFin.setModal(false);
				}
			})
		}else{
			var w1 = dhxWins.window("winFin");
			w1.show();
		}
		winFin.attachObject("window_absenRekomendasi");
	} 
	
	$('.edit').click(function() {
		var dataApprove = $(this).attr("id");
		dataApprove = dataApprove.split('_');
		 $("#window_user").load(location.href+" #window_user>*",
			{winDesc : dataApprove[0],
			 userid : dataApprove[1]}, 
			 function(){
				createWindow2(); 
				//alert(dataApprove);
		 });   
	})
	
	function createWindow2(){
		if (!dhxWins.window("winFin")) {
			document.getElementById("window_user").style.display = "block";
			var winFin = dhxWins.createWindow("w2", 400, 200, 400, 400);
			winFin.setText("Modify User");
			winFin.setModal(true); 
			winFin.button("park").hide();
			winFin.button("minmax1").hide();
			winFin.button("minmax2").hide();
			winFin.attachEvent("onClose",function(win){
				if (win.getId() == "w2") {
					win.detachObject();
					win.hide();
					winFin.setModal(false);
				}
			})
		}else{
			var w1 = dhxWins.window("winFin");
			w1.show();
		}
		winFin.attachObject("window_user");
	} 
	
	$('.lock').click(function() {
		var dataApprove = $(this).attr("id");
		dataApprove = dataApprove.split('_');
		var c = confirm("Apakah anda yakin ingin me-lock user : "+dataApprove[1]+"?");
		if (c){  
			 location.href = "index.php?mod=staffing/lock/"+dataApprove[1];
		}
	})
	
	$('.unlock').click(function() {
		var dataApprove = $(this).attr("id");
		dataApprove = dataApprove.split('_');
		 $("#window_userAccess").load(location.href+" #window_userAccess>*",
			{winDesc : dataApprove[0],
			 userid : dataApprove[1]}, 
			 function(){
				createWindow3(); 
				//alert(dataApprove);
		 });  
		 return false;
	})
	
	function createWindow3(){ 
		if (!dhxWins.window("winFin")) {
			document.getElementById("window_userAccess").style.display = "block";
			var winFin = dhxWins.createWindow("w3", 400, 200, 400, 400);
			winFin.setText("User Access");
			winFin.setModal(true); 
			winFin.button("park").hide();
			winFin.button("minmax1").hide();
			winFin.button("minmax2").hide();
			winFin.attachEvent("onClose",function(win){
				if (win.getId() == "w3") {
					win.detachObject();
					win.hide();
					winFin.setModal(false);
				}
			})
		}else{
			var w1 = dhxWins.window("winFin");
			w1.show();
		}
		winFin.attachObject("window_userAccess");
	} 

 
})