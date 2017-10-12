<article class="content dashboard-page">
<section class="section">
<div class="row sameheight-container col-md-12">
	<div class="col col-xs-12 col-sm-12 col-md-12 col-xl-12 stats-col">
		<div class="card sameheight-item stats" data-exclude="xs">
			<div class="card-block">
				<div class="title-block">
					<h4 class="title"><i class="fa fa-bar-chart-o"></i> &nbsp Stats</h4>
					<p class="title-description">
						 Statistik data <a href="#">WOI.OR.ID</a>
					</p>
				</div>
				<div class="row row-sm stats-container">
					<div class="col-xs-12 col-sm-4  stat-col">
						<div class="stat-icon">
							<i class="fa fa-user"></i>
						</div>
						<div class="stat">
							<div class="value"><?php echo getCountData("select * from tbl_user");?> orang</div>
							<div class="name">Total Member Terdaftar</div>
						</div>
						<progress class="progress stat-progress" value="<?php echo getCountData("select * from tbl_user");?>" max="100">
						<div class="progress">
							<span class="progress-bar" style="width: 34%;"></span>
						</div>
						</progress>
					</div>
					<div class="col-xs-12 col-sm-4  stat-col">
						<div class="stat-icon">
							<i class="fa fa-users"></i>
						</div>
						<div class="stat">
							<div class="value"><?php echo getCountData("select * from tbl_komunitas");?> Komunitas</div>
							<div class="name">Total Komunitas</div>
						</div>
						<progress class="progress stat-progress" value="<?php echo getCountData("select * from tbl_komunitas");?>" max="100">
						<div class="progress">
							<span class="progress-bar" style="width: 34%;"></span>
						</div>
						</progress>
					</div>
					<div class="col-xs-12 col-sm-4  stat-col">
						<div class="stat-icon">
							<i class="fa fa-heart"></i>
						</div>
						<div class="stat">
							<div class="value"><?php echo getCountData("select * from tbl_wakaf_proyek");?> Proyek</div>
							<div class="name">Total Proyek Wakaf</div>
						</div>
						<progress class="progress stat-progress" value="<?php echo getCountData("select * from tbl_wakaf_proyek");?>" max="100">
						<div class="progress">
							<span class="progress-bar" style="width: 34%;"></span>
						</div>
						</progress>
					</div>
					<div class="col-xs-12 col-sm-4  stat-col">
						<div class="stat-icon">
							<i class="fa fa-money"></i>
						</div>
						<div class="stat">
							<div class="value">Rp <?php echo setHarga(getSumData("select sum(jumlah_wakaf) as total from tbl_wakaf_donasi"));?></div>
							<div class="name">Total Wakaf Diterima</div>
						</div>
						<progress class="progress stat-progress" value="<?php echo getSumData("select sum(jumlah_wakaf) as total from tbl_wakaf_donasi");?>" max="10000000">
						<div class="progress">
							<span class="progress-bar" style="width: 34%;"></span>
						</div>
						</progress>
					</div>
					<div class="col-xs-12 col-sm-4  stat-col">
						<div class="stat-icon">
							<i class="fa fa-envelope"></i>
						</div>
						<div class="stat">
							<div class="value"><?php echo getCountData("select * from tbl_subscriber");?> Email</div>
							<div class="name">Total Email Subscribe</div>
						</div>
						<progress class="progress stat-progress" value="<?php echo getCountData("select * from tbl_subscriber");?>" max="100">
						<div class="progress">
							<span class="progress-bar" style="width: 34%;"></span>
						</div>
						</progress>
					</div>
					<div class="col-xs-12 col-sm-4  stat-col">
						<div class="stat-icon">
							<i class="fa fa-file"></i>
						</div>
						<div class="stat">
							<div class="value"><?php echo getCountData("select * from tbl_post");?> Post</div>
							<div class="name">Total Berita & tausyiah</div>
						</div>
						<progress class="progress stat-progress" value="<?php echo getCountData("select * from tbl_post");?>" max="100">
						<div class="progress">
							<span class="progress-bar" style="width: 34%;"></span>
						</div>
						</progress>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

</section>
</article>