<?php

class CError extends Controllers {

	public function index() {
	}

	public function error_404(){
        $this->registry->view->blog_heading = 'Error 404 - Halaman yang anda cari tidak ditemukan';
        $this->registry->view->show('error');
	}
	
	public function errLogin(){
		$this->registry->template->show('err-login');
	}
}
?>
