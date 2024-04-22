<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{
    public function testMaiorValorLanceEmOrdemCrescente(): void
    {
        // Arrange - Given
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao = new Usuario('João');

        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));

        $leiloeiro = new Avaliador();

        // Act - When
        $leiloeiro->avaliar($leilao);

        $maiorValor = $leiloeiro->getMaiorValor();

        self::assertEquals(
            expected: 2500,
            actual: $maiorValor
        );
    }

    public function testMaiorValorLanceEmOrdemDecrescente(): void
    {
        // Arrange - Given
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao = new Usuario('João');

        $leilao->recebeLance(new Lance($maria, 2500));
        $leilao->recebeLance(new Lance($joao, 2000));

        $leiloeiro = new Avaliador();

        // Act - When
        $leiloeiro->avaliar($leilao);

        $maiorValor = $leiloeiro->getMaiorValor();

        self::assertEquals(
            expected: 2500,
            actual: $maiorValor
        );
    }

    public function testMenorValorEmLance(): void
    {
        // Arrange - Given
        $leilao = new Leilao('Fiat 147 0KM');

        $maria = new Usuario('Maria');
        $joao = new Usuario('João');

        $leilao->recebeLance(new Lance($joao, 2000));
        $leilao->recebeLance(new Lance($maria, 2500));

        $leiloeiro = new Avaliador();

        // Act - When
        $leiloeiro->avaliar($leilao);

        $menorValor = $leiloeiro->getMenorValor();

        self::assertEquals(
            expected: 2000,
            actual: $menorValor
        );
    }
}
