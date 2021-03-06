<?php

/**
 * Class MockFilesHandler
 */
class MockFilesHandler extends PHPUnit_Framework_BaseTestListener
{
    /**
     * @param PHPUnit_Framework_Test $test
     */
    public function startTest(PHPUnit_Framework_Test $test)
    {
        MockFilesManager::initMockFiles();
    }

    /**
     * @param PHPUnit_Framework_Test $test
     * @param float $time
     */
    public function endTest(PHPUnit_Framework_Test $test, $time)
    {
        MockFilesManager::cleanUpMockFiles();
    }
}

/**
 * Class MockFilesManager
 */
class MockFilesManager
{
    private static $mockFilePaths = array();

    public static function initMockFiles()
    {
        self::copyMockFile('MockCalculatorFactoryFaultyNamespace', 'Calculators/Factories');
        self::copyMockFile('MockCalculatorFactoryBadAncestor', 'Calculators/Factories');
    }

    /**
     * @param $name
     * @param $destination
     * @return string
     */
    private static function copyMockFile($name, $destination)
    {
        $destinationPath = dirname(dirname(__FILE__)) . '/src/' . $destination . '/' . $name . '.php';

        if (!file_exists($destinationPath)) {
            copy(__DIR__ . '/MockFiles/' . $name . '.php', $destinationPath);

            static::$mockFilePaths[] = $destinationPath;
        }
    }

    public static function cleanUpMockFiles()
    {
        foreach (static::$mockFilePaths as $mockFilePath) {
            if (file_exists($mockFilePath)) {
                unlink($mockFilePath);
            }
        }

        static::$mockFilePaths = null;
    }
}