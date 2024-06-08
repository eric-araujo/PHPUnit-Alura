<?php

namespace Alura\Leilao\Tests\Service;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use Alura\Leilao\Service\Avaliador;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class AvaliadorTest extends TestCase
{
    private Avaliador $leiloeiro;

    protected function setUp(): void
    {
        $this->leiloeiro = new Avaliador();
    }

    #[DataProvider('leilaoEmOrdemCrescente')]
    #[DataProvider('leilaoEmOrdemDecrescente')]
    #[DataProvider('leilaoEmOrdemAleatoria')]
    public function testMaiorValorEmLances(Leilao $leilao): void
    {
        $this->leiloeiro->avaliar($leilao);

        self::assertEquals(
            expected: 20000,
            actual: $this->leiloeiro->getMaiorValor()
        );
    }

    #[DataProvider('leilaoEmOrdemCrescente')]
    #[DataProvider('leilaoEmOrdemDecrescente')]
    #[DataProvider('leilaoEmOrdemAleatoria')]
    public function testMenorValorEmLances(Leilao $leilao): void
    {
        $this->leiloeiro->avaliar($leilao);

        self::assertEquals(
            expected: 1000,
            actual: $this->leiloeiro->getMenorValor()
        );
    }

    #[DataProvider('leilaoEmOrdemCrescente')]
    #[DataProvider('leilaoEmOrdemDecrescente')]
    #[DataProvider('leilaoEmOrdemAleatoria')]
    public function testAvaliadorDeveBuscarOs3MaioresValores(Leilao $leilao): void
    {
        $this->leiloeiro->avaliar($leilao);

        $maioresLances = $this->leiloeiro->get3MaioresLances();

        self::assertCount(3, $maioresLances);
        self::assertEquals(20000, $maioresLances[0]->getValor());
        self::assertEquals(15000, $maioresLances[1]->getValor());
        self::assertEquals(5000, $maioresLances[2]->getValor());
    }

    public static function leilaoEmOrdemCrescente(): array
    {
        $leilao = new Leilao("Supra 95 2JZ");

        $usuario1 = new Usuario("Eric");
        $usuario2 = new Usuario("Renan");
        $usuario3 = new Usuario("Rodrigo");
        $usuario4 = new Usuario("Douglas");

        $leilao->recebeLance(new Lance($usuario4, 1000));
        $leilao->recebeLance(new Lance($usuario2, 5000));
        $leilao->recebeLance(new Lance($usuario3, 15000));
        $leilao->recebeLance(new Lance($usuario1, 20000));

        return ["ordem-crescente" => [$leilao]];
    }

    public static function leilaoEmOrdemDecrescente(): array
    {
        $leilao = new Leilao("Supra 95 2JZ");

        $usuario1 = new Usuario("Eric");
        $usuario2 = new Usuario("Renan");
        $usuario3 = new Usuario("Rodrigo");
        $usuario4 = new Usuario("Douglas");

        $leilao->recebeLance(new Lance($usuario1, 20000));
        $leilao->recebeLance(new Lance($usuario3, 15000));
        $leilao->recebeLance(new Lance($usuario2, 5000));
        $leilao->recebeLance(new Lance($usuario4, 1000));

        return ["ordem-decrescente" => [$leilao]];
    }

    public static function leilaoEmOrdemAleatoria(): array
    {
        $leilao = new Leilao("Supra 95 2JZ");

        $usuario1 = new Usuario("Eric");
        $usuario2 = new Usuario("Renan");
        $usuario3 = new Usuario("Rodrigo");
        $usuario4 = new Usuario("Douglas");

        $leilao->recebeLance(new Lance($usuario1, 20000));
        $leilao->recebeLance(new Lance($usuario2, 5000));
        $leilao->recebeLance(new Lance($usuario3, 15000));
        $leilao->recebeLance(new Lance($usuario4, 1000));

        return ["ordem-aleatoria" => [$leilao]];
    }
}
