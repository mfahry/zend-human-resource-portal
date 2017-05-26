<div class="box">
			<?php if($_SESSION['level_id'] == 2): ?>
				<p><b>Selamat datang HRD Neuronworks..!</b></p>
				<p>Dari menu header tersebut, Anda dapat melakukan:</p>
				<ul>
					<li><b>Staffing</b>, Anda dapat melihat seluruh status User dan dapat mengatur penghapusan atau perubahan detail user.</li>	               
					<li><b>Reporting</b>, Anda dapat melihat seluruh absensi yang dilakukan oleh Team. Baik Absen Harian ataupun Absen Keluar. Anda dapat mengunduh seluruh laporan absensi Team.</li>	
						<ul style="padding-left:15px;">	
							<li><b>Laporan Mingguan</b>,</li>	
							<li><b>Laporan Bulanan</b>, </li>	
							<li><b>Laporan Keluar Kantor</b>, </li>	
							<li><b>Statistik</b>, </li>	
                        </ul>
					
                    <li><b>Recommendation</b>, Untuk melakukan rekomendasi jika terdapat Team yang tidak masuk.</li> 
						<ul style="padding-left:15px;">	
							<li><b>Rekomendasi</b>,</li>	
							<li><b>Status Rekomendasi</b>, Status rekomendasi Team yang telah diberikan.</li>	
                        </ul>
					<li><b>Knowledge</b> </li>	
					<li><b>Profil</b> </li>
				</ul>
			<?php elseif($_SESSION['level_id'] == 1): ?>
					<p><b>Selamat datang Admin Neuronworks..!</b></p>
					<p>Dari menu header tersebut, Anda dapat melakukan:</p>
					<ul>
						<li><b>Staffing</b>, Anda dapat melihat seluruh status User dan dapat mengatur penghapusan atau perubahan detail user.</li>	               
						<li><b>Setting</b>, Untuk melakukan perubahan status hari kerja dalam kalender.</li> 	
							<ul style="padding-left:15px;">	
								<li><b>Polling</b>,</li>	
								<li><b>Kalender</b></li>	
								<li><b>Kategori knowledge</b></li>	
                    	    </ul>
                        <li><b>Knowledge</b> </li>	
                        <li><b>Profil</b> </li>
					</ul>
			<?php elseif($_SESSION['level_id'] == 4): ?>
					<p class=\"header3b\">Selamat datang Finance Neuronworks..!</p>
					<p>Dari menu header tersebut, Anda dapat melakukan:</p>
					<ul>
						<li><strong>Master Gaji</strong>, Anda dapat melakukan penambahan atau pengubahan deskripsi umum gaji.</li>	
						<li><strong>Gaji</strong>, Untuk mengetahui deskripsi gaji tiap Team.</li> 
						<li><strong>Gaji Dibayarkan</strong>, Untuk mengetahui gaji tiap Team pada bulan ini.</li>	
						<li><strong>Profil</strong>, Untuk pengubahan Password (sementara).</li>	
						<li><strong>News</strong>, Anda dapat melihat seluruh berita yang ada.</li>
					</ul>
			<?php endif; ?>
</div>