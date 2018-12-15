<?php

namespace WebProjectFitness\Model;

class Model {

    /**
     * Crée une reqette d'insertion en base àpartir du nom de la table et d'un tableau associatif et l'exécute
     *
     * @param string $tableName
     * @param array $data
     *
     * @return int lastInsertId
     */
    public static function insert( string $tableName, array $data ) {
        $req = BDD::instance()->prepare( 'INSERT INTO ' . $tableName . ' (' . implode( ', ', array_keys( $data ) ) . ') 
                                         VALUES (' . ':' . implode( ', :', array_keys( $data ) ) . ')' );
        $req->execute( $data );

        return BDD::lastInsertId();
    }

    /**
     * Met à jour les données d'une ligne d'un table données
     *
     * @param string $tableName
     * @param array $data
     * @param string $idColumn
     * @param int $idValue
     */
    public static function update( string $tableName, array $data, string $idColumn, string $idValue ) {
        $reqStr = 'UPDATE ' . $tableName . ' SET ';
        $lastKey = endKey( $data );
        foreach ( $data as $key => $value ) {
            $reqStr .= $key . ' = :' . $key;
            if ( $key != $lastKey ) {
                $reqStr .= ', ';
            }
        }
        $reqStr .= ' WHERE ' . $idColumn . ' = :' . $idColumn;
        $data[ $idColumn ] = $idValue;

        //echo $reqStr; exit();

        $req = BDD::instance()->prepare( $reqStr );
        $req->execute( $data );
    }

    public static function delete( string $tableName, array $data ) {
        $reqStr = 'DELETE FROM ' . $tableName . ' WHERE ';
        $lastKey = endKey( $data );
        foreach ( $data as $key => $value ) {
            $reqStr .= $key . ' = :' . $key;
            if ( $key != $lastKey ) {
                $reqStr .= ' AND ';
            }
        }

        //echo $reqStr; exit();

        $req = BDD::instance()->prepare( $reqStr );
        $req->execute( $data );

    }

    public static function update_order( string $tableName, array $data, string $newOrder ) {
        $reqStr = 'UPDATE ' . $tableName . ' SET id_order = :newOrder WHERE ';
        $lastKey = endKey( $data );
        foreach ( $data as $key => $value ) {
            $reqStr .= $key . ' = :' . $key;
            if ( $key != $lastKey ) {
                $reqStr .= ' AND ';
            }
        }
        $data[ 'newOrder' ] = $newOrder;

        //echo $reqStr; exit();

        $req = BDD::instance()->prepare( $reqStr );
        $req->execute( $data );
    }
}

?>