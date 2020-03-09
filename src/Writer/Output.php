<?php

namespace Needham\ModelDoc\Writer;

use Illuminate\Support\Facades\Storage;
use Needham\ModelDoc\Doc;

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
     * @param Doc $doc
     */
    public function write(Doc $doc) {
        $file = implode(
            '/', [
                $this->path,
                $doc->getNamespace(),
                $doc->getClassName()
            ]
        ) . '.php';

        if(strpos($this->path, '.') === 0) {
            $file = base_path() . '/' . $file;
        }

        $contents = view('stubs::model', [
            'doc' => $doc
        ]);
        // $stub = (string) $inline;

        $contents = "<?php\n\n".$contents;

        file_put_contents($file, $contents);
    }
}
