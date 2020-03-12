<?php

namespace Needham\ModelDoc\Writer;

use Illuminate\Support\Facades\Storage;
use Needham\ModelDoc\Doc;
use Needham\ModelDoc\Namespaced;

class Output
{
    /**
     * @var string
     */
    private $path;

    public function __construct()
    {
        $this->path = config('model-doc.stubs');
    }

    /**
     * @param Namespaced $ns
     * @return string
     */
    protected function getStubFile(Namespaced $ns) {
        $parts = $ns->getNamespace();
        array_unshift($parts, $this->path);
        $path = implode(DIRECTORY_SEPARATOR, $parts);
        $file = sprintf('%s.php', $ns->getClass());
        return $path = implode(DIRECTORY_SEPARATOR, [$path, $file]);
    }

    /**
     * @param Doc $doc
     */
    public function write(Doc $doc) {

        $class = $doc->getNamespaced();
        $file = $this->getStubFile($class);

        if(strpos($this->path, '.') === 0) {
            $file = base_path() . '/' . $file;
        }

        $contents = view('stubs::class', [
            'source' => $class,
            'stub'   => $class->withAppendedNamespace('Stubs'),
            'doc'    => $doc
        ]);

        file_put_contents($file, $contents);
    }
}
