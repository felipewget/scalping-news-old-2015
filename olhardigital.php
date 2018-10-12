<?php 

	// error_reporting(0);

	class OlharDigital {

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

	$class = new OlharDigital();

	$pagina = $class->acessLink('http://olhardigital.uol.com.br/area_logada/webservice.php?svc=pnlctr&cmt_ref=0&frm_ref=0');
	$arrJson = explode('"conteudos":', $pagina);
	$arrJson = (json_decode(str_replace('}]})', '}]', $arrJson[1])));

	foreach($arrJson as $conteiner){

		foreach($conteiner->lst as $obj){

			$absolute_path = 'http://olhardigital.uol.com.br/';

			$linkImagem = $absolute_path.($obj->img);
			$data = ($obj->pub);
			$titulo = ($obj->tit);
			$descricao = ($obj->txt);
			$link = $absolute_path.($obj->lnk);
			$idNoticiaNoPortal = ($obj->cid);		


			// echo $linkImagem;
			// echo '<br /><hr />';
			// echo $data;
			// echo '<br /><hr />';
			// echo $titulo;
			// echo '<br /><hr />';
			// echo $descricao;
			// echo '<br /><hr />';
			// echo $link;
			// echo '<br /><hr />';
			// echo $idNoticiaNoPortal;
			// echo '<br /><hr />';

			$paginaLinkProvisorio = $class->acessLink($link);

			// echo $paginaLinkProvisorio;

			$conteudo = $class->cortaCodigo($paginaLinkProvisorio, '<div class="texto">', '<div class="link-forum">');

			$conteudo = '<div class="texto">'.$conteudo;

		}

	}
	die();

?>