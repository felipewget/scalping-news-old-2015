<?php 

	// error_reporting(0);

	//http://www.atoananet.com.br/blog/portal-curiosidades

	/*

		MACRO LISTA AS PRINCIPAIS NOTICIAS NA QUAL ME DA UM LINK PROVCISÓRIO, ACESSAREI O LINK PROVISÓRIO E PEGAREI O LINK REAL ONDE ESTA A NOTÍCIA

	*/

	class MundoNerd {

		public function acessLink($url)
		{

			$ch = curl_init($url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_AUTOREFERER, $url);

			curl_setopt($ch,CURLOPT_COOKIEJAR, "cookie.txt");
	        curl_setopt($ch,CURLOPT_COOKIEFILE, "cookie.txt");

	        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.130 Safari/537.36');

	        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

			return $page = curl_exec($ch);
			curl_close($ch);

		}

		public function cortaCodigo($codigo, $comeco, $fim)
		{

			$aux = explode($comeco, $codigo);
			$aux = explode($fim, $aux[1]);
			return $aux[0];

		}

		public function percorreCodigo($codigo, $seletorExplode)
		{

			$arr = explode($seletorExplode, $codigo);
			return $arr;

		}

	}

	/////////////////////////////////////////////////////////////////////////////////////////////////////

	$class = new MundoNerd();

	$pagina = $class->acessLink('http://portalmundonerd.com.br/');

	$arrBox = $class->percorreCodigo($pagina, '<article class="item-list">');

	foreach($arrBox as $blocoUn)	
	{

		$link = $class->cortaCodigo($blocoUn, '<a href="', '"');
		$titulo = strip_tags($class->cortaCodigo($blocoUn, '<h2 class="post-box-title">', '</h2>'));

		$descricao = strip_tags($class->cortaCodigo($blocoUn, '<div class="entry">', '</div>'));

		// $data = implode("-", array_reverse(explode("/", ($class->cortaCodigo($blocoUn, '<div class="data">', '</div>')))));

		if(strlen($link) > 5 && strlen($titulo) > 5){

			//  echo $titulo;
			//  echo '<br/>';
			//  echo '<hr />';
			// echo $descricao;
			// echo '<br/>';
			//  echo '<hr />';
			 // echo $link;
			 // echo '<br/>';
			 // echo '<hr />';
			// echo $data;
			// echo '<br/>';

			 if(strlen(strstr($link, 'portalmundonerd')) > 5){

				$paginaLinkProvisorio = $class->acessLink($link);
				
				$conteudo = $class->cortaCodigo($paginaLinkProvisorio, '<div class="entry">', '<!-- .entry /-->');
				
				$tags = ($class->cortaCodigo($paginaLinkProvisorio, '<p class="post-tag">', '</p>'));
				$tags = str_replace(" ", ",", strip_tags($tags));

				die();

			 }

		}

		// if(strlen($link) > 5 && 'http://www.vocesabia.net/wp-content/themes/bigfoot/style.css' != $link){
			
		// 	$imagem = $class->cortaCodigo($blocoUn, '<img', '>');
		// 	$imagem = $class->cortaCodigo($blocoUn, 'src="', '"');
		// 	$imagem = str_replace('-600x150', '', $imagem);
		// 	die();

		// 	$paginaLinkProvisorio = $class->acessLink($link);

		// 	$conteudo = $class->cortaCodigo($paginaLinkProvisorio, '<div id="divSpdInText" class="entry">', '<div class="tags">');

		// }

	}

?>