# QualOperadoraPHP

Esta classe obtém informações sobre números de telefone Fixo ou Celular.

## Uso

Incluindo a classe.

```php
include 'QualOperadora.php';
```
Instanciando a classe e passando o número como parâmetro.

```php
$qp=new QualOperadora ('(81) 3454.2323');

if ($qp->erros ()){

echo 'Erro: '.$qp->erros ();

}else {

$portado=($qp->Portabilidade ()) ? 'Sim' : 'Não';

$ddd=$qp->DDD ();

echo 'Número: '.$qp->Numero ();
echo '<br>';
echo 'Operadora: '.$qp->Operadora ();
echo '<br>';
echo 'DDD: '.$ddd ['ddd'].' - '.$ddd ['regiao'];
echo '<br>';
echo 'Tipo: '.$qp->TipoNumero ();
echo '<br>';
echo 'Portabilidade: '.$portado;
echo '<br>';

}
```

## Métodos da classe.

* `Numero ()` - Retorna o número passado como parâmetro ao instanciar a classe.
* `Operadora ()` - Retorna a operadora do número.
* `Portabilidade ()` - Informa se o número foi portado.
* `DDD ()` - Retorna um array com informações sobre o ddd do número.
* `TipoNumero ()` - Retorna o tipo do número.
* `erros ()` - Descreve o último erro da API.
