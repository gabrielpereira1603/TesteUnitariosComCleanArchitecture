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
        $this->lances[] = $lance;
    }
    
    public function getLances(): array
    {
        return $this->lances;
    }

    private function LancePertenceAoUltimoUsuario(Lance $lance): bool
    {
        $ultimoLance = $this->lances[count($this->lances) - 1];
        return $lance->getUsuario() === $ultimoLance->getUsuario();
    }
}
