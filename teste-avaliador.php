<?php

use Alura\Leilao\Domain\Entities\Lance;
use Alura\Leilao\Domain\Entities\Leilao;
use Alura\Leilao\Domain\Entities\Usuario;
use Alura\Leilao\Infra\Service\Avaliador;

require  'vendor/autoload.php';

$leilao = new Leilao('Honda Biz-125cl 0km');

$maria = new Usuario('Maria Alves');
$joao = new Usuario('Joao Alves');

$leilao->recebeLance(new Lance($joao, 2000));
$leilao->recebeLance(new Lance($maria, 2500));

$leiloeiro = new Avaliador();
$leiloeiro->avalia($leilao);

$maiorValor = $leiloeiro->getMaiorValor();

echo $maiorValor;