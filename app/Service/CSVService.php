<?php

namespace App\Service;

class CSVService
{
    public function readCSV($path): array
    {
        $data = [];
        if (($handle = fopen($path, 'r')) !== false) {
            while (($row = fgetcsv($handle, 0, ';')) !== false) {
                $data[] = $row;
            }
            fclose($handle);
        }
        return $data;
    }


    public function findDifferences(array $data1, array $data2): array
    {
        // Convert to associative arrays for comparison
        $assocData1 = $this->toAssocArray($data1);
        $assocData2 = $this->toAssocArray($data2);

        $unchanged = [];
        $updated = [];
        $added = [];

        foreach ($assocData2 as $id => $row) {
            if (isset($assocData1[$id])) {
                if ($row === $assocData1[$id]) {
                    $unchanged[$id] = $row;
                } else {
                    $updated[$id] = ['before' => $assocData1[$id], 'after' => $row];
                }
            } else {
                $added[$id] = $row;
            }
        }

        return [
            'unchanged' => $unchanged,
            'updated' => $updated,
            'added' => $added,
        ];
    }

    protected function toAssocArray(array $data): array
    {
        $assocArray = [];
        foreach ($data as $index => $row) {
            if ($index === 0) continue; // Skip headers
            $assocArray[$row[0]] = $row; // Use the first column (e.g., cnpj) as the key
        }
        return $assocArray;
    }




}
