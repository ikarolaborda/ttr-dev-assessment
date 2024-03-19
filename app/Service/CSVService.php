<?php

namespace App\Service;

class CSVService
{
    public function readCSV($path): array
    {
        $data = [];
        if (($handle = fopen($path, 'r')) !== false) {
            while (($row = fgetcsv($handle, 0, ';')) !== false) {
                $data[] = $this->normalizeRow($row);
            }
            fclose($handle);
        }
        return $data;
    }

    public function findDifferences(array $data1, array $data2): array
    {
        /* Descobri que o DiffNow utiliza comparação binária, dessa forma, não é necessario converter em array associativo
        Os arrays abaixo foram "normalizados" para facilitar a comparação
         */
        $assocData1 = $data1;
        $assocData2 = $data2;

        $unchanged = [];
        $updated = [];
        $added = [];

        foreach ($assocData2 as $lineNumber2 => $row2) {
            $matchFound = false;
            foreach ($assocData1 as $lineNumber1 => $row1) {
                $similarity = $this->calculateRowSimilarity($row1, $row2);
                if ($similarity == 1) {
                    /* resultado exato, descartamos alterações */
                    $unchanged[] = $row2;
                    $matchFound = true;
                    break;
                } elseif ($similarity >= 0.9) {
                    /* resultado similar em 90%, consideramos como atualizado */
                    $updated[] = ['old' => $row1, 'new' => $row2];
                    $matchFound = true;
                    break;
                }
            }
            if (!$matchFound) {
                /* Linha não encontrada no primeiro arquivo, consideramos como nova */
                $added[] = $row2;
            }
        }

        return [
            'unchanged' => count($unchanged),
            'updated' => count($updated),
            'added' => count($added),
        ];
    }

    protected function normalizeRow(array $row): array
    {
        return array_map([$this, 'normalizeField'], $row);
    }

    protected function normalizeField($field): string
    {
        /* Precisamos de normalizar o campo para remover espacos em branco, uma vez que a comparação é binária */
        return trim($field);
    }

    protected function calculateRowSimilarity(array $row1, array $row2): float
    {

        /* Este algoritmo calcula similaridade inspirado nos K-vizinhos mais próximos */
        $totalFields = max(count($row1), count($row2));
        $matchingFields = 0;

        foreach ($row1 as $index => $value) {
            if (isset($row2[$index]) && $this->normalizeField($value) == $this->normalizeField($row2[$index])) {
                $matchingFields++;
            }
        }

        return $matchingFields / $totalFields;
    }
}
