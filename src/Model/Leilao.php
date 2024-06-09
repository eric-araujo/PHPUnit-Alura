<?php

namespace Alura\Leilao\Model;

class Leilao
{
    /** @var Lance[] */
    private array $lances;
    private string $descricao;
    private const LIMITE_DE_LANCES_POR_USUARIO = 5;

    public function __construct(string $descricao)
    {
        $this->descricao = $descricao;
        $this->lances = [];
    }

    public function recebeLance(Lance $lance): void
    {
        if (!empty($this->lances) && $this->verificarSeLanceEhDoUltimoUsuario($lance)) {
            return;
        }

        if ($this->retornarQuantidadeDeLancesDoUsuario($lance->getUsuario()) >= self::LIMITE_DE_LANCES_POR_USUARIO) {
            return;
        }

        $this->lances[] = $lance;
    }

    private function verificarSeLanceEhDoUltimoUsuario(Lance $lance): bool
    {
        $usuarioDoUltimoLance = $this->lances[array_key_last($this->lances)]->getUsuario();

        return $lance->getUsuario() == $usuarioDoUltimoLance;
    }

    private function retornarQuantidadeDeLancesDoUsuario(Usuario $usuario): int
    {
        return array_reduce(
            $this->lances,
            function ($totalAcumulado, Lance $lanceAtual) use ($usuario) {
                if ($lanceAtual->getUsuario() == $usuario) {
                    return $totalAcumulado + 1;
                }

                return $totalAcumulado;
            },
            0
        );
    }

    /**
     * @return Lance[]
     */
    public function getLances(): array
    {
        return $this->lances;
    }
}
