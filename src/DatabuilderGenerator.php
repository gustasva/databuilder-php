<?php

namespace Databuilder;

use Composer\Autoload\ClassLoader;
use DatabuilderTests\_data\Builders\TestDatabuilder;
use DOMException;
use Exception;
use ReflectionClass;
use ReflectionException;

class DatabuilderGenerator
{
    public const DATABUILDER_XML_POSTFIX = '.databuilder.xml';

    public const DATABUILDER_POSTFIX = 'Databuilder.php';

    protected DatabuilderTransformer $transformer;

    public function __construct()
    {
        $this->transformer = new DatabuilderTransformer();
    }

    /**
     * @throws ReflectionException
     * @throws DOMException
     * @throws Exception
     */
    public function generate(): int
    {
        $databuilders = $this->getBuildersNamespaces();
        $databuildersDir = $this->getDatabuilderXmlDir();

        foreach ($databuilders as $builderClass) {
            $builder = new $builderClass();
            $xmlDocument = $this->transformer->transform($builder);

            $xmlDocument->save($databuildersDir . '/' . $builder->getName() . self::DATABUILDER_XML_POSTFIX);
        }

        return 1;
    }

    /**
     * @throws Exception
     */
    protected function getBuildersNamespaces(): array
    {
        $databuildersFilePaths = $this->getDatabuildersFilePaths();
        $namespaces = [];

        foreach ($databuildersFilePaths as $className => $path) {
            $data = file_get_contents($path);

            $namespaceWithoutClass = $this->findDatabuilderNamespace($data);
            $namespaces[] = $namespaceWithoutClass . '\\' . $className;
        }

        return $namespaces;
    }

    protected function findDatabuilderNamespace(string $classContent): string
    {
        preg_match('/(?<=namespace )(.*)(?=;)/', $classContent, $namespace);

        if (!$namespace || !isset($namespace[0])) {
            throw new Exception('An error occured while reading your databuilders namespaces.');
        }

        return $namespace[0];
    }

    protected function getDatabuilderXmlDir(): string
    {
        $reflection = new ReflectionClass(ClassLoader::class);
        $rootDir = dirname($reflection->getFileName(), 3);

        return $rootDir . '/tests/_data';
    }

    protected function getDatabuildersFilePaths(): array
    {
        $xmlDatabuildersDir = $this->getDatabuilderXmlDir();
        $phpDatabuildersDir = $xmlDatabuildersDir . '/Builders';

        $fileNames = scandir($phpDatabuildersDir);

        if (!$fileNames) {
            throw new Exception('An error occured while reading your databuilders directory.');
        }

        $fileNames = $this->addFilenamesToKeys($fileNames);
        $fileNames = $this->filterNonDatabuilders($fileNames);

        return array_map(function (string $databuilderFileName) use ($phpDatabuildersDir) {
            return $phpDatabuildersDir . '/' . $databuilderFileName;
        }, $fileNames);
    }

    protected function filterNonDatabuilders(array $fileNames): array
    {
        return array_filter($fileNames, function (string $path) {
            if (strpos($path, self::DATABUILDER_POSTFIX)) {
                return true;
            }

            return false;
        });
    }

    protected function addFilenamesToKeys(array $fileNames): array
    {
        $fileNamesWithKeys = [];

        foreach ($fileNames as $fileName) {
            $filenameWithoutPhp = str_replace(".php", "", $fileName);
            $fileNamesWithKeys[$filenameWithoutPhp] = $fileName;
        }

        return $fileNamesWithKeys;
    }
}
