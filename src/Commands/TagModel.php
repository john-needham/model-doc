<?php

namespace Needham\ModelDoc\Commands;

use Illuminate\Console\Command;
use Needham\ModelDoc\Database\Inspector;
use Needham\ModelDoc\Doc;
use Needham\ModelDoc\Models\Discovery;
use Needham\ModelDoc\Writer\Output;
use Needham\ModelDoc\Writer\Tagger;

class TagModel extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'doc:tag';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Tag all models';
    /**
     * @var Discovery
     */
    private $discovery;
    /**
     * @var Inspector
     */
    private $inspector;
    /**
     * @var Output
     */
    private $writer;

    /**
     * Create a new command instance.
     *
     * @param Discovery $discovery
     * @param Inspector $inspector
     * @param Output $output
     */
    public function __construct(
        Discovery $discovery,
        Inspector $inspector,
        Tagger $writer
    )
    {
        parent::__construct();
        $this->discovery = $discovery;
        $this->inspector = $inspector;
        $this->writer = $writer;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $models = $this->discovery->fetchHasStubDoc();

        /**
         * Go through each model and attach the stub docblock
         */
        foreach ($models as $model) {

            $this->writer->tag($model);
        }
    }
}
