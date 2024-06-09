<?php

namespace Alura\Leilao\Tests\Model;

use Alura\Leilao\Model\Lance;
use Alura\Leilao\Model\Leilao;
use Alura\Leilao\Model\Usuario;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\TestCase;

class LeilaoTest extends TestCase
{
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
