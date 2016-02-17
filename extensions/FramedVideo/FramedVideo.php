<?php
 
/*******************************************************************************
*                                                                              *
* FramedVideo extention by Robert Pilawski, based on VideoFlash extension      *
* by Alberto Sarullo, based on YouTube extension by Iubito.                    *
*                                                                              * 
********************************************************************************/ 
 
$wgExtensionMessagesFiles['FramedVideo'] = dirname(__FILE__) . '/FramedVideo.i18n.php';
$wgExtensionFunctions[] = 'wfFramedVideo';
$wgExtensionCredits['parserhook'][] = array(
        'name' => 'FramedVideo',
        'description' => 'Allows embedding videos from various websites',
	'author' => '[http://filop.pl/wiki/U%C5%BCytkownik:Ruiz Ruiz]',
        'url' => 'http://www.mediawiki.org/wiki/Extension:FramedVideo'
);

function wfFramedVideo() {
        global $wgParser;
	//wfLoadExtensionMessages('FramedVideo');
        $wgParser->setHook('video', 'renderFramedVideo');
}

function renderFramedVideo($input, $args, $parser) {
        $defaultwidth = intval(wfMsg('framedvideo_default_width'));
	$rendervideo = "true";

	if (array_key_exists('type', $args)) { $type = htmlspecialchars($args['type']); }
		else { $type = "youtube"; }
	if (array_key_exists('id', $args)) { $id = htmlspecialchars($args['id']); }
		else {
			$id = "0";
			$rendervideo = "false";
			$errorid[4] = 1;
			$width = 1;
			$height = 1;
		}

	$twidth['bbsports'] = 425;		$theight['bbsports'] = 350;
	$twidth['bliptv'] = 640;		$theight['bliptv'] = 510;
	$twidth['break'] = 464;			$theight['break'] = 392;
	$twidth['broadcaster'] = 425;		$theight['broadcaster'] = 340;
	$twidth['clipshack'] = 430;		$theight['clipshack'] = 370;
	$twidth['comedycentral'] = 464;		$theight['comedycentral'] = 392;
	$twidth['dailymotion'] = 420;		$theight['dailymotion'] = 336;
	$twidth['error'] = $defaultwidth;	$theight['error'] = 1;
	$twidth['eyespot'] = 432;		$theight['eyespot'] = 407;
	$twidth['funnyordie'] = 464;		$theight['funnyordie'] = 388;
	$twidth['gazeta'] = 480;		$theight['gazeta'] = 393;
	$twidth['godtube'] = 330;		$theight['godtube'] = 270;
	$twidth['googlevideo'] = 400;		$theight['googlevideo'] = 326;
	$twidth['interia'] = 425;		$theight['interia'] = 350;
	$twidth['znajomi'] = 425;		$theight['znajomi'] = 350;
	$twidth['jumpcut'] = 408;		$theight['jumpcut'] = 324;
	$twidth['kewego'] = 400;		$theight['kewego'] = 368;
	$twidth['liveleak'] = 450;		$theight['liveleak'] = 370;
	$twidth['metacafe'] = 400;		$theight['metacafe'] = 345;
	$twidth['patrz'] = 425;			$theight['patrz'] = 331;
	$twidth['photobucket'] = 448;		$theight['photobucket'] = 361;
	$twidth['plejada'] = 640;		$theight['plejada'] = 396;	
	$twidth['putfile'] = 420;		$theight['putfile'] = 349;
	$twidth['revver'] = 480;		$theight['revver'] = 392;
	$twidth['rutube'] = 400;		$theight['rutube'] = 353;
	$twidth['selfcasttv'] = 340;		$theight['selfcasttv'] = 283;
	$twidth['selfcast'] = 340;		$theight['selfcast'] = 283;
	$twidth['sevenload'] = 455;		$theight['sevenload'] = 364;
	$twidth['sharkle'] = 340;		$theight['sharkle'] = 310;
	$twidth['shoutfile'] = 400;		$theight['shoutfile'] = 300;
	$twidth['spike'] = 448;			$theight['spike'] = 365;
	$twidth['stickam'] = 400;		$theight['stickam'] = 300;
	$twidth['superdeluxe'] = 400;		$theight['superdeluxe'] = 300;
	$twidth['uncutvideo'] = 415;		$theight['uncutvideo'] = 347;
	$twidth['veoh'] = 540;			$theight['veoh'] = 458;
	$twidth['videojug'] = 400;		$theight['videojug'] = 345;
	$twidth['viddler'] = 437;		$theight['viddler'] = 370;
	$twidth['vimeo'] = 400;			$theight['vimeo'] = 300;
	$twidth['wrzuta'] = 450;		$theight['wrzuta'] = 416;
	$twidth['yahoovideo'] = 512;		$theight['yahoovideo'] = 323;
	$twidth['youaretv'] = 350;		$theight['youaretv'] = 300;
	$twidth['youare'] = 350;		$theight['youare'] = 300;
	$twidth['youtube'] = 425;		$theight['youtube'] = 344;

	if (!(array_key_exists($type, $twidth))) {
		$rendervideo = "false";
		$errorid[3] = 1;
		$width = 1;
		$height = 1;
		$type2 = $type;
		$type = 'error';
	}

	$playerheight1 = 0;
	$playerheight2 = 0;

	if ($type=="bbsports") { $playerheight1 = 24; $playerheight2 = 20; }
	if ($type=="bliptv") { $playerheight1 = 30; $playerheight2 = 30; }
	if ($type=="dailymotion") { $playerheight1 = 21; $playerheight2 = 21; }
	if ($type=="funnyordie") { $playerheight1 = 40; $playerheight2 = 40; }
	if ($type=="gazeta") { $playerheight1 = 34; $playerheight2 = 34; }
	if ($type=="googlevideo") { $playerheight1 = 27; $playerheight2 = 27; }
	if ($type=="interia") { $playerheight1 = 49; $playerheight2 = 49; }
	if ($type=="znajomi") { $playerheight1 = 49; $playerheight2 = 49; }
	if ($type=="jumpcut") { $playerheight1 = 21; $playerheight2 = 21; }
	if ($type=="kewego") { $playerheight1 = 0; $playerheight2 = 26; }
	if ($type=="liveleak") { $playerheight1 = 20; $playerheight2 = 20; }
	if ($type=="metacafe") { $playerheight1 =31; $playerheight2 = 40; }
	if ($type=="photobucket") { $playerheight1 = 25; $playerheight2 = 25; }
	if ($type=="plejada") { $playerheight1 = 36; $playerheight2 = 36; }
	if ($type=="putfile") { $playerheight1 = 27; $playerheight2 = 50; }
	if ($type=="revver") { $playerheight1 = 32; $playerheight2 = 32; }
	if ($type=="rutube") { $playerheight1 = 36; $playerheight2 = 36; }
	if ($type=="selfcasttv") { $playerheight1 = 20; $playerheight2 = 20; }
	if ($type=="selfcast") { $playerheight1 = 20; $playerheight2 = 20; }
	if ($type=="sevenload") { $playerheight1 = 33; $playerheight2 = 33; }
	if ($type=="shoutfile") { $playerheight1 = 29; $playerheight2 = 29; }
	if ($type=="spike") { $playerheight1 = 31; $playerheight2 = 31; }
	if ($type=="superdeluxe") { $playerheight1 = 50; $playerheight2 = 50; }
	if ($type=="uncutvideo") { $playerheight1 = 47; $playerheight2 = 47; }
	if ($type=="veoh") { $playerheight1 = 34; $playerheight2 = 34; }
	if ($type=="viddler") { $playerheight1 = 42; $playerheight2 = 42; }
	if ($type=="videojug") { $playerheight1 = 30; $playerheight2 = 30; }
	if ($type=="yahoovideo") { $playerheight1 = 34; $playerheight2 = 34; }
	if ($type=="youtube") { $playerheight1 = 25; $playerheight2 = 25; }

	if (array_key_exists('width', $args) && $type != 'vimeo' && $type != 'dailymotion' && $type != 'bliptv') { $width = htmlspecialchars($args['width']); }
		else { $width = $twidth[$type]; }
	if (array_key_exists('height', $args) && $type != 'vimeo' && $type != 'dailymotion' && $type != 'bliptv') { $height = htmlspecialchars($args['height']); }
		else { $height = $theight[$type]; }

	if ($type == 'dailymotion' || $type == 'vimeo') {
		if ((array_key_exists('height', $args)) && !(array_key_exists('width', $args))) {
			$height = htmlspecialchars($args['height']);
			$width = $defaultwidth;
			$height = (htmlspecialchars($args['height']) - $playerheight1) / $twidth[$type] * $defaultwidth + $playerheight2;
			$height = round($height);
		}
		
		if (!(array_key_exists('height', $args)) && !(array_key_exists('width', $args))) {
			$width = $defaultwidth;
			$rendervideo = "false";
			$errorid[1] = 1;
		}
		if (!(array_key_exists('height', $args)) && (array_key_exists('width', $args))) {
			$width = htmlspecialchars($args['width']);
			$rendervideo = "false";
			$errorid[2] = 1;
		}
		if ((array_key_exists('height', $args)) && (array_key_exists('width', $args))) {
			$height = htmlspecialchars($args['height']);
			$width = htmlspecialchars($args['width']);
			$height = (htmlspecialchars($args['height']) - $playerheight1) / $twidth[$type] * $defaultwidth + $playerheight2;
			$height = round($height);
		}

	}

	if ($type == 'bliptv') {
		if ((array_key_exists('height', $args)) && (array_key_exists('width2', $args)) && !(array_key_exists('width', $args))) {
			$width = htmlspecialchars($args['width2']);
			$height = htmlspecialchars($args['height']);
			if($width < 1) {
				$width = $defaultwidth;
				$rendervideo = "false";
				$errorid[11] = 1;
			} else {	
				$height = ($height - $playerheight1) * $defaultwidth / $width + $playerheight2;
				$width = $defaultwidth;
			}
		} elseif ((array_key_exists('height', $args)) && (array_key_exists('width', $args))) {
			$width = htmlspecialchars($args['width']);
			$height = htmlspecialchars($args['height']);
		} else {
		$rendervideo = "false";
		$width = $defaultwidth;
		$errorid[10] = 1;
		}
	}

        $url['bbsports']    = 'http://broadbandsports.com/flv/bbs-xplayer.swf?n='.$id;
	$url['bliptv']      = 'http://blip.tv/play/'.$id;
        $url['break']       = 'http://embed.break.com/'.$id;
	$url['brightcove']  = 'http://';
        $url['broadcaster'] = 'http://www.broadcaster.com/video/external/player.swf?clip='. $id .'.flv';
        $url['clipshack']   = 'http://clipshack.com/player.swf?key='.$id;
	$url['comedycentral'] = 'http://www.comedycentral.com/sitewide/video_player/view/default/swf.jhtml';
        $url['dailymotion'] = 'http://www.dailymotion.com/swf/'.$id;
	$url['error']       = '';
        $url['eyespot']     = 'http://eyespot.com/flash/medialoader.swf?vurl=http://downloads.eyespot.com/direct/play?r='.$id.'&_autoPlay=false';
        $url['funnyordie']  = 'http://www2.funnyordie.com/public/flash/fodplayer.swf?7228';
	$url['gazeta']      = 'http://bi.gazeta.pl/im/loader.swf';
	$url['godtube']     = '';
        $url['googlevideo'] = 'http://video.google.com/googleplayer.swf?docId=-'. $id .'&hl=pl';
        $url['interia']     = 'http://video.interia.pl/player.js';
        $url['jumpcut']     = 'http://jumpcut.com/media/flash/jump.swf?id='.$id.'&asset_type=movie&asset_id='.$id.'&eb=1';
        $url['kewego']      = 'http://www.kewego.com/p/en/'. $id .'.html';
        $url['liveleak']    = 'http://www.liveleak.com/e/'.$id;
        $url['metacafe']    = 'http://www.metacafe.com/fplayer/'.$id.'.swf';
        $url['patrz']       = 'http://patrz.pl/patrz.pl.swf?id='. $id .'&r=5&o=';
	$url['photobucket'] = 'http://';
	$url['plejada']     = 'http://www.plejada.pl/_d/flash/'.$id.',player_loader.swf';
        $url['putfile']     = 'http://feat.putfile.com/flow/putfile.swf?videoFile='.$id;
        $url['revver']      = 'http://flash.revver.com/player/1.0/player.swf?mediaId='.$id;
        $url['rutube']      = 'http://video.rutube.ru/'.$id;
        $url['selfcast']    = 'http://www.selfcasttv.com/Selfcast/selfcast.swf?video_1=/s/'.$id;
        $url['selfcasttv']  = 'http://www.selfcasttv.com/Selfcast/selfcast.swf?video_1=/s/'.$id;
        $url['sevenload']   = 'http://en.sevenload.com/pl/'. $id .'/'. $width .'x'. $height .'/swf';
        $url['sharkle']     = 'http://www.sharkle.com/externalPlayer/'.$id;
        $url['shoutfile']   = 'http://www.shoutfile.com/emb/'.$id;
        $url['spike']       = 'http://www.spike.com/efp';
        $url['stickam']     = 'http://player.stickam.com/flashVarMediaPlayer/'.$id;
        $url['superdeluxe'] = 'http://i.cdn.turner.com/sdx/static/swf/share_vidplayer.swf';
	$url['uncutvideo']  = 'http://';
        $url['veoh']        = 'http://www.veoh.com/videodetails2.swf?permalinkId='. $id .'&id=anonymous&player=videodetailsembedded&videoAutoPlay=0';
        $url['videojug']    = 'http://www.videojug.com/film/player?id='.$id;
        $url['viddler']     = 'http://www.viddler.com/player/'. $id .'/';
        $url['vimeo']       = 'http://www.vimeo.com/moogaloop.swf?clip_id='. $id .'&amp;server=www.vimeo.com&amp;show_title=1&amp;show_byline=1&amp;show_portrait=0&amp;color=&amp;fullscreen=1';
	$url['wrzuta']      = 'http://www.wrzuta.pl/wrzuta_embed.js';
	$url['yahoovideo']  = 'http://d.yimg.com/static.video.yahoo.com/yep/YV_YEP.swf?ver=2.2.4';
        $url['youare']      = 'http://www.youare.tv/player/yatvplayer.swf?videoID='.$id;
        $url['youaretv']    = 'http://www.youare.tv/player/yatvplayer.swf?videoID='.$id;
        $url['youtube']     = 'http://www.youtube.com/v/'.$id;
        $url['znajomi']     = 'http://video.interia.pl/player.js';

	if (array_key_exists('desc', $args)) { $desc = $args['desc']; }
		else { $desc = ''; }
	if (array_key_exists('size', $args)) { $size = htmlspecialchars($args['size']); }
		else { $size = ''; }

        $allowfullscreen = wfMsg('framedvideo_allow_full_screen');
        $forceallowfullscreen = wfMsg('framedvideo_force_allow_full_screen');
	if ($allowfullscreen == 'true' && $forceallowfullscreen != 'true') {
		if (array_key_exists('allowfullscreen', $args)) {
			$allowfullscreen = htmlspecialchars($args['allowfullscreen']);
			if ($allowfullscreen != 'true') {
				$allowfullscreen = "false";
			} else {
			$allowfullscreen = 'true';
			}
		}
	} elseif ($allowfullscreen == 'false' && $forceallowfullscreen == 'true') {
		$allowfullscreen = "false";
	} elseif ($allowfullscreen == 'false' && $forceallowfullscreen == 'false' && !(array_key_exists('allowfullscreen', $args))) {
		$allowfullscreen = "false";
	} else {
		$allowfullscreen = "true";
	}

        $frame = wfMsg('framedvideo_frames');
        $forceframes = wfMsg('framedvideo_force_frames');
	if ($frame == 'true' && $forceframes != 'true') {
		if (array_key_exists('frame', $args)) {
			$frame = htmlspecialchars($args['frame']);
			if ($frame != 'true') {
				$frame = "false";
			} else {
			$frame = 'true';
			}
		}
	} elseif ($frame == 'false' && $forceframes == 'true') {
		$frame = "false";
	} elseif ($frame == 'false' && $forceframes == 'false' && !(array_key_exists('frame', $args))) {
		$frame = "false";
	} else {
		$frame = "true";
	}

	$forcesize = "false";
	if((wfMsg('framedvideo-forcesize') == "true")) {
		$forcesize = "true";
	}

	$position2 = wfMsg('framedvideo_position');
        $forceposition = wfMsg('framedvideo_force_position');
	if ($forceposition != 'true') {
		if (array_key_exists('position', $args)) {
			$position = htmlspecialchars($args['position']);
		} else { $position = "right"; }
	} else {
		if ($position2 == 'right' || $position2 == 'center' || $position2 == 'left') {
			$position = $position2;
		}
	}
	
	if ($type != 'vimeo' && $type != 'dailymotion' && $type != 'bliptv') {
	if ($forcesize == "true") {
		$width = $defaultwidth;
		$height = round(($theight[$type] - $playerheight1) / $twidth[$type] * $defaultwidth) + $playerheight2;
 	} elseif ($forcesize == "false" && !(array_key_exists('width', $args)) && !(array_key_exists('height', $args))) {
		$width = $defaultwidth;
		$height = round(($theight[$type] - $playerheight1) / $twidth[$type] * $defaultwidth) + $playerheight2;
	} elseif ($forcesize == "false" && (array_key_exists('width', $args)) && !(array_key_exists('height', $args))) {
		$height = round(($theight[$type] - $playerheight1) / $twidth[$type] * $width) + $playerheight2;
	} elseif ($forcesize == "false" && (array_key_exists('width', $args)) && (array_key_exists('height', $args))) {
		$width = htmlspecialchars($args['width']);
		$height = htmlspecialchars($args['height']);
	}
	}

	if($size=="full" && $forcesize=="false") {
		$width = $twidth[$type];
		$height = $theight[$type];
	}

	if($size=="full") {
		if($type=="dailymotion" || $type=="vimeo") {
			$rendervideo = "false";
			$errorid[9] = 1;
			$width = $defaultwidth;
			$height = 1;
		}
	}		

	$maxwidth = intval(wfMsg('framedvideo_max_width'));
	$maxheight = intval(wfMsg('framedvideo_max_height'));

	if($width > $maxwidth) {
		$width = $defaultwidth;
		$rendervideo = "false";
		$errorid[5] = 1;
	}		

	if($height > $maxheight) {
		$rendervideo = "false";
		$errorid[6] = 1;
	}


	if($width < 1) {
		$width = $defaultwidth;
		$rendervideo = "false";
		$errorid[7] = 1;
	}	

	if($height < 1) {
		$height = 1;
		$rendervideo = "false";
		$errorid[8] = 1;
	}

	$widthframe = ($width + 2);

	if ($position == null && $frame =="true") {
		$output = '<div class="thumb tright"> <div class="thumbinner" style="width: '.$widthframe.'px;" border="0">';
	}
	if ($position != null && $frame == "true") {
		if ($position == "center") {
		      $output = '<div class="center"><div class="thumb tnone"> <div class="thumbinner" style="width: '.$widthframe.'px;" border="0">';
		} elseif ($position == "left") {
			$output = '<div class="thumb tleft"> <div class="thumbinner" style="width: '.$widthframe.'px;" border="0">';
		} else {
			$output = '<div class="thumb tright"> <div class="thumbinner" style="width: '.$widthframe.'px;" border="0">';
		}
	}
	if ($frame != null && $frame != "true") {
		if ($position == "center") {
			$output = '<div class="center"><div class="floatnone" style="width: '.$width.'px;"><span>';
		} elseif ($position == "left") {
			$output = '<div class="floatleft" style="width: '.$width.'px;"><span>';
		} else {
			$output = '<div class="floatright" style="width: '.$width.'px;"><span>';
		}
	}
	if ($rendervideo == "true") {
        if($type=='superdeluxe') {
        $output.= '<object width="'.$width.'" height="'.$height.'"><param name="allowFullScreen" value="'.$allowfullscreen.'" />'
                .'<param name="movie" value="http://i.cdn.turner.com/sdx/static/swf/share_vidplayer.swf" />'
                .'<param name="FlashVars" value="'.$id.'" />'
                .'<embed src="http://i.cdn.turner.com/sdx/static/swf/share_vidplayer.swf"'
                .'FlashVars="id='.$id.'" type="application/x-shockwave-flash"'
                .'width="'.$width.'" height="'.$height.'" allowFullScreen="true"';
        } elseif ($type=='interia' || $type=='znajomi') {
        $output.= '<script type="text/javascript" src="http://video.interia.pl/player.js#'.$id.','.$width.','.$height.'"></script>';
        } elseif ($type=='shoutfile') {
	$output.= '<object width="'.$width.'" height="'.$height.'">'
	         .'<embed allowScriptAccess="always" src="http://www.shoutfile.com/emb/'.$id.'"'
	         .' allowFullScreen="'.$allowfullscreen.'" width="'.$width.'" height="'.$height.'" border="0"'
	         .' type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer"';
	} elseif ($type=='videojug') {
	$output.= '<object classid="clsid:d27cdb6e-ae6d-11cf-96b8-444553540000"'
		.' codebase="http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,0,0"'
		.' id="vjplayer04062008" width="400" height="345" align="middle" allowFullScreen="true">'
		.'<param name="movie" value="http://www.videojug.com/film/player?id='.$id.'" />'
		.'<PARAM value="'.$allowfullscreen.'" name="allowFullScreen" /><PARAM value="always" name="allowScriptAccess" />'
		.'<embed src="http://www.videojug.com/film/player?id='.$id.'"'
		.' quality="high" width="'.$width.'" height="'.$height.'" type="application/x-shockwave-flash"'
		.' pluginspage="http://www.macromedia.com/go/getflashplayer" allowscriptaccess="always"'
		.' allowfullscreen="true"';
	} elseif ($type=='youaretv' || $type=='youare') {
	$output.= '<embed  src=\'http://www.youare.tv/yatvplayer.swf?videoID='.$id.'\' allowScriptAccess=\'never\''
		 .' loop=\'false\' quality=\'best\' wmode=\'transparent\' width=\''.$width.'\' height=\''.$height.'\''
		 .' type=\'application\x-shockwave-flash\' ></embed>';
	} elseif ($type=='wrzuta') {
	$id = htmlspecialchars_decode($id);
	$id = preg_replace('/>/', '&gt;', $id);
	$id = preg_replace('/</', "&lt;", $id);
	$output.='<script type="text/javascript" src="http://www.wrzuta.pl/wrzuta_embed.js?wrzuta_key='.$id.'&wrzuta_width='.$width.'&wrzuta_height='.$height.'"></script>';
	} elseif ($type=='yahoovideo') {
	$output.='<object width="'.$width.'" height="'.$height.'">'
		.'<param name="movie" value="http://d.yimg.com/static.video.yahoo.com/yep/YV_YEP.swf?ver=2.2.4" />'
		.'<param name="allowFullScreen" value="'.$allowfullscreen.'" />'
		.'<param name="flashVars" value="id='.$id.'&lang=en-us&intl=us&thumbUrl=&embed=1" />'
		.'<embed src="http://d.yimg.com/static.video.yahoo.com/yep/YV_YEP.swf?ver=2.2.4" '
		.'type="application/x-shockwave-flash" width="'.$width.'" height="'.$height.'" '
		.'allowFullScreen="true" flashVars="id='.$id.'&lang=en-us&intl=us&thumbUrl=&embed=1" ';
	} elseif ($type == 'photobucket') {
	$output.='<embed width="'.$width.'" height="'.$height.'" type="application/x-shockwave-flash" '
		.'wmode="transparent" src="http://'.$id.'&amp;sr=1">';
	} elseif ($type == 'uncutvideo') {
	$output.='<object width="'.$width.'" height="'.$height.'">'
		.'<param name="wmode" value="opaque" /><param name="movie" '
		.'value="http://uncutvideo.aol.com/v7.306/en-US/uc_videoplayer.swf" /><param name="FlashVars" '
		.'value="aID='.$id.'&site=http://uncutvideo.aol.com/"/>'
		.'<embed src="http://uncutvideo.aol.com/v7.306/en-US/uc_videoplayer.swf" wmode="opaque" '
		.'FlashVars="aID='.$id.'&site=http://uncutvideo.aol.com/" width="'.$width.'" height="'.$height.'" '
		.'type="application/x-shockwave-flash"';
	} elseif ($type == 'godtube' ) {
	$output.='<embed src="http://godtube.com/flvplayer.swf" FlashVars="viewkey='.$id.'" wmode="transparent" quality="high" '
		.'width="'.$width.'" height="'.$height.'" name="godtube" align="middle" allowScriptAccess="sameDomain" '
		.'type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" /></embed>';
	} else {
        $output.= '<object width="'.$width.'" height="'.$height.'">'
                .'<param name="movie" value="'.$url[$type].'"> <param name="allowfullscreen" value="'.$allowfullscreen.'" />'
                .'<param name="wmode" value="transparent"></param>'
                .'<embed src="'.$url[$type]
                .'" type="application/x-shockwave-flash" wmode="transparent"'
                .' width="'.$width.'" height="'.$height.'" allowfullscreen="true"';
        if($type=='revver') {
                        $output.='flashvars="mediaId='.$id.'&affiliateId=0"';
        }
        if($type=='gazeta') {
			$output.='FlashVars="m=http://serwisy.gazeta.pl/getDaneWideo?xx='.$id.'%26xxd=0&e=1&f=http://bi.gazeta.pl/im/"';
	}
        if($type=='funnyordie') {
                        $output.='flashvars="key='.$id.'"';
        }
        if($type=='bbsports') {
                        $output.='allowscriptaccess="always" flashvars="nid=.'.$id.'"';
        }
        if($type=='stickam') {
                        $output.='scale="scale" allowScriptAccess="always"';
        }
	if($type=='comedycentral') {
                        $output.='FlashVars="videoId='.$id.'" quality="high" bgcolor="#cccccc" name="comedy_central_player" align="middle" allownetworking="external"';
        }
        if($type=='spike') {
                        $output.='flashvars="flvbaseclip='.$id.'&"';
        }
	if ($type != "interia" && $type != "znajomi" && $type != "youaretv" && $type != "youare" && $type != "wrzuta" && $type != 'brightcove') {
		$output.='></embed></object>';
	}
	if (array_key_exists('desc', $args)) {
		$output.= '<div class="thumbcaption" align="left">';
		$output.= efWonderfulHook ($desc, '', $parser).'</div>';
	}
	}
	} else {
		$output.= '<div class="thumbcaption" align="left">';
		$errors = array_sum($errorid);
		if ($errors == 1) {
			$output.= wfMsg( 'framedvideo_error' );
		} else {
			$output.= wfMsg( 'framedvideo_errors' );
		}
		if (array_key_exists(1, $errorid)) { $output.= '<br />'.wfMsg( 'framedvideo_error_height_required', $type ); }
		if (array_key_exists(2, $errorid)) { $output.= '<br />'.wfMsg( 'framedvideo_error_height_required_not_only_width', $type ); }
		if (array_key_exists(3, $errorid)) { $output.= '<br />'.wfMsg( 'framedvideo_error_unknown_type', $type2 ); }
		if (array_key_exists(4, $errorid)) { $output.= '<br />'.wfMsg( 'framedvideo_error_no_id_given' ); }
		if (array_key_exists(5, $errorid)) {
			$output.= '<br />'.wfMsg( 'framedvideo_error_width_too_big' );
			$output.= ' '.wfMsg( 'framedvideo_error_limit', $maxwidth );
		}
		if (array_key_exists(6, $errorid)) {
			$output.= '<br />'.wfMsg( 'framedvideo_error_height_too_big' );
			$output.= ' '.wfMsg( 'framedvideo_error_limit', $maxheight );
		}
		if (array_key_exists(7, $errorid)) { $output.= '<br />'.wfMsg( 'framedvideo_error_no_integer', 'width' ); }
		if (array_key_exists(8, $errorid)) { $output.= '<br />'.wfMsg( 'framedvideo_error_no_integer', 'height' ); }
		if (array_key_exists(9, $errorid)) { $output.= '<br />'.wfMsg( 'framedvideo_error_full_size_not_allowed', $type ); }
		if (array_key_exists(10, $errorid)) { $output.= '<br />'.wfMsg( 'framedvideo_error_height_and_width_required', $type ); }
		if (array_key_exists(11, $errorid)) { $output.= '<br />'.wfMsg( 'framedvideo_error_no_integer', 'width2' ); }
		$output.='<br />'.$parser->recursiveTagParse(wfMsg( 'framedvideo_error_see_help' )).'</div>';
	}
	if ($position == null) {
		$output.= '</div></div>';
	}
	if ($position != null && $frame == "true") {
		if ($position == "center") {
			$output.= '</div></div></div>';
		} elseif ($position == "left") {
			$output.= '</div></div>';
		} else {
			$output.= '</div></div>';
		}
	}
	if ($position != null && $frame != "true") {
		if ($position == "center") {
			$output.= '</span></div></div>';
		} elseif ($position == "left") {
			$output.= '</span></div>';
		} else {
			$output.= '</span></div>';
		}
	}
	return $output;
}

function efWonderfulHook( $text, $args, &$parser ) {
   $output = $parser->recursiveTagParse( $text );
   return $output;
}
