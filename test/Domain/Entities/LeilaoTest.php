<?php

namespace Domain\Entities;

use Alura\Leilao\Domain\Entities\Lance;
use Alura\Leilao\Domain\Entities\Leilao;
use Alura\Leilao\Domain\Entities\Usuario;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{
    public function testLeilaoNaoDeveReceberLancesRepetidos()
    {
        $leilao = new Leilao('Ferrari Spider');
        $joao = new Usuario('Joao Caetano');

        $leilao->recebeLance(new Lance($joao,1000));
        $leilao->recebeLance(new Lance($joao, 1500));

        static::assertCount(1, $leilao->getLances());
        static::assertEquals(1000, $leilao->getLances() [0]->getValor());
    }

    /**
     * @dataProvider geraLances
     */
    public function testLeilaoDeveReceberLances(int $quantidadeLances, Leilao $leilao, array $valores)
    {
        static ::assertCount($quantidadeLances, $leilao->getLances());

        foreach ($valores as $indiceValores => $valorEsperado) {
            static::assertEquals($valorEsperado, $leilao->getLances() [$indiceValores]->getValor());
        }
    }

    public function geraLances()
    {
        $joao = new Usuario('Joao');
        $maria = new Usuario('Maria');

        $leilaoCom2Lances = new Leilao('Gol g5');
        $leilaoCom2Lances->recebeLance(new Lance($joao, 1000));
        $leilaoCom2Lances->recebeLance(new Lance($maria, 2000));

        $leilaoCom1Lances = new Leilao('Gol 2020 0km');
        $leilaoCom1Lances->recebeLance(new Lance($maria, 5000));

        return [
            [2, $leilaoCom2Lances, [1000, 2000]],
            [1, $leilaoCom1Lances, [5000]]
        ];
    }
}