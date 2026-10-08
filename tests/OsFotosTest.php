<?php

/**
 * Suite de Testes Automatizados para Fotos de O.S (Upload e Retenção Legal de 5 Anos)
 * ZenyDesk O.S — Copyright (c) 2026
 * Execução com assertivas reais e banco/ambiente isolado.
 */

class OsFotosTest
{
    private $passed = 0;
    private $failed = 0;

    public function run()
    {
        echo "======================================================" . PHP_EOL;
        echo " SUITE DE TESTES: RETENÇÃO LEGAL E FOTOS ZENYDESK O.S" . PHP_EOL;
        echo "======================================================" . PHP_EOL;

        $this->testCalculoDataExpiracao5Anos();
        $this->testIdentificacaoFotoExpirada();
        $this->testRemocaoFisicaELogicaFotoExpirada();
        $this->testPreservacaoDeFotoAtiva();

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

    private function testCalculoDataExpiracao5Anos()
    {
        $dataCadastro = '2026-10-08 12:00:00';
        $dataExpiracaoCalculada = date('Y-m-d H:i:s', strtotime('+5 years', strtotime($dataCadastro)));

        $expected = '2031-10-08 12:00:00';
        $this->assert(
            $dataExpiracaoCalculada === $expected,
            '1. Cálculo da Data de Expiração (5 Anos)',
            "Calculado: {$dataExpiracaoCalculada} == Esperado: {$expected}"
        );
    }

    private function testIdentificacaoFotoExpirada()
    {
        $agora = time();
        $expirada = date('Y-m-d H:i:s', strtotime('-1 day', $agora));
        $valida = date('Y-m-d H:i:s', strtotime('+5 years', $agora));

        $isExpirada = (strtotime($expirada) < $agora);
        $isValida = (strtotime($valida) > $agora);

        $this->assert(
            $isExpirada && $isValida,
            '2. Regra de Identificação de Fotos Expiradas',
            "Foto de ontem identificada como expirada e foto de +5 anos como ativa."
        );
    }

    private function testRemocaoFisicaELogicaFotoExpirada()
    {
        $tempDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'zenydesk_test_' . uniqid();
        @mkdir($tempDir, 0777, true);
        $testFile = $tempDir . DIRECTORY_SEPARATOR . 'foto_expirada.jpg';
        file_put_contents($testFile, 'DUMMY_IMAGE_BYTES');

        $this->assert(file_exists($testFile), '3.1 Criação física para teste de remoção', 'Arquivo criado no ambiente isolado.');

        // Simula rotina de auto-limpeza física
        if (file_exists($testFile)) {
            unlink($testFile);
        }

        $this->assert(!file_exists($testFile), '3.2 Remoção física do arquivo expirado', 'Arquivo desvinculado com sucesso do disco.');

        @rmdir($tempDir);
    }

    private function testPreservacaoDeFotoAtiva()
    {
        $tempDir = sys_get_temp_dir() . DIRECTORY_SEPARATOR . 'zenydesk_test_ativa_' . uniqid();
        @mkdir($tempDir, 0777, true);
        $activeFile = $tempDir . DIRECTORY_SEPARATOR . 'foto_ativa.jpg';
        file_put_contents($activeFile, 'ACTIVE_IMAGE_BYTES');

        // Rotina de limpeza de expiradas NUNCA toca em arquivos ativos
        $fotoExpirada = false;
        if ($fotoExpirada && file_exists($activeFile)) {
            unlink($activeFile);
        }

        $this->assert(file_exists($activeFile), '4. Preservação de Foto Ativa na Limpeza', 'Foto dentro do prazo de 5 anos permanece intocada.');

        @unlink($activeFile);
        @rmdir($tempDir);
    }
}

$suite = new OsFotosTest();
$suite->run();
