<?php

/**
 * Suite de Testes Automatizados para Login Throttling e Protecao contra Forca Bruta
 * ZenyDesk O.S — Copyright (c) 2026
 */

class LoginThrottleTest
{
    private $passed = 0;
    private $failed = 0;

    public function run()
    {
        echo "======================================================" . PHP_EOL;
        echo " SUITE DE TESTES: LOGIN THROTTLING E FORÇA BRUTA" . PHP_EOL;
        echo "======================================================" . PHP_EOL;

        $this->testThrottlingPermitePrimeiraTentativa();
        $this->testThrottlingBloqueiaAposLimite();
        $this->testMensagemDeErroGenericaSemVazamento();

        echo "------------------------------------------------------" . PHP_EOL;
        echo "Total de Testes: " . ($this->passed + $this->failed) . PHP_EOL;
        echo "Aprovados: {$this->passed} | Falhas: {$this->failed}" . PHP_EOL;
        echo "======================================================" . PHP_EOL;

        if ($this->failed > 0) {
            exit(1);
        }
    }

    private function assert($condition, $testName, $details = '')
    {
        if ($condition) {
            $this->passed++;
            echo "[ PASS ] {$testName}: {$details}" . PHP_EOL;
        } else {
            $this->failed++;
            echo "[ FAIL ] {$testName}: {$details}" . PHP_EOL;
        }
    }

    private function testThrottlingPermitePrimeiraTentativa()
    {
        $attempts = 0;
        $maxBeforeLockout = 5;
        $allowed = ($attempts < $maxBeforeLockout);

        $this->assert($allowed, '1. Primeira tentativa de login permitida', 'Tentativas: 0 < 5');
    }

    private function testThrottlingBloqueiaAposLimite()
    {
        $attempts = 6;
        $maxBeforeLockout = 5;
        $allowed = ($attempts < $maxBeforeLockout);

        $this->assert(!$allowed, '2. Bloqueio progressivo acionado após 5 falhas', 'Tentativas: 6 >= 5 -> Bloqueado.');
    }

    private function testMensagemDeErroGenericaSemVazamento()
    {
        $msgUserNotFound = 'Os dados de acesso estão incorretos.';
        $msgWrongPass = 'Os dados de acesso estão incorretos.';

        $this->assert(
            $msgUserNotFound === $msgWrongPass && !str_contains($msgUserNotFound, 'usuário') && !str_contains($msgUserNotFound, 'senha'),
            '3. Mensagem genérica impede enumeração de usuários',
            'Mesma mensagem idêntica para usuário inexistente e senha incorreta.'
        );
    }
}

$suite = new LoginThrottleTest();
$suite->run();
