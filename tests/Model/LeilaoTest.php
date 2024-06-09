<?php

namespace Alura\Leilao\Tests\Model;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{
    public function testLeilaoNaoDeveAceitarMaisDe5LancesPorUsuario(): void
    {
        $usuario1 = new Usuario('Danilo');
        $usuario2 = new Usuario('Daniel');

        $leilao = new Leilao("Maverick V8 76");

        $leilao->recebeLance(new Lance($usuario1, 1000));
        $leilao->recebeLance(new Lance($usuario2, 1500));
        $leilao->recebeLance(new Lance($usuario1, 2000));
        $leilao->recebeLance(new Lance($usuario2, 2500));
        $leilao->recebeLance(new Lance($usuario1, 3000));
        $leilao->recebeLance(new Lance($usuario2, 3500));
        $leilao->recebeLance(new Lance($usuario1, 4000));
        $leilao->recebeLance(new Lance($usuario2, 4500));
        $leilao->recebeLance(new Lance($usuario1, 5000));
        $leilao->recebeLance(new Lance($usuario2, 5500));

        $leilao->recebeLance(new Lance($usuario1, 6000));
        $leilao->recebeLance(new Lance($usuario2, 6500));

        static::assertCount(10, $leilao->getLances());
        static::assertEquals(5500, $leilao->getLances()[array_key_last($leilao->getLances())]->getValor());
    }

    public function testLeilaoNaoDeveReceberLancesRepetidos(): void
    {
        $usuario = new Usuario('Eric');

        $leilao = new Leilao('Fusca 77');
        $leilao->recebeLance(new Lance($usuario, 1000));
        $leilao->recebeLance(new Lance($usuario, 2000));

        static::assertCount(1, $leilao->getLances());
        static::assertEquals(1000, $leilao->getLances()[0]->getValor());
    }

    #[DataProvider('retornar2Lances')]
    #[DataProvider('retornar1Lance')]
    public function testLeilaoDeveReceberLances(
        int $quantidadeDeLances,
        Leilao $leilao,
        array $valores
    ): void {
        static::assertCount($quantidadeDeLances, $leilao->getLances());

        foreach ($valores as $indice => $valor) {
            $valorLanceLeilao = $leilao->getLances()[$indice]->getValor();
            static::assertEquals($valor, $valorLanceLeilao);
        }
    }

    public static function retornar2Lances(): array
    {
        $leilao = new Leilao('Supra 95 2JZ');
        $leilao->recebeLance(
            new Lance(
                new Usuario('Eric'),
                1000
            )
        );
        $leilao->recebeLance(
            new Lance(
                new Usuario('Renan'),
                2000
            )
        );

        return [
            '2-lances' => [2, $leilao, [1000, 2000]]
        ];
    }

    public static function retornar1Lance(): array
    {
        $leilao = new Leilao('Supra 95 2JZ');
        $leilao->recebeLance(
            new Lance(
                new Usuario('Eric'),
                5000
            )
        );

        return [
            '1-lance' => [1, $leilao, [5000]]
        ];
    }
}
