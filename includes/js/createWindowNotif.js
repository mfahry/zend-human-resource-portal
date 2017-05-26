$(function(){
	var dhxWins = null;
	var dhxWins = new dhtmlXWindows();
	dhxWins.setImagePath("includes/dhtmlx/dhtmlxWindows/imgs/");
	dhxWins.setSkin("dhx_skyblue"); 		
		
	$('.gotRecommendLi').live("click",function() {
		var dataApprove = $(this).attr("id");
		dataApprove = dataApprove.split('_');
		 $("#window_alertRecommendation").load(location.href+" #window_alertRecommendation>*",
			{calid : dataApprove[0],
			 userid : dataApprove[1],
			 absentype : dataApprove[2]}, 
			 function(){
				createWindow0(); 
				//alert(dataApprove);
		 });  
		 return false;
	})
	
	function createWindow0(){
		if (!dhxWins.window("winFin")) {
			document.getElementById("window_alertRecommendation").style.display = "block";
			var winFin = dhxWins.createWindow("w1", 400, 200, 400, 300);
			winFin.setText("Alert Recommendation");
			winFin.setModal(true); 
			winFin.button("park").hide();
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
		winFin.attachObject("window_alertRecommendation");
	} 
	/*
	$('.editcv').live("click",function() {
		var dataApprove = $(this).attr("id");
		dataApprove = dataApprove.split('_');
		 $("#window_cv_education").load(location.href+" #window_cv_education>*",
			{schid : dataApprove[0],
			 userid : dataApprove[1],
			 absentype : dataApprove[2]}, 
			 function(){
				DialogEdu(); 
				//alert(dataApprove);
		 });  
		 return false;
	})*/
	
	function DialogEdu(){
		if (!dhxWins.window("winFin")) {
			document.getElementById("window_cv_education").style.display = "block";
			var winFin = dhxWins.createWindow("w1", 400, 200, 400, 300);
			winFin.setText("Edit CV");
			winFin.setModal(true); 
			winFin.button("park").hide();
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
		winFin.attachObject("window_cv_education");
	} 
	
	$('.rejectLi').live("click",function() {
		var dataApprove = $(this).attr("id");
		dataApprove = dataApprove.split('_');
		 $("#window_alertRecommendationReject").load(location.href+" #window_alertRecommendationReject>*",
			{calid : dataApprove[0],
			 userid : dataApprove[1],
			 absentype : dataApprove[2]}, 
			 function(){
				createWindow2(); 
				//alert(dataApprove);
		 });  
		 return false;
	})
	
	function createWindow2(){
		if (!dhxWins.window("winFin")) {
			document.getElementById("window_alertRecommendationReject").style.display = "block";
			var winFin = dhxWins.createWindow("w2", 400, 200, 400, 600);
			winFin.setText("Alert Recommendation");
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
		winFin.attachObject("window_alertRecommendationReject");
	} 
	
	$('.approveLi').live("click",function() {
		var dataApprove = $(this).attr("id");
		dataApprove = dataApprove.split('_');
		 $("#window_alertRecommendationAprove").load(location.href+" #window_alertRecommendationAprove>*",
			{calid : dataApprove[0],
			 userid : dataApprove[1],
			 absentype : dataApprove[2]}, 
			 function(){
				createWindow3(); 
				//alert(dataApprove);
		 });  
		 return false;
	})
	
	function createWindow3(){ 
		if (!dhxWins.window("winFin")) {
			document.getElementById("window_alertRecommendationAprove").style.display = "block";
			var winFin = dhxWins.createWindow("w3", 400, 200, 400, 400);
			winFin.setText("Alert Recommendation");
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
		winFin.attachObject("window_alertRecommendationAprove");
	} 

	// window_alertRecommendation
	$('#cmdConfirmGotRecommend').live("click",function() {  
 		var submitData = $('#form_alertRecommendation').serialize();
		$("#loadingRecommendation").fadeIn(400).append('<img src="./includes/img/loading.gif" align="absmiddle">&nbsp;<span class="loading">Loading ...</span>');
		$("#cmdConfirmGotRecommend").addClass("disabled");
		$("#cmdConfirmGotRecommend").attr("disabled","disabled");
		$.ajax({
			type: "POST",
			url: "index.php?mod=recommendation/submitAlertRecommendation",
			data: submitData,
			dataType: "html",
			success: function(msg){ 
					$("#status").text("transaksi berhasil.")
						.css("color", "green");
				$("#loadingRecommendation").hide();
				//parent.dhxWins.window("w1").close();
				$(".right_side>.dynamic").load(location.href+" .right_side>.dynamic","");
			},
			error: function(XMLHttpRequest, textStatus, errorThrown){
				alert("error:" +XMLHttpRequest);	
				alert("error:" +textStatus);	
				alert("error:" +errorThrown);
			}
			
		}); 
	});
	
	// window_alertRecommendationReject
 	$('#cmdRerecommend').live('click',function(){
 			var submitData = $('#form_alertRecommendationReject').serialize();
			$("#loadingRecommendation").fadeIn(400).append('<img src="./includes/img/loading.gif" align="absmiddle">&nbsp;<span class="loading">Loading ...</span>');
			$("#cmdRerecommend").addClass("disabled");
			$("#cmdRerecommend").attr("disabled","disabled");
			
			$.ajax({
				type: "POST",
				url: "index.php?mod=recommendation/submitfullRecommendation",
				data: submitData+"&userReject="+$("#userReject").val(),
				dataType: "html",
				success: function(msg){ 
					$("#loadingRecommendation").hide();
					//parent.dhxWins.window("w2").close();
					$("#status").text("Update status telah berhasil.")
						.css("color", "Green");
					$(".right_side>.dynamic").load(location.href+" .right_side>.dynamic","");
					window.location.reload();
				},
				error: function(XMLHttpRequest, textStatus, errorThrown){
					alert("error:" +XMLHttpRequest);	
					alert("error:" +textStatus);	
					alert("error:" +errorThrown);
				}
				
			}); 
	});
	$('#cmdRerecommendcancel').live('click',function(){
 			var submitData = $('#form_alertRecommendationReject').serialize();
			$("#loadingRecommendation").fadeIn(400).append('<img src="./includes/img/loading.gif" align="absmiddle">&nbsp;<span class="loading">Loading ...</span>');
			$("#cmdRerecommend").addClass("disabled");
			$("#cmdRerecommend").attr("disabled","disabled");
			
			$.ajax({
				type: "POST",
				url: "index.php?mod=recommendation/submitcancelRecommendation",
				data: submitData+"&userReject="+$("#userReject").val(),
				dataType: "html",
				success: function(msg){ 
					$("#loadingRecommendation").hide();
					//parent.dhxWins.window("w2").close();
					$("#status").text("Hapus rekomendasi telah berhasil.").css("color", "Green");
					$(".right_side>.dynamic").load(location.href+" .right_side>.dynamic","");
					window.location.reload();
				},
				error: function(XMLHttpRequest, textStatus, errorThrown){
					alert("error:" +XMLHttpRequest);	
					alert("error:" +textStatus);	
					alert("error:" +errorThrown);
				}
				
			}); 
	});
	
	// window_alertRecommendationAprove
	$('#cmdConfirm').live("click",function() {
		 
			var submitData = $('#form_alertRecommendationAprove').serialize();
			$("#loadingRecommendation").fadeIn(400).append('<img src="./includes/img/loading.gif" align="absmiddle">&nbsp;<span class="loading">Loading ...</span>');
			$("#cmdConfirm").addClass("disabled");
			$("#cmdConfirm").attr("disabled","disabled");

			
			$.ajax({
				type: "POST",
				url: "index.php?mod=attendance/submitRecommendation",
				data: submitData,
				dataType: "html",
				timeout: 5000,
				error: function(){
					alert('Waktu habis, mohon refresh halaman ini.');
				},
				success: function(msg){ 
					$("#loadingRecommendation").hide();
					$("#status").text("Update status telah berhasil.")
						.css("color", "green");
					dhxWins.window("w3").close();
					$(".right_side>.dynamic").load(location.href+" .right_side>.dynamic","");
					

				}
				
		}); 			
	});
 
});

function editFb(id,frm,act){
	if(frm=='feedback'){
	
		if(act=='del'){
			if(confirm("Feedback telah dibaca?")){
				$.ajax({
					type	: 'POST',
					url		: 'views/window_cv_act.php',
					data	: "fbid="+id+"&frm="+frm+"&act="+act,
					success	: function(msg){
						if(msg=="ok"){
							alert('Berhasil dikerjakan');
							$("#editFb").remove();
							location.href='index.php?mod=feedback';
						}else {
							alert(msg);
						}
					}
				});
			}
		}else {
		$("#feedbackid").append("<div id='editFb'></div>");
			
		$("#editFb").dialog({
			autoOpen: true,
			width	: 600,
			position: 'top',
			modal	: true,
			title	: (act=='edit'?"EDIT":"Tambah")+" Feedback",
			show	: 'fold',
			hide	: 'fold',
			draggable: false,
			resizable: false,
			open	: function(){
				$("#editFb").load("views/window_cv_education.php?fbid="+id+"&frm="+frm+"&act="+act);
				//$("#edCV").html(id);
			},
			close	: function(){
				$("#editFb").remove();
			},
			buttons	: {
				"Kirim"	: function(){
					if($("#descfb").val()==''){
						alert("Masa feedback nya kosong??");
						$("#descfb").focus();
					}else{
						param = "fbid="+id+"&frm="+frm+"&act="+act;
						param += "&descfb="+$("#descfb").val();
												
						$.ajax({
							type	: 'POST',
							url		: 'views/window_cv_act.php',
							data	: param,
							success	: function(msg){
								if(msg=="ok"){
									alert('Data telah disimpan');
									$("#editFb").remove();
									location.href='index.php?mod=feedback';
								}else {
									alert(msg);
								}
							}
						});
					}
				},
				"Tutup"	: function(){
					$("#editFb").remove();
				}
			}
		});	
	}
}
}
function editCV(id,frm,act){
	if(frm=='edu'){
		if(act=='del'){
			if(confirm("Yakin akan menghapus data ini?")){
				$.ajax({
					type	: 'POST',
					url		: 'views/window_cv_act.php',
					data	: "schid="+id+"&frm="+frm+"&act="+act,
					success	: function(msg){
						if(msg=="ok"){
							alert('Data berhasil dihapus');
							$("#edCV").remove();
							location.href='index.php?mod=profile';
						}else {
							alert(msg);
						}
					}
				});
			}
		}else {
			$("#cvDia").append("<div id='edCV'></div>");
			
			$("#edCV").dialog({
				autoOpen: true,
				width	: 600,
				position: 'top',
				modal	: true,
				title	: (act=='edit'?"EDIT":"TAMBAH")+" DATA CV",
				show	: 'fold',
				hide	: 'fold',
				draggable: false,
				resizable: false,
				open	: function(){
					$("#edCV").load("views/window_cv_education.php?schid="+id+"&frm="+frm+"&act="+act);
					//$("#edCV").html(id);
				},
				close	: function(){
					$("#edCV").remove();
				},
				buttons	: {
					"Simpan"	: function(){
						if($("#sname").val()==''){
							alert("Nama Sekolah tidak boleh kosong!");
							$("#sname").focus();
						}else if($("#pendidikan").val()==''){
							alert("Pendidikan tidak boleh kosong!");
							$("#pendidikan").focus();
						}else if($("#Deskripsi1").val()==''){
							alert("Deskripsi tidak boleh kosong!");
							$("#Deskripsi1").focus();
						}else if($("#year").val()==''){
							alert("Tahun Sekolah gak boleh kosong!");
							$("#year").focus();
						}else if($("#kotapendidikan").val()==''){
							alert("Kota juga gak boleh kosong!");
							$("#kotapendidikan").focus();
						}else{
							param = "schid="+id+"&frm="+frm+"&act="+act;
							param += "&sname="+$("#sname").val();
							param += "&pendidikan="+$("#pendidikan").val();
							param += "&Deskripsi1="+$("#Deskripsi1").val();
							param += "&year="+$("#year").val();
							param += "&yearend="+$("#yearend").val();
							param += "&kotapendidikan="+$("#kotapendidikan").val();
							param += "&sname="+$("#sname").val();
							param += "&sname="+$("#sname").val();
							
							$.ajax({
								type	: 'POST',
								url		: 'views/window_cv_act.php',
								data	: param,
								success	: function(msg){
									if(msg=="ok"){
										alert('Data berhasil disimpan');
										$("#edCV").remove();
										location.href='index.php?mod=profile';
									}else {
										alert(msg);
									}
								}
							});
						}
					},
					"Tutup"	: function(){
						$("#edCV").remove();
					}
				}
			});
		}
	}else if(frm=='exp'){
		if(act=='del'){
			if(confirm("Yakin akan menghapus data ini?")){
				$.ajax({
					type	: 'POST',
					url		: 'views/window_cv_act.php',
					data	: "compid="+id+"&frm="+frm+"&act="+act,
					success	: function(msg){
						if(msg=="ok"){
							alert('Data berhasil dihapus');
							$("#edCVExp").remove();
							location.href='index.php?mod=profile';
						}else {
							alert(msg);
						}
					}
				});
			}
		}else {
			$("#cvDia").append("<div id='edCVExp'></div>");
			
			$("#edCVExp").dialog({
				autoOpen: true,
				width	: 600,
				position: 'top',
				modal	: true,
				title	: (act=='edit'?"EDIT":"TAMBAH")+" DATA CV",
				show	: 'fold',
				hide	: 'fold',
				draggable: false,
				resizable: false,
				open	: function(){
					$("#edCVExp").load("views/window_cv_education.php?compid="+id+"&frm="+frm+"&act="+act);
					//$("#edCV").html(id);
				},
				close	: function(){
					$("#edCVExp").remove();
				},
				buttons	: {
					"Simpan"	: function(){
						if($("#Perusahaan").val()==''){
							alert("Nama Perusahaan tidak boleh kosong!");
							$("#Perusahaan").focus();
						}else if($("#jobspecification").val()==''){
							alert("Posisi tidak boleh kosong!");
							$("#jobspecification").focus();
						}else if($("#Deskripsi2").val()==''){
							alert("Deskripsi tidak boleh kosong!");
							$("#Deskripsi2").focus();
						}else if($("#yearhire").val()==''){
							alert("Tahun Bekerja gak boleh kosong!");
							$("#yearhire").focus();
						}else if($("#KotaSpesifikasi").val()==''){
							alert("Kota juga gak boleh kosong!");
							$("#KotaSpesifikasi").focus();
						}else{
							param = "compid="+id+"&frm="+frm+"&act="+act;
							param += "&Perusahaan="+$("#Perusahaan").val();
							param += "&jobspecification="+$("#jobspecification").val();
							param += "&Deskripsi2="+$("#Deskripsi2").val();
							param += "&yearhire="+$("#yearhire").val();
							param += "&yearhireend="+$("#yearhireend").val();
							param += "&KotaSpesifikasi="+$("#KotaSpesifikasi").val();	
							
							$.ajax({
								type	: 'POST',
								url		: 'views/window_cv_act.php',
								data	: param,
								success	: function(msg){
									if(msg=="ok"){
										alert('Data berhasil disimpan');
										$("#edCVExp").remove();
										location.href='index.php?mod=profile';
									}else {
										alert(msg);
									}
								}
							});
						}
					},
					"Tutup"	: function(){
						$("#edCVExp").remove();
					}
				}
			});
		}
		}else if(frm=='oth'){
		if(act=='del'){
			if(confirm("Yakin akan menghapus data ini?")){
				$.ajax({
					type	: 'POST',
					url		: 'views/window_cv_act.php',
					data	: "otherjobid="+id+"&frm="+frm+"&act="+act,
					success	: function(msg){
						if(msg=="ok"){
							alert('Data berhasil dihapus');
							$("#edCVOth").remove();
							location.href='index.php?mod=profile';
						}else {
							alert(msg);
						}
					}
				});
			}
		}else {
			$("#cvDia").append("<div id='edCVOth'></div>");
			
			$("#edCVOth").dialog({
				autoOpen: true,
				width	: 600,
				position: 'top',
				modal	: true,
				title	: (act=='edit'?"EDIT":"TAMBAH")+" DATA CV",
				show	: 'fold',
				hide	: 'fold',
				draggable: false,
				resizable: false,
				open	: function(){
					$("#edCVOth").load("views/window_cv_education.php?otherjobid="+id+"&frm="+frm+"&act="+act);
					//$("#edCV").html(id);
				},
				close	: function(){
					$("#edCVOth").remove();
				},
				buttons	: {
					"Simpan"	: function(){
						if($("#pekerjaan").val()==''){
							alert("Pekerjaan tidak boleh kosong!");
							$("#pekerjaan").focus();
						
						}else{
							param = "otherjobid="+id+"&frm="+frm+"&act="+act;
							param += "&pekerjaan="+$("#pekerjaan").val();

							
							$.ajax({
								type	: 'POST',
								url		: 'views/window_cv_act.php',
								data	: param,
								success	: function(msg){
									if(msg=="ok"){
										alert('Data berhasil disimpan');
										$("#edCVOth").remove();
										location.href='index.php?mod=profile';
									}else {
										alert(msg);
									}
								}
							});
						}
					},
					"Tutup"	: function(){
						$("#edCVOth").remove();
					}
				}
			});
		}
	}else if(frm=='skll'){
		if(act=='del'){
			if(confirm("Yakin akan menghapus data ini?")){
				$.ajax({
					type	: 'POST',
					url		: 'views/window_cv_act.php',
					data	: "skillid="+id+"&frm="+frm+"&act="+act,
					success	: function(msg){
						if(msg=="ok"){
							alert('Data berhasil dihapus');
							$("#edCVSkill").remove();
							location.href='index.php?mod=profile';
						}else {
							alert(msg);
						}
					}
				});
			}
		}else {
			$("#cvDia").append("<div id='edCVSkill'></div>");
			
			$("#edCVSkill").dialog({
				autoOpen: true,
				width	: 600,
				position: 'top',
				modal	: true,
				title	: (act=='edit'?"EDIT":"TAMBAH")+" DATA CV",
				show	: 'fold',
				hide	: 'fold',
				draggable: false,
				resizable: false,
				open	: function(){
					$("#edCVSkill").load("views/window_cv_education.php?skillid="+id+"&frm="+frm+"&act="+act);
					//$("#edCV").html(id);
				},
				close	: function(){
					$("#edCVSkill").remove();
				},
				buttons	: {
					"Simpan"	: function(){
						if($("#skill").val()==''){
							alert("Keahlian tidak boleh kosong!");
							$("#skill").focus();
						}else{
							param = "skillid="+id+"&frm="+frm+"&act="+act;
							param += "&skill="+$("#skill").val();								
							
							$.ajax({
								type	: 'POST',
								url		: 'views/window_cv_act.php',
								data	: param,
								success	: function(msg){
									if(msg=="ok"){
										alert('Data berhasil disimpan');
										$("#edCVSkill").remove();
										location.href='index.php?mod=profile';
									}else {
										alert(msg);
									}
								}
							});
						}
					},
					"Tutup"	: function(){
						$("#edCVSkill").remove();
					}
				}
			});
		}
	}
}