<?php 

	// error_reporting(0);

	//http://www.atoananet.com.br/blog/portal-curiosidades

	/*

		MACRO LISTA AS PRINCIPAIS NOTICIAS NA QUAL ME DA UM LINK PROVCISÓRIO, ACESSAREI O LINK PROVISÓRIO E PEGAREI O LINK REAL ONDE ESTA A NOTÍCIA

	*/

	class VoceSabia {

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

	$class = new VoceSabia();

	$pagina = $class->acessLink("http://www.vocesabia.net/");

	$arrBox = $class->percorreCodigo($pagina, ' class="postbox">');

	foreach($arrBox as $blocoUn)	
	{

		// echo $blocoUn;
		// echo '<br /><br /><hr /><br /><br />';

		$link = $class->cortaCodigo($blocoUn, ' href="', '"');
		$titulo = strip_tags($class->cortaCodigo($blocoUn, '<h2>', '</h2>'));
		$author = $class->cortaCodigo($blocoUn, '<div class="post-date">', '</div>');
		$author = $class->cortaCodigo($author, '</a>', '</em>');


		$descricao = strip_tags($class->cortaCodigo($blocoUn, '<div class="post-exerpt">', '</div>'));
		// $data = implode("-", array_reverse(explode("/", ($class->cortaCodigo($blocoUn, '<div class="data">', '</div>')))));

		// echo $titulo;
		// echo '<br/>';
		// echo $descricao;
		// echo '<br/>';
		// echo $link;
		// echo '<br/>';
		// echo $data;
		// echo '<br/>';

		if(strlen($link) > 5 && 'http://www.vocesabia.net/wp-content/themes/bigfoot/style.css' != $link){
			
			$imagem = $class->cortaCodigo($blocoUn, '<img', '>');
			$imagem = $class->cortaCodigo($blocoUn, 'src="', '"');
			$imagem = str_replace('-600x150', '', $imagem);
			die();

			$paginaLinkProvisorio = $class->acessLink($link);

			$conteudo = $class->cortaCodigo($paginaLinkProvisorio, '<div id="divSpdInText" class="entry">', '<div class="tags">');

		}

	}

?>