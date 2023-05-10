<?php

declare(strict_types=1);

class BankAccount
{
    protected string $banknummer;
    protected float $saldo;

    public function __construct(string $banknummer, float $saldo = 0.0)
    {
        $this->banknummer = $banknummer;
        $this->saldo = $saldo;
    }

    public function getSaldo(): float
    {
        return $this->saldo;
    }

    protected function setSaldo(float $saldo): void
    {
        $this->saldo = $saldo;
    }

    public function toevoegen(float $bedrag): void
    {
        $this->setSaldo($this->getSaldo() + $bedrag);
    }

    public function onttrekken(float $bedrag): void
    {
        if ($this->getSaldo() >= $bedrag) {
            $this->setSaldo($this->getSaldo() - $bedrag);
        } else {
            echo "Onttrekking niet toegestaan. Saldo is te laag." . PHP_EOL;
        }
    }
}

class BankAccountPlus extends BankAccount
{
    private float $boeterente;

    public function __construct(string $banknummer, float $boeterente, float $saldo = 0.0)
    {
        parent::__construct($banknummer, $saldo);
        $this->boeterente = $boeterente;
    }

    private function calculateBoeteBedrag(float $bedrag): float
    {
        return $bedrag * $this->boeterente;
    }

    public function toevoegen(float $bedrag): void
    {
        parent::toevoegen($bedrag);
        $boeteBedrag = $this->calculateBoeteBedrag($bedrag);
        echo "Boetebedrag: $boeteBedrag" . PHP_EOL;
    }

    public function onttrekken(float $bedrag): void
    {
        if ($bedrag <= $this->getSaldo()) {
            parent::onttrekken($bedrag);
            $boeteBedrag = $this->calculateBoeteBedrag($bedrag);
            echo "Boetebedrag: $boeteBedrag" . PHP_EOL;
        } else {
            $tekort = $bedrag - $this->getSaldo();
            $boeteBedrag = $this->calculateBoeteBedrag($tekort);
            echo "Onttrekking niet toegestaan. Saldo is te laag. Boetebedrag: $boeteBedrag" . PHP_EOL;
        }
    }
}

// Voorbeeldgebruik
$bankAccount = new BankAccount('NL01BANK0123456789', 100.0);
echo 'Saldo voor toevoegen: ' . $bankAccount->getSaldo() . PHP_EOL;
$bankAccount->toevoegen(50.0);
echo 'Saldo na toevoegen: ' . $bankAccount->getSaldo() . PHP_EOL;
$bankAccount->onttrekken(30.0);
echo 'Saldo na onttrekken: ' . $bankAccount->getSaldo() . PHP_EOL;

echo PHP_EOL;

$bankAccountPlus = new BankAccountPlus('NL02BANK9876543210', 0.05, 100.0);
echo 'Saldo voor toe';
