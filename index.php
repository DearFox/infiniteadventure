<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="apple-touch-icon" sizes="180x180" href="/img/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="/img/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="/img/favicon-16x16.png">
	<link rel="manifest" href="/img/site.webmanifest">
	<link rel="mask-icon" href="/img/safari-pinned-tab.svg" color="#5bbad5">
	<link rel="shortcut icon" href="/img/favicon.ico">
	<meta name="msapplication-TileColor" content="#da532c">
	<meta name="msapplication-config" content="/img/browserconfig.xml">
	<meta name="theme-color" content="#ffffff">
	<meta property="og:title" content="Infinite Adventure">
	<meta property="og:site_name" content="Бесконечные приключения">
	<meta property="og:url" content="https://infiniteadventure.paw.su/">
	<meta property="og:description" content="Веб комикс">
	<meta property="og:image" content="https://infiniteadventure.paw.su/logo-1.png">
	<meta property="og:image:width" content="640"/>
	<meta property="og:image:height" content="100"/>
	<title>Infinite Adventure</title>
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link href="https://fonts.googleapis.com/css2?family=Gabriela&display=swap" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Display&display=swap" rel="stylesheet">
	<style>
		* {
			font-family: 'Noto Sans Display', sans-serif;
			font-size: 20px;
		}
		body {
			background-color: #2e2e2e;
			width: 95%;
  		max-width: 1300px;
  		margin: 0 auto;
		}
		img {
			max-width: 700px;
			image-rendering: pixelated;
			//text-align: center;
		}
		.img {
			width: 100%;
		}
		noscript {
			margin-left: 10px;
			margin-right: 10px;
			color: red;
			font-size: 20px;
			text-align: center;
		}
		a {
			color: burlywood;
		}
		h3 {
			//font-family: 'Gabriela', serif;
			font-size: 35px;
		}
		p {
			margin: 0px;
		}
		details {
			margin-top: 10px;
			margin-bottom: 10px;
			color: burlywood;
		}
		.site {
			background-color: #574733;
			border-radius: 10px;
			width: 100%;
			min-width: 680px;
			padding-right: 3px;
			padding-bottom: 3px;
		}
		.table_style {
			width: 100%;
			//margin-bottom: 10px;
			//margin-top: 10px;
		}
		.header_style {
			//background-color: #6c5d4d;
			//background-image: url("q35yt43y.gif");
			//background-repeat: no-repeat;
			//background-position: top center;
			text-align: center;
			margin-bottom: 10px;
		}
		.content_stule {
			font-size: 25px;
			//text-align: center;
		}
		.comments {
			background-color: #6c5d4d;
			background-repeat: no-repeat;
			background-position: top center;
			text-align: center;
			margin-bottom: 10px;
			padding: 10px;
		}
		.comment {
			background-color: #c49135;
			padding: 10px;
			border-width: 3px; 
			border-style: solid;
			border-color: #805d31;
			border-radius: 10px;
			margin-top: 10px;
			margin-bottom: 10px;
			color: #000;
		}
		.comment p {
			margin: 0px;
		}
		.comment h3 {
			margin: 0px;
			font-size: 25px;
		}
		.border {
			border-width: 5px; 
			border-style: outset;
			border-color: #574733;
			border-radius: 10px;
		}
		.data {
			font-size: 10px;
  		margin-bottom: -15px;
  		margin-left: -23px;
  		color: #574733;
		}
	</style>
</head>
<body>
	<?php
		$page = preg_replace('~\D+~','', htmlspecialchars($_GET["page"]));

//Получение всех txt страничек page в папке pages.
		$arrayMaxAndCountPages = getMaxAndCountPages();
		$maxPagesNumber = $arrayMaxAndCountPages[0]; // Переменная с самым большим числом
		$pageCount = $arrayMaxAndCountPages[1]; // Переменная с количеством файлов
		function getMaxAndCountPages()
		{
			$folder = 'pages'; // Замените на путь к вашей папке
			$files = glob($folder . '/*.txt'); // Получаем все файлы в формате N.txt
			$maxNumber = 0; // Переменная с самым большим числом
			$fileCount = 0; // Переменная с количеством файлов
			foreach ($files as $file) {
			    $fileName = basename($file, '.txt'); // Получаем имя файла без расширения
			    if (is_numeric($fileName)) { // Проверяем, является ли имя файла числом
			        $number = intval($fileName); // Преобразуем имя файла в число
			        if ($number > $maxNumber) {
			            $maxNumber = $number; // Обновляем значение переменной с самым большим числом
			        }
			        $fileCount++; // Увеличиваем счетчик файлов
			    }
			}
			return [$maxNumber,$fileCount];
		}

if ($page == null) {
	$page = $maxPagesNumber;
}

$fileName = 'pages/' . $page . '.txt'; // Replace with the desired file name

if (file_exists($fileName)) {
    $fileContent = file($fileName);
    $output = '';

    foreach ($fileContent as $line) {
        if (strpos($line, '[img]') === 0) {
            $imageUrl = substr($line, 5);
            $output .= '<center><img class="img" src="' . $imageUrl . '"></center>';
        } elseif (strpos($line, '[comment]') === 0) {
            $line = substr($line, 9);
            $commentParts = explode('|', $line);
            $commentTitle = $commentParts[0];
            $commentText = $commentParts[1];
            $output .= '<div class="comment"><center><h3>' . $commentTitle . '</h3></center><i>' . $commentText . '</i></div>';
        }
        elseif (strpos($line, '[offcomment]') === 0) {
            $line = substr($line, 12);
            $commentParts = explode('|', $line);
            $commentTitle = $commentParts[0];
            $commentText = $commentParts[1];
            $output .= '<details><summary>Спойлер</summary><div class="comment"><center><h3>' . $commentTitle . '</h3></center><i>' . $commentText . '</i></div></details>';
        } elseif (strpos($line, '[title]') === 0) {
        	$titleText = substr($line, 7);
        	$output .= '<h3>' . $titleText . '</h3>';
        } elseif (strpos($line, '[data]') === 0) {
        	$dataText = substr($line, 6);
        	$output .= '<a class="data" name="' . rtrim($dataText) . '" href="/?page='.$page.'#' . rtrim($dataText) . '">' . $dataText . '</a>';
        }
        elseif (strpos($line, '[]') === 0) {
        	$output .= '<br>';
        }
        elseif (strpos($line, '[...]') === 0) {
        	$output .= '<center><img src="History-is-historying.gif" title="Итория исторится"></center>';
        }
        elseif (strpos($line, '#') === 0) {
        }
        else {
            $output .= '<p>' . $line . '</p>';
        }
    }
    $error404 = false;

    //echo $output;
} else {
    header("HTTP/1.0 404 Not Found");
    $output = '<center><h1>Error:</h1><img src="404.png" alt="404"><h2>File Not Found</h2><a href="https://infiniteadventure.paw.su/">Вернуться назад</a><br><br></center>';
    $error404 = true;
}
	?>
	<table class="table_style">
			<tr>
				<td class="table_style header_style" style="	min-width: 662px;" >
					<a href="https://infiniteadventure.paw.su/">
						<header>
							<!-- <h1 style="font-size: 45px">Infinite Adventure</h1> -->
							<img src="logo-1.png" alt="">
						</header>
					</a>
				</td>
			</tr>
		</table>
	<div class="site">
		<noscript class="noscript">
			Ваш браузер не поддерживает JavaScript,<br>
			я понимаю что вы цените свою конфедициальность,<br>
			но для корректной работы некоторых аспектов сайта он необходим.
		</noscript>
		<table class="table_style content_stule">
			<tr>
				<td class="border" style="background-color: #847158; 	padding-left: 25px; padding-right: 25px; min-width: 	300px;">
					<?php 
					echo $output;
					 ?>
				</td>
				<td class="border" style="background-color: #6a574c; 	width: 300px; max-width: 300px; min-width: 300px; 	text-align: center; vertical-align: top;">
					<div>
						<table class="table_style">
							<tr>
								<td>
									<h3>Menu</h3>
								</td>
							</tr>
							<tr>
								<td>
									<p>Вы на <?php echo $page . ' из ' . $maxPagesNumber; ?> </p>
								</td>
							</tr>
							<tr>
								<td>
									<?php 
									if ($page == 0) {
										echo "<a>Вы в самом начале</a>";
									}
									else {
										echo '<a href="?page=1">< В самое начало</a>';
									}
									 ?>
								</td>
							</tr>
							<tr>
								<td>
									<br>
									<br>
									<br>
									<p><a href="comment-policy.html">Правила комментирования</a></p>
								</td>
							</tr>
						</table>
					</div>
				</td>
			</tr>
		</table>
		<?php 
		if ($error404) {
		} else {
			AddComments($page);
		}
		 ?>
		
		<div class="bottom">
			<center>
				<i>
					Сделано DearFox в 2023 году
				</i> | 
				<a rel="me" href="https://meow.social/@DearFox">🐘</a> 
				<a href="https://DearFox.UwU.name">🦊</a>
			</center>
		</div>
	</div>
	<script id="dsq-count-scr" src="//infiniteadventure.disqus.com/count.js" async></script>
	<script type="text/javascript">
		document.title = `Infinite Adventure<?php if (htmlspecialchars($titleText) != ''){
			echo " - " . htmlspecialchars($titleText);
		};?>`
	</script>
</body>
</html>

<?php 
function AddComments($page)
{
	echo '
	<div class="comments border">
			<div id="disqus_thread"></div>
		</div>
			<script>
  	  	/**
  	  	*  RECOMMENDED CONFIGURATION VARIABLES: EDIT AND UNCOMMENT THE SECTION BELOW TO INSERT DYNAMIC VALUES FROM YOUR PLATFORM OR CMS.
  	  	*  LEARN WHY DEFINING THESE VARIABLES IS IMPORTANT: https://disqus.com/admin/universalcode/#configuration-variables    */
  	  	/*
  	  	this.page.url = PAGE_URL;  // Replace PAGE_URL with your page s canonical URL variable*/
  	  	var disqus_config = function () {
  	  	
  	  	this.page.url = "https://infiniteadventure.paw.su/?page=' . $page . '";
  	  	this.page.identifier = ' . $page . '; // Replace PAGE_IDENTIFIER with your page s unique identifier variable
  	  	};
  	  	
  	  	
' . 
"
(function() { // DON'T EDIT BELOW THIS LINE
  			  var d = document, s = d.createElement('script');
  			  s.src = 'https://infiniteadventure.disqus.com/embed.js';
  			  s.setAttribute('data-timestamp', +new Date());
  			  (d.head || d.body).appendChild(s);
  	  	})();
			</script>
" . '<noscript>Please enable JavaScript to view the <a href="https://disqus.com/?ref_noscript">comments powered by Disqus.</a></noscript>';

}
 ?>