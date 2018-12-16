<?php

/**
 * Redéfini la gestion des erreurs
 *
 * @param $errno
 * @param $errstr
 * @param $errfile
 * @param $errline
 *
 * @return bool|void
 */
function errorHandler( $errno, $errstr, $errfile, $errline ) {
    if ( !( error_reporting() & $errno ) ) {
        // Ce code d'erreur n'est pas inclus dans error_reporting()
        return;
    }

    // Insertion des logs
    \CAUProject3Contact\Model\Logs::insert( $errno, $errstr, $errfile, $errline, date( 'Y-m-d H:i:s' ) );

    ob_clean();
    new \CAUProject3Contact\Controller\Site\SiteError( 500 );

    /* Ne pas exécuter le gestionnaire interne de PHP */

    return;
}
