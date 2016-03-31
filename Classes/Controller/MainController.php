<?php
namespace EdRush\EdrushDependencyTree\Controller;

/***************************************************************
 *
 *  Copyright notice
 *
 *  (c) 2016 Wolfram Eberius <edrush@posteo.de>, StudioBellaFuente
 *
 *  All rights reserved
 *
 *  This script is part of the TYPO3 project. The TYPO3 project is
 *  free software; you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation; either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  The GNU General Public License can be found at
 *  http://www.gnu.org/copyleft/gpl.html.
 *
 *  This script is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  This copyright notice MUST APPEAR in all copies of the script!
 ***************************************************************/
use EdRush\EdrushDependencyTree\Domain\Model\Constraint;
use EdRush\EdrushDependencyTree\Domain\Model\Extension;

/**
 * MainController
 */
class MainController extends \TYPO3\CMS\Extbase\Mvc\Controller\ActionController
{
    const LOCAL_CONFIGURATION_FILENAME = 'LocalConfiguration.php';
    const EXTENSION_CONFIGURATION_FILENAME = 'ext_emconf.php';

    const CONSTRAINT_DEPENDENCY = 'depends';
    const CONSTRAINT_CONFLICT = 'conflicts';
    const CONSTRAINT_SUGGESTION = 'suggests';

    /**
     * action showDependencies
     *
     * @return void
     */
    public function showDependenciesAction()
    {
        // dev
        #error_reporting(E_ALL);
        #ini_set('display_errors', 1);

        $extensions = array();
        $extensionConstraints = array();
        $extensionConfigurationFiles = array();

        // add system extensions
        $systemExtensionsDirectory = PATH_site . 'typo3' . DIRECTORY_SEPARATOR . 'sysext';
        $systemExtensions = scandir($systemExtensionsDirectory);
        foreach ($systemExtensions as $systemExtensioDirectory) {
            $extensionConfigurationFiles[] = $systemExtensionsDirectory . DIRECTORY_SEPARATOR . $systemExtensioDirectory . DIRECTORY_SEPARATOR . self::EXTENSION_CONFIGURATION_FILENAME;
        }

        // add active local extensions
        $localConfigurationFile = PATH_site . 'typo3conf' . DIRECTORY_SEPARATOR . self::LOCAL_CONFIGURATION_FILENAME;
        $configuration = require $localConfigurationFile;

        $activeLocalExtensions = $configuration['EXT']['extConf'];
        foreach ($activeLocalExtensions as $extensionKey => $config) {
            $extensionConfigurationFiles[] = PATH_site . 'typo3conf' . DIRECTORY_SEPARATOR . 'ext' . DIRECTORY_SEPARATOR . $extensionKey . DIRECTORY_SEPARATOR . self::EXTENSION_CONFIGURATION_FILENAME;
        }

        // create extension models
        foreach ($extensionConfigurationFiles as $extensionConfigurationFile) {
            $extensionDirectory = str_replace(DIRECTORY_SEPARATOR . self::EXTENSION_CONFIGURATION_FILENAME, '', $extensionConfigurationFile);
            $extensionDirectoryParts = explode(DIRECTORY_SEPARATOR, $extensionDirectory);
            $extensionKey = array_pop($extensionDirectoryParts);

            if (is_readable($extensionConfigurationFile)) {
                // this is only to prevent IDE warnings
                $EM_CONF = array();
                require $extensionConfigurationFile;
                $extensionConfiguration = array_pop($EM_CONF);

                $extension = new Extension();
                $extension->setKey($extensionKey);
                $extension->setName($extensionConfiguration['title']);
                $extension->setVersion($extensionConfiguration['version']);
                $extensions[$extensionKey] = $extension;
                $extensionConstraints[$extensionKey] = $extensionConfiguration['constraints'];
            }
        }

        // loop through all extensions and add constraints
        foreach ($extensions as $extension) {
            /* @var $extension Extension */
            $extensionKey = $extension->getKey();

            foreach ($extensionConstraints[$extensionKey] as $constraintType => $constraintsGroup) {
                foreach ($constraintsGroup as $constraintExtensionKey => $constraintVersion) {
                    // also display extensions we did not find, e.g. 'typo3' or 'php'
                    if (!isset($extensions[$constraintExtensionKey])) {
                        $extension = new Extension();
                        $extension->setKey($constraintExtensionKey);
                        $extension->setName($constraintExtensionKey);
                        $extensions[$constraintExtensionKey] = $extension;
                    }

                    $constraintExtension = $extensions[$constraintExtensionKey];

                    // set up the constraint
                    $constraint = new Constraint();
                    $constraint->setExtension($constraintExtension);
                    $constraintVersion = ('' != trim($constraintVersion)) ? trim($constraintVersion) : null;
                    $constraint->setVersion($constraintVersion);

                    switch ($constraintType) {
                        case self::CONSTRAINT_CONFLICT:
                            $extension->addConflict($constraint);
                            break;
                        case self::CONSTRAINT_SUGGESTION:
                            $extension->addSuggestion($constraint);
                            break;
                        case self::CONSTRAINT_DEPENDENCY:
                        default:
                            $extension->addDependency($constraint);
                            break;
                    }
                }
            }
        }

        // sort the extensions (just for fun)
        ksort($extensions);

        $this->view->assign('extensions', $extensions);

    }
}
