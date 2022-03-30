<?php
    /**
     * Xander Bass Website Content Management Framework (XBWeb CMF)
     *
     * @author       Xander Bass
     * @copyright    Xander Bass
     * @license      https://opensource.org/licenses/mit-license.php MIT License
     * @link         https://xbweb.org
     *
     * @description  Main CMS file
     * @category     End product solutions
     * @link         https://xbweb.org/doc/dist/cms
     */

    /** LOADING CMF **/
    namespace xbweb {
        /** Paths */
        define(__NAMESPACE__ . '\\Paths\\WEBROOT', strtr(dirname(__FILE__), '\\', '/') . '/');
        if (file_exists(Paths\WEBROOT.'paths.php')) require Paths\WEBROOT.'paths.php';
        defined(__NAMESPACE__ . '\\Paths\\ROOT')   or define(__NAMESPACE__ . '\\Paths\\ROOT', Paths\WEBROOT);
        defined(__NAMESPACE__ . '\\Folders\\CORE') or define(__NAMESPACE__ . '\\Folders\\CORE', 'xbweb');
        defined(__NAMESPACE__ . '\\Paths\\CORE')   or define(__NAMESPACE__ . '\\Paths\\CORE', Paths\ROOT . (Folders\CORE) . '/');

        /** Other constants */
        define(__NAMESPACE__ . '\\INSTALLED', file_exists(Paths\WEBROOT . 'config.php'));

        /** Loading bootstrap */
        require Paths\CORE . 'classes/debug.php';
        require Paths\CORE . 'loader.php';

        /** Loading CONFIG if installed */
        if (INSTALLED) require Paths\WEBROOT . 'config.php';

        /** Loading second libraries */
        require Paths\LIB . 'roles.php';
        require Paths\LIB . 'content.php';

        /** Loading entities libraries */
        require Paths\CLASSES . 'entities/users.php';

        /** Loading primary entities */
        require Paths\CLASSES . 'session.php';
        require Paths\CLASSES . 'user.php';
        require Paths\CLASSES . 'acl.php';

        /** Loading basic prototypes */
        require Paths\CLASSES . 'controller.php';

        /** Loading CMF */
        require Paths\CLASSES . 'cmf.php';
        Debug::p('Core loaded');
        require Paths\CORE . 'service.php';
    }

    /** PROCESS ACTION **/
    namespace xbweb {
        /** Execute action */
        try {
            CMF::get();
            $response = CMF::execute();
            $response['error_page'] = false;
            if (empty($response['status']))   $response['status']   = 'success';
            if (empty($response['HTTPCode'])) $response['HTTPCode'] = 200;
        } catch (\Exception $e) {
            $response = Error::getResponse($e);
            $response['error_page'] = true;
            if (empty($response['status']))   $response['status']   = 'error';
            if (empty($response['HTTPCode'])) $response['HTTPCode'] = 500;
        }

        Debug::p('Action executed');

        /** Define content headers **/
        $contentCharset = Config::get('charset', 'utf-8');
        $contentType    = 'text/html';
        switch (Request::get('contentType')) {
            case 'json': $contentType = 'application/json'; break;
            case 'txt' : $contentType = 'text/plain'; break;
            case 'xml' : $contentType = 'text/xml'; break;
        }

        /** Send headers **/
        header($_SERVER['SERVER_PROTOCOL'] . ' ' . $response['HTTPCode'] . ' ' . \xbweb::HTTPStatus($response['HTTPCode']));
        header('Content-type: ' . $contentType . '; charset=' . $contentCharset);
        header('X-Product-name: ' . Credits\PRODUCT . '(' . Credits\CORE . '/' . Credits\DBTYPE . ')');
        header('X-Product-version: ' . Credits\VERSION);

        Debug::p('Headers sent');

        /** Output content **/
        if (Request::get('contentType') == 'json') {
            echo json_encode($response);
        } else {
            $response['timing'] = Debug::ps();
            echo View::render($response);
        }
    }