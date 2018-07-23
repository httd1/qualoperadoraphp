<?php

/**
*
** Consulta o número de telefone (fixo e celular) e retorna informações sobre a operadora, portabilidade,código de área e tipo de número.
*
** Classe em uso no bot @qualoperadorarobot do Telegram.
** @author [JM](https://t.me/httd1)
*
**/

class QualOperadora {
	
	function __construct ($num){
		
		$this->numero=$this->parseNum ($num);
		
		}
		
		/**
		*
		** Retorna o número passado como parâmetro ao instanciar a classe.
		*
		**/
		
	function Numero (){
		
$num=$this->numero;

		return $num;
		
		}
		
	/**
	*
	** Informa se este número foi portado, true para sim e false para não portado.
	*
	**/
	
	function Portabilidade (){
		
$portabilidade=$this->serializeAPI ();

	if ($portabilidade ['portabilidade'] == 1){
		return true;
		}
		
		return false;
		
		}
		
	/**
	*
	** Retorna a operadora do número ou false se a operadora não for identificada.
	*
	**/
	
	function Operadora (){
		
$num=$this->numero;
$operadoras=$this->dados_api ()->dados->operadoras;
$infoNumero=$this->serializeAPI ();

		foreach ($operadoras as $infoOP){
			
			if ($infoOP->codigo == $infoNumero ['info_num']){
				return $infoOP->operadora;
				}
			
			}
		
				return false;
		}
		
	/**
	*
	** Informa o tipo do número ou false se o tipo de número não for identificado.
	*
	**/
	
	function TipoNumero (){
		
$infoNumero=$this->serializeAPI ();
$tipo_num_atual=substr ($infoNumero ['info_num'],0,3);
$tipos=$this->dados_api ()->dados->tipos_numeros;

	foreach ($tipos as $tipo){
		
		if ($tipo->codigo == $tipo_num_atual){
			return $tipo->descricao;
			}
		
		}
		
		return false;
		
		}
		
		/**
		*
		** Retorna o número passado como parâmetro na instância da classe organizado no formato correto.
		*
		**/
		
		function parseNum ($numero){

$num=str_replace (array (' ','-','_','(',')','+','.'),'', $numero);

	if ($num [0].$num [1] == '55'){
	$num=substr ($num,2);
		}

	if ($num [0] == '0'){
	$num=substr ($num,1);
		}

		return $num;

	}
	
	/**
	*
	** Retorna um array com informações sobre o DDD do número ou false se o DDD não for identificado.
	*
	**/
	
		function DDD (){

$num=$this->numero;
$ddds=$this->dados_api ()->dados->lista_ddds;
$ddd=substr ($num,0,2);

		foreach ($ddds as $dddJson){

			if ($dddJson->ddd == $ddd){
			return ['ddd' => $ddd, 'regiao' => $dddJson->local];
			}

		}
		
		return false;

	}
		
		/**
		**
		** Retorna o tipo de erro.
		** Pode ser usado para identificar o tipo de erro quando algum método retornar false.
		**
		**/
		
		function erros (){
			
$erros=$this->dados_api ()->dados->codigos_erros;
$infoNumero=$this->serializeAPI ();

		foreach ($erros as $erro){
			
			if ($erro->codigo == $infoNumero ['info_num']){
				return $erro->descricao;
				}
			
			}
			
			return false;
			
			}
			
	function dados_api (){
		
$getDADOSAPI=json_decode (file_get_contents ('CodesAPI.json'));
	
		return $getDADOSAPI;
	}
	
	function serializeAPI (){
		
@list ($portabilidade, $info_num, $numero)=explode ('#', $this->getAPI ());

		return array ('portabilidade' => $portabilidade, 'info_num' => $info_num, 'numero' => $numero);
		
		}

		function getAPI (){
			
$num=$this->numero;
			
$curL=curl_init ('https://mobile.telein.com.br/mobile/consulta.php?id=AND354490060063869&login=appmobile&hash=29d42de4af02e464002bc3b21c0ae1ad510c63fb&numero='.$num.'&check');
			
			curl_setopt ($curL, CURLOPT_RETURNTRANSFER,1);
			curl_setopt ($curL, CURLOPT_SSL_VERIFYPEER,0);
			
$retorno=curl_exec ($curL);
			curl_close ($curL);
			
			return $retorno;
			}
	}