

(function($) {
	$.fn.validationEngineLanguage = function() {};
	$.validationEngineLanguage = {
		newLang: function() {
			$.validationEngineLanguage.allRules = 	{
					"required":{    			// Add your regex rules here, you can take telephone as an example
						"regex":"none",
						"alertText":"* Kolom ini harus diisi",
						"alertTextCheckboxMultiple":"* Pilih salah satu opsi",
						"alertTextCheckboxe":"* Centang salah satu"},
					"length":{
						"regex":"none",
						"alertText":"* Hanya ",
						"alertText2":" sampai ",
						"alertText3": " karakter"},
					"maxCheckbox":{
						"regex":"none",
						"alertText":"* Anda memilih terlalu banyak"},	
					"minCheckbox":{
						"regex":"none",
						"alertText":"* silakan pilih ",
						"alertText2":" pilihan"},	
					"confirm":{
						"regex":"none",
						"alertText":"* Kolom password tidak cocok"},		
					"telephone":{
						"regex":"/^[0-9\-\(\)\ ]+$/",
						"alertText":"* Nomor telepon tidak valid"},	
					"email":{
						"regex":"/^[a-zA-Z0-9_\.\-]+\@([a-zA-Z0-9\-]+\.)+[a-zA-Z0-9]{2,4}$/",
						"alertText":"* Alamat email tidak valid"},	
					"date":{
                         "regex":"/^[0-9]{4}\-\[0-9]{1,2}\-\[0-9]{1,2}$/",
                         "alertText":"* Format tanggal YYYY-MM-DD"},
					"onlyNumber":{
						"regex":"/^[0-9\ ]+$/",
						"alertText":"* Hanya angka"},	
					"noSpecialCaracters":{
						"regex":"/^[0-9a-zA-Z\ \&\(\)\-|_\+\=\{\}\:\"\,\.]+$/",
						"alertText":"* Karakter khusus tidak diperbolehkan."},	
					"ajaxUser":{
						"file":"validateUser.php",
						"extraData":"name=eric",
						"alertTextOk":"* Anda dapat menggunakan user ini",	
						"alertTextLoad":"* Loading, silakan tunggu",
						"alertText":"* User ini sudah dipakai"},	
					"ajaxName":{
						"file":"validateUser.php",
						"alertText":"* Nama ini sudah dipakai",
						"alertTextOk":"* Anda dapat memakai nama ini",	
						"alertTextLoad":"* Loading, silakan tunggu"},		
					"onlyLetter":{
						"regex":"/^[a-zA-Z\ \']+$/",
						"alertText":"* Hanya huruf"},
					"validate2fields":{
    					"nname":"validate2fields",
    					"alertText":"* Anda harus mengisi firstname dan lastname"} 	
					}	
					
		}
	}
})(jQuery);

$(document).ready(function() {	
	$.validationEngineLanguage.newLang();
	
});