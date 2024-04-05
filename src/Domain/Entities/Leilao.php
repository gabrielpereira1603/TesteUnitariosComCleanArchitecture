<?php

namespace Alura\Leilao\Domain\Entities;

class Leilao
{
    private array $lances;
    private string $descricao;

    public function __construct(string $descricao)
    {
        $this->descricao = $descricao;
        $this->lances = [];
    }

    public function recebeLance(Lance $lance)
    {
        if (!empty($this->lances) && $this->LancePertenceAoUltimoUsuario($lance)) {
            return;
        }

        $totalLancesUsuario = $this->quantidadeLancesPorUsuario($lance->getUsuario());

        if ($totalLancesUsuario >= 5){
            return;
        }
        $this->lances[] = $lance;
    }

    public function getLances(): array
    {
        return $this->lances;
    }

    private function LancePertenceAoUltimoUsuario(Lance $lance): bool
    {
        $ultimoLance = $this->lances[array_key_last($this->lances)];
        return $lance->getUsuario() === $ultimoLance->getUsuario();
    }

    private function quantidadeLancesPorUsuario(Usuario $usuario): int
    {
        $totalLancesUsuario = array_reduce($this->lances,
            function (int $totalLancesAcumaldos, Lance $lanceAtual) use ($usuario) {
                if($lanceAtual->getUsuario() == $usuario) {
                    return $totalLancesAcumaldos + 1;
                }

                return $totalLancesAcumaldos;
            },
            0
        );
        return $totalLancesUsuario;
    }
}
