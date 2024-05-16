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

    public function testAvaliadorDeveBuscarOs3MaioresValores(): void
    {
        $usuario1 = new Usuario("Eric");
        $usuario2 = new Usuario("Renan");
        $usuario3 = new Usuario("Rodrigo");
        $usuario4 = new Usuario("Douglas");

        $leilao = new Leilao("Supra 95 2JZ");
        $leilao->recebeLance(
            new Lance($usuario1, 20000)
        );
        $leilao->recebeLance(
            new Lance($usuario2, 5000)
        );
        $leilao->recebeLance(
            new Lance($usuario3, 15000)
        );
        $leilao->recebeLance(
            new Lance($usuario4, 1000)
        );

        $leiloeiro = new Avaliador();
        $leiloeiro->avaliar($leilao);

        $maioresLances = $leiloeiro->getMaioresLances();

        self::assertCount(3, $maioresLances);
        self::assertEquals(20000, $maioresLances[0]->getValor());
        self::assertEquals(15000, $maioresLances[1]->getValor());
        self::assertEquals(5000, $maioresLances[2]->getValor());
    }
}
