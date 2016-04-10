<?php

namespace Estrutura\Helpers;

/**
 *
 * @author anonymous
 *
 */
class Pagination {

    /**
     * Converte array multidimencional $_FILE por atributos (tmp_name, size...)
     * em um array multidimencional por arquivo
     * @param unknown_type $files
     * @return array
     */
    public static function getCountPerPage($totalItemCount) {

        $values = [];
        if ($totalItemCount > 400) {

            $value = $totalItemCount;
            $values[] = $totalItemCount;
            
            for ($index = 0; $index < 3; $index++) {
                $value = (int) ((($value % 2) == 0 ? $value : $value + 1 ) / 2);
                $values[] = $value;
            }
        } else {
            $values = [400, 300, 200, 100, 50, 25, 10] ;
        }
        return array_reverse($values);
    }

}
