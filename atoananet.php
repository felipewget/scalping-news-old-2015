<?php 

	error_reporting(0);

	//http://www.atoananet.com.br/blog/portal-curiosidades

	/*

		MACRO LISTA AS PRINCIPAIS NOTICIAS NA QUAL ME DA UM LINK PROVCISÓRIO, ACESSAREI O LINK PROVISÓRIO E PEGAREI O LINK REAL ONDE ESTA A NOTÍCIA

	*/

	class Atoananet {

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

	$class = new Atoananet();

	$pagina = $class->acessLink("http://www.atoananet.com.br/blog/portal-curiosidades");
	$arrBox = $class->percorreCodigo($pagina, '<div class="box-link">');

	foreach($arrBox as $blocoUn)	
	{

		$link = $class->cortaCodigo($blocoUn, '<a href="', '"');
		$titulo = strip_tags($class->cortaCodigo($blocoUn, '<div class="titulo">', '</div>'));
		$descricao = strip_tags($class->cortaCodigo($blocoUn, '<div class="descricao">', '</div>'));
		$data = implode("-", array_reverse(explode("/", ($class->cortaCodigo($blocoUn, '<div class="data">', '</div>')))));

		// echo $titulo;
		// echo '<br/>';
		// echo $descricao;
		// echo '<br/>';
		// echo $link;
		// echo '<br/>';
		// echo $data;
		// echo '<br/>';

		//http://www.atoananet.com.br/permalink/240662/no-japao-dente-humano-e-achado-nas-batatas-fritas-do-mcdonalds.htm
		/// ELe acessa aki \/
		//http://portalcuriosidades.com/no-japao-dente-humano-e-achado-nas-batatas-fritas-do-mcdonalds/
		//http://portalcuriosidades.com/no-japao-dente-humano-e-achado-nas-batatas-fritas-do-mcdonalds.htm

		if(strlen($link) > 5 && 'http://www.atoananet.com.br' != $link){

			
			$paginaLinkProvisorio = $class->acessLink($link);
			$blocoImg = $class->cortaCodigo($paginaLinkProvisorio, '<div class="imagem">', '</div>');
			$linkImagem = $class->cortaCodigo($paginaLinkProvisorio, '<img src="', '"');

			$linkNoticia = $class->cortaCodigo($paginaLinkProvisorio, '<meta property="og:url" content="', '"');

			$arrLinkNoticia = array_reverse(explode('/', $linkNoticia));
			$linkNoticia = $arrLinkNoticia[0];

			$linkNoticia = substr($linkNoticia, 0, (strlen($linkNoticia) - 4));

			$linkNoticia = 'http://portalcuriosidades.com/'.$linkNoticia;

			echo '<br /><br />'.$linkNoticia.'<br /><br />';

			echo $class->acessLink($linkNoticia);
			
			echo '<br /><br /><hr /><br /><br />';

		}

	}

?>