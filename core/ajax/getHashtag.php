<?php
	// echo '<li><span class="getValue">'.$_POST['hashtag'].'</span></li>';

	include '../init.php';
		$getFromU->preventAccess($_SERVER['REQUEST_METHOD'], realPath(__FILE__), realPath($_SERVER['SCRIPT_FILENAME']));
	if (isset($_POST['hashtag'])) {
		$hashtag = $getFromU->checkInput($_POST['hashtag']);
		$tag = $getFromU->checkInput($_POST['hashtag']);

		if (substr($hashtag,0,1) === '#') {
			$trend = str_replace('#', '', $hashtag);
			$trends = $getFromT->getTrendByHash($trend);

			foreach ($trends as $hashtag) {
				echo '<li><a href="#"><span class="getValue">#'.$hashtag->hashtag.'</span></a></li>';
			}
		}

		if (substr($tag,0,1) === '@') {
			$tag = str_replace('@', '', $tag);
			$tags = $getFromT->getTag($tag);

			foreach ($tags as $tag) {
				echo '<li><div class="nav-right-down-inner">
						<div class="nav-right-down-left">
							<span><img src="'.BASE_URL.$tag->profileimage.'"></span>
						</div>
						<div class="nav-right-down-right">
							<div class="nav-right-down-right-headline">
								<a>'.$tag->screenName.'</a><span class="getValue">@'.$tag->username.'</span>
							</div>
						</div>
					</div><!--nav-right-down-inner end-here-->
					</li>
';
			}
		}
	}
 ?>
