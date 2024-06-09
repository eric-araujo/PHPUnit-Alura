<?php

namespace Alura\Leilao\Model;

class Leilao
{
    /** @var Lance[] */
    private array $lances;
    private string $descricao;
    private bool $finalizado;
    private const LIMITE_DE_LANCES_POR_USUARIO = 5;

    public function __construct(string $descricao)
    {
        $this->descricao = $descricao;
        $this->lances = [];
        $this->finalizado = false;
    }

    public function recebeLance(Lance $lance): void
    {
        if (!empty($this->lances) && $this->verificarSeLanceEhDoUltimoUsuario($lance)) {
            throw new \DomainException("Usuário não pode propor 2 lances seguidos");
        }

        if ($this->retornarQuantidadeDeLancesDoUsuario($lance->getUsuario()) >= self::LIMITE_DE_LANCES_POR_USUARIO) {
            throw new \DomainException("Usuário não pode fazer mais do que 5 lances no leilão");
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

    public function finalizar(): void
    {
        $this->finalizado = true;
    }

    public function verificarSeLeilaoEstaFinalizado(): bool
    {
        return $this->finalizado;
    }
}
